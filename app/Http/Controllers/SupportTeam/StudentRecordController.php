<?php

namespace App\Http\Controllers\SupportTeam;

use App\Helpers\Qs;
use App\Helpers\Mk;
use App\Http\Requests\Student\StudentRecordCreate;
use App\Http\Requests\Student\StudentRecordUpdate;
use App\Models\StudentParent;
use App\Repositories\LocationRepo;
use App\Repositories\MyClassRepo;
use App\Repositories\StudentRepo;
use App\Repositories\UserRepo;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StudentRecordController extends Controller
{
    protected $loc, $my_class, $user, $student;

   public function __construct(LocationRepo $loc, MyClassRepo $my_class, UserRepo $user, StudentRepo $student)
   {
       $this->middleware('teamSA', ['only' => ['edit','update', 'reset_pass', 'create', 'store', 'graduated'] ]);
       $this->middleware('super_admin', ['only' => ['destroy',] ]);

        $this->loc = $loc;
        $this->my_class = $my_class;
        $this->user = $user;
        $this->student = $student;
   }

    public function reset_pass($st_id)
    {
        $st_id = Qs::decodeHash($st_id);
        $data['password'] = Hash::make('student');
        $this->user->update($st_id, $data);
        return back()->with('flash_success', __('msg.p_reset'));
    }

    public function create()
    {
        $data['my_classes'] = $this->my_class->all();
        $data['parents'] = $this->user->getUserByType('parent');
        return view('pages.support_team.students.add', $data);
    }

    public function store(StudentRecordCreate $req)
    {
        // Prepare user data
        $data = $req->only(['dob', 'gender']);
        $data['user_type'] = 'student';
        
        // Combine name fields
        $data['first_name'] = ucwords($req->first_name);
        $data['last_name'] = ucwords($req->last_name);
        $data['surname'] = ucwords($req->surname);
        $data['name'] = $data['first_name'] . ' ' . $data['last_name'] . ' ' . $data['surname'];
        
        $data['code'] = strtoupper(Str::random(10));
        $data['password'] = Hash::make('student');
        $data['photo'] = Qs::getDefaultUserImage();
        
        $class = $this->my_class->find($req->my_class_id);
        if (!$class || !$class->class_type_id) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Invalid grade selected. Please select a valid grade.'
            ], 422);
        }
        $ct = $this->my_class->findTypeByClass($req->my_class_id)->code;
        $year = date('Y');
        $data['username'] = strtoupper(Qs::getAppCode().'/'.$ct.'/'.$year.'/'.mt_rand(1000, 99999));

        // Handle photo upload
        if($req->hasFile('photo')) {
            $photo = $req->file('photo');
            $f = Qs::getFileMetaData($photo);
            $f['name'] = 'photo.' . $f['ext'];
            $f['path'] = $photo->storeAs(Qs::getUploadPath('student').$data['code'], $f['name']);
            $data['photo'] = asset('storage/' . $f['path']);
        }

        $user = $this->user->create($data); // Create User

        // Get default section for the class (first section or create one)
        $section = \App\Models\Section::where('my_class_id', $req->my_class_id)->first();
        if (!$section) {
            // Create a default section if none exists
            $section = \App\Models\Section::create([
                'name' => 'A',
                'my_class_id' => $req->my_class_id,
                'active' => 1
            ]);
        }
        
        // Prepare student record data
        $sr = [
            'user_id' => $user->id,
            'my_class_id' => $req->my_class_id,
            'section_id' => $section->id,
            'adm_no' => $data['username'],
            'session' => Qs::getSetting('current_session'),
            'year_admitted' => $year,
            'nemis_number' => $req->nemis_number,
            'previous_school' => $req->previous_school,
            'admission_fee_paid' => $req->has('admission_fee_paid') ? 1 : 0,
        ];

        // Handle birth certificate upload
        if($req->hasFile('birth_certificate')) {
            $bc = $req->file('birth_certificate');
            $f = Qs::getFileMetaData($bc);
            $f['name'] = 'birth_certificate.' . $f['ext'];
            $f['path'] = $bc->storeAs(Qs::getUploadPath('student').$data['code'], $f['name']);
            $sr['birth_certificate_path'] = asset('storage/' . $f['path']);
        }

        $studentRecord = $this->student->createRecord($sr); // Create Student Record

        // Create parent/guardian records
        $parents = [];
        
        if($req->father_first_name) {
            $parents[] = [
                'student_record_id' => $studentRecord->id,
                'relationship' => 'father',
                'first_name' => ucwords($req->father_first_name),
                'last_name' => ucwords($req->father_last_name),
                'id_number' => $req->father_id_number,
                'phone_number' => $req->father_phone_number,
            ];
        }
        
        if($req->mother_first_name) {
            $parents[] = [
                'student_record_id' => $studentRecord->id,
                'relationship' => 'mother',
                'first_name' => ucwords($req->mother_first_name),
                'last_name' => ucwords($req->mother_last_name),
                'id_number' => $req->mother_id_number,
                'phone_number' => $req->mother_phone_number,
            ];
        }
        
        if($req->guardian_first_name) {
            $parents[] = [
                'student_record_id' => $studentRecord->id,
                'relationship' => 'guardian',
                'first_name' => ucwords($req->guardian_first_name),
                'last_name' => ucwords($req->guardian_last_name),
                'id_number' => $req->guardian_id_number,
                'phone_number' => $req->guardian_phone_number,
            ];
        }
        
        foreach($parents as $parent) {
            \App\Models\StudentParent::create($parent);
        }

        // Return success with student record ID for document generation
        return response()->json([
            'status' => 'success',
            'message' => 'Student admitted successfully',
            'student_record_id' => Qs::hash($studentRecord->id),
            'admission_number' => $data['username'],
            'redirect_url' => url('students/' . Qs::hash($studentRecord->id))
        ]);
    }

    public function listByClass($class_id)
    {
        $data['my_class'] = $mc = $this->my_class->getMC(['id' => $class_id])->first();
        $data['students'] = $this->student->findStudentsByClass($class_id);
        $data['sections'] = $this->my_class->getClassSections($class_id);

        return is_null($mc) ? Qs::goWithDanger() : view('pages.support_team.students.list', $data);
    }

    public function graduated()
    {
        $data['my_classes'] = $this->my_class->all();
        $data['students'] = $this->student->allGradStudents();

        return view('pages.support_team.students.graduated', $data);
    }

    public function not_graduated($sr_id)
    {
        $d['grad'] = 0;
        $d['grad_date'] = NULL;
        $d['session'] = Qs::getSetting('current_session');
        $this->student->updateRecord($sr_id, $d);

        return back()->with('flash_success', __('msg.update_ok'));
    }

    public function show($sr_id)
    {
        $sr_id = Qs::decodeHash($sr_id);
        if(!$sr_id){return Qs::goWithDanger();}

        $data['sr'] = $this->student->getRecord(['id' => $sr_id])->first();

        /* Prevent Other Students/Parents from viewing Profile of others */
        if(Auth::user()->id != $data['sr']->user_id && !Qs::userIsTeamSAT() && !Qs::userIsMyChild($data['sr']->user_id, Auth::user()->id)){
            return redirect(route('dashboard'))->with('pop_error', __('msg.denied'));
        }

        return view('pages.support_team.students.show', $data);
    }

    public function edit($sr_id)
    {
        $sr_id = Qs::decodeHash($sr_id);
        if(!$sr_id){return Qs::goWithDanger();}

        $data['sr'] = $this->student->getRecord(['id' => $sr_id])->first();
        $data['my_classes'] = $this->my_class->all();
        $data['parents'] = $this->user->getUserByType('parent');
        $data['states'] = $this->loc->getStates();
        $data['nationals'] = $this->loc->getAllNationals();
        return view('pages.support_team.students.edit', $data);
    }

    public function update(StudentRecordUpdate $req, $sr_id)
    {
        $sr_id = Qs::decodeHash($sr_id);
        if(!$sr_id){return Qs::goWithDanger();}

        $sr = $this->student->getRecord(['id' => $sr_id])->first();
        // Exclude address, state_id, lga_id, nal_id for students
        $d = $req->only(['name', 'email', 'phone', 'phone2', 'dob', 'gender', 'bg_id']);
        $d['name'] = ucwords($req->name);

        if($req->hasFile('photo')) {
            $photo = $req->file('photo');
            $f = Qs::getFileMetaData($photo);
            $f['name'] = 'photo.' . $f['ext'];
            $f['path'] = $photo->storeAs(Qs::getUploadPath('student').$sr->user->code, $f['name']);
            $d['photo'] = asset('storage/' . $f['path']);
        }

        $this->user->update($sr->user->id, $d); // Update User Details

        $srec = $req->only(Qs::getStudentData());
        
        // Automatically assign section based on class (get first section or create default)
        $section = \App\Models\Section::where('my_class_id', $srec['my_class_id'])->first();
        if (!$section) {
            $section = \App\Models\Section::create([
                'name' => 'A',
                'my_class_id' => $srec['my_class_id'],
                'active' => 1
            ]);
        }
        $srec['section_id'] = $section->id;

        $this->student->updateRecord($sr_id, $srec); // Update St Rec

        /*** If Class/Section is Changed in Same Year, Delete Marks/ExamRecord of Previous Class/Section ****/
        Mk::deleteOldRecord($sr->user->id, $srec['my_class_id']);

        return Qs::jsonUpdateOk();
    }

    public function destroy($st_id)
    {
        $st_id = Qs::decodeHash($st_id);
        if(!$st_id){return Qs::goWithDanger();}

        $sr = $this->student->getRecord(['user_id' => $st_id])->first();
        $path = Qs::getUploadPath('student').$sr->user->code;
        Storage::exists($path) ? Storage::deleteDirectory($path) : false;
        $this->user->delete($sr->user->id);

        return back()->with('flash_success', __('msg.del_ok'));
    }

    public function generateAdmissionDocument($sr_id)
    {
        $sr_id = Qs::decodeHash($sr_id);
        if(!$sr_id){return Qs::goWithDanger();}

        $data['sr'] = $this->student->getRecord(['id' => $sr_id])->first();
        $data['parents'] = StudentParent::where('student_record_id', $sr_id)->get();
        
        // Generate PDF using dompdf
        $pdf = \PDF::loadView('pages.support_team.students.admission_document', $data);
        return $pdf->download('admission_document_' . $data['sr']->adm_no . '.pdf');
    }

    public function generateFeeBalanceForm($sr_id)
    {
        $sr_id = Qs::decodeHash($sr_id);
        if(!$sr_id){return Qs::goWithDanger();}

        $data['sr'] = $this->student->getRecord(['id' => $sr_id])->first();
        $data['admission_fee_paid'] = $data['sr']->admission_fee_paid;
        
        // Generate PDF using dompdf
        $pdf = \PDF::loadView('pages.support_team.students.fee_balance_form', $data);
        return $pdf->download('fee_balance_' . $data['sr']->adm_no . '.pdf');
    }

}
