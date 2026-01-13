<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;
use App\Helpers\Qs;

class StudentRecordCreate extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // Student name fields
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'surname' => 'required|string|max:100',
            
            // Student basic info
            'dob' => 'required|date',
            'gender' => 'required|in:Male,Female',
            'photo' => 'required|image|mimes:jpeg,gif,png,jpg|max:2048',
            
            // Student academic info
            'my_class_id' => 'required|integer|exists:my_classes,id',
            
            // Optional fields
            'nemis_number' => 'nullable|string|max:50',
            'previous_school' => 'nullable|string|max:200',
            'birth_certificate' => 'nullable|file|mimes:jpeg,gif,png,jpg,pdf|max:5120',
            'admission_fee_paid' => 'nullable|boolean',
            
            // Parent/Guardian - at least one required
            'father_first_name' => 'nullable|required_with:father_last_name,father_id_number,father_phone_number|string|max:100',
            'father_last_name' => 'nullable|required_with:father_first_name|string|max:100',
            'father_id_number' => 'nullable|required_with:father_first_name|string|max:50',
            'father_phone_number' => 'nullable|required_with:father_first_name|string|max:20',
            
            'mother_first_name' => 'nullable|required_with:mother_last_name,mother_id_number,mother_phone_number|string|max:100',
            'mother_last_name' => 'nullable|required_with:mother_first_name|string|max:100',
            'mother_id_number' => 'nullable|required_with:mother_first_name|string|max:50',
            'mother_phone_number' => 'nullable|required_with:mother_first_name|string|max:20',
            
            'guardian_first_name' => 'nullable|required_with:guardian_last_name,guardian_id_number,guardian_phone_number|string|max:100',
            'guardian_last_name' => 'nullable|required_with:guardian_first_name|string|max:100',
            'guardian_id_number' => 'nullable|required_with:guardian_first_name|string|max:50',
            'guardian_phone_number' => 'nullable|required_with:guardian_first_name|string|max:20',
        ];
    }
    
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $father = !empty(request('father_first_name'));
            $mother = !empty(request('mother_first_name'));
            $guardian = !empty(request('guardian_first_name'));
            
            if (!$father && !$mother && !$guardian) {
                $validator->errors()->add('parents', 'At least one parent or guardian must be provided.');
            }
        });
    }

    public function attributes()
    {
        return  [
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'surname' => 'Surname',
            'dob' => 'Date of Birth',
            'gender' => 'Gender',
            'photo' => 'Photo',
            'my_class_id' => 'Grade',
            'nemis_number' => 'NEMIS Number',
            'previous_school' => 'Previous School',
            'birth_certificate' => 'Birth Certificate',
            'father_first_name' => 'Father First Name',
            'father_last_name' => 'Father Last Name',
            'father_id_number' => 'Father ID Number',
            'father_phone_number' => 'Father Phone Number',
            'mother_first_name' => 'Mother First Name',
            'mother_last_name' => 'Mother Last Name',
            'mother_id_number' => 'Mother ID Number',
            'mother_phone_number' => 'Mother Phone Number',
            'guardian_first_name' => 'Guardian First Name',
            'guardian_last_name' => 'Guardian Last Name',
            'guardian_id_number' => 'Guardian ID Number',
            'guardian_phone_number' => 'Guardian Phone Number',
        ];
    }

    protected function getValidatorInstance()
    {
        $input = $this->all();

        // Only decode my_parent_id if it exists (for backward compatibility)
        if (isset($input['my_parent_id']) && !empty($input['my_parent_id'])) {
            $input['my_parent_id'] = Qs::decodeHash($input['my_parent_id']);
        } else {
            $input['my_parent_id'] = NULL;
        }

        // Ensure my_class_id is an integer if provided
        if (isset($input['my_class_id']) && !empty($input['my_class_id'])) {
            $input['my_class_id'] = (int) $input['my_class_id'];
        }

        $this->getInputSource()->replace($input);

        return parent::getValidatorInstance();
    }
}
