@extends('layouts.master')
@section('page_title', 'Admit Student')
@section('content')
<style>
    .camera-btn {
        margin-top: 5px;
    }
    .parent-section {
        border: 1px solid #ddd;
        padding: 15px;
        margin-bottom: 15px;
        border-radius: 5px;
    }
</style>
<div class="card">
    <div class="card-header bg-white header-elements-inline">
        <h6 class="card-title">Please fill The form Below To Admit A New Student</h6>
        {!! Qs::getPanelOptions() !!}
    </div>

    <form id="ajax-reg" method="post" enctype="multipart/form-data" class="wizard-form steps-validation" action="{{ route('students.store') }}" data-fouc>
        @csrf
        
        <!-- Student Information -->
        <h6>Student Information</h6>
        <fieldset>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>First Name: <span class="text-danger">*</span></label>
                        <input value="{{ old('first_name') }}" required type="text" name="first_name" placeholder="First Name" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Last Name: <span class="text-danger">*</span></label>
                        <input value="{{ old('last_name') }}" required type="text" name="last_name" placeholder="Last Name" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Surname: <span class="text-danger">*</span></label>
                        <input value="{{ old('surname') }}" required type="text" name="surname" placeholder="Surname" class="form-control">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Date of Birth: <span class="text-danger">*</span></label>
                        <input name="dob" value="{{ old('dob') }}" type="text" class="form-control date-pick" placeholder="Select Date..." required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="gender">Gender: <span class="text-danger">*</span></label>
                        <select class="select form-control" id="gender" name="gender" required data-fouc data-placeholder="Choose..">
                            <option value=""></option>
                            <option {{ (old('gender') == 'Male') ? 'selected' : '' }} value="Male">Male</option>
                            <option {{ (old('gender') == 'Female') ? 'selected' : '' }} value="Female">Female</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="my_class_id">Grade: <span class="text-danger">*</span></label>
                        <select data-placeholder="Choose..." required name="my_class_id" id="my_class_id" class="select-search form-control">
                            <option value=""></option>
                            @foreach($my_classes as $c)
                                <option {{ (old('my_class_id') == $c->id ? 'selected' : '') }} value="{{ $c->id }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="d-block">Student Photo: <span class="text-danger">*</span></label>
                        <input id="photo-input" accept="image/*" type="file" name="photo" class="form-input-styled" data-fouc>
                        <button type="button" class="btn btn-sm btn-primary camera-btn" onclick="capturePhoto()">
                            <i class="icon-camera"></i> Take Photo
                        </button>
                        <video id="video" style="display:none; width:100%; max-width:300px; margin-top:10px;"></video>
                        <canvas id="canvas" style="display:none;"></canvas>
                        <span class="form-text text-muted">Accepted Images: jpeg, png. Max file size 2Mb</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>NEMIS Number: </label>
                        <input value="{{ old('nemis_number') }}" type="text" name="nemis_number" placeholder="NEMIS Number (Optional)" class="form-control">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Previous School: </label>
                        <input value="{{ old('previous_school') }}" type="text" name="previous_school" placeholder="Previous School" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="d-block">Birth Certificate: </label>
                        <input id="birth-cert-input" accept="image/*,.pdf" type="file" name="birth_certificate" class="form-input-styled" data-fouc>
                        <button type="button" class="btn btn-sm btn-primary camera-btn" onclick="captureBirthCert()">
                            <i class="icon-camera"></i> Take Photo
                        </button>
                        <span class="form-text text-muted">Upload document or take photo</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="d-block">Paid Admission Fee: </label>
                        <div class="form-check">
                            <input type="checkbox" name="admission_fee_paid" value="1" class="form-check-input" id="admission_fee_paid" {{ old('admission_fee_paid') ? 'checked' : '' }}>
                            <label class="form-check-label" for="admission_fee_paid">
                                Check if admission fee has been paid (if not checked, it will be included in fees)
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>

        <!-- Parent/Guardian Information -->
        <h6>Parent/Guardian Information (At least one required)</h6>
        <fieldset>
            <!-- Father -->
            <div class="parent-section">
                <h6>Father</h6>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>First Name: </label>
                            <input value="{{ old('father_first_name') }}" type="text" name="father_first_name" placeholder="First Name" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Last Name: </label>
                            <input value="{{ old('father_last_name') }}" type="text" name="father_last_name" placeholder="Last Name" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>ID Number: </label>
                            <input value="{{ old('father_id_number') }}" type="text" name="father_id_number" placeholder="ID Number" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Phone Number: </label>
                            <input value="{{ old('father_phone_number') }}" type="text" name="father_phone_number" placeholder="Phone Number" class="form-control">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mother -->
            <div class="parent-section">
                <h6>Mother</h6>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>First Name: </label>
                            <input value="{{ old('mother_first_name') }}" type="text" name="mother_first_name" placeholder="First Name" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Last Name: </label>
                            <input value="{{ old('mother_last_name') }}" type="text" name="mother_last_name" placeholder="Last Name" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>ID Number: </label>
                            <input value="{{ old('mother_id_number') }}" type="text" name="mother_id_number" placeholder="ID Number" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Phone Number: </label>
                            <input value="{{ old('mother_phone_number') }}" type="text" name="mother_phone_number" placeholder="Phone Number" class="form-control">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Guardian/Alternative Contact -->
            <div class="parent-section">
                <h6>Guardian/Alternative Contact</h6>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>First Name: </label>
                            <input value="{{ old('guardian_first_name') }}" type="text" name="guardian_first_name" placeholder="First Name" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Last Name: </label>
                            <input value="{{ old('guardian_last_name') }}" type="text" name="guardian_last_name" placeholder="Last Name" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>ID Number: </label>
                            <input value="{{ old('guardian_id_number') }}" type="text" name="guardian_id_number" placeholder="ID Number" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Phone Number: </label>
                            <input value="{{ old('guardian_phone_number') }}" type="text" name="guardian_phone_number" placeholder="Phone Number" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>

        <!-- Action Buttons -->
        <h6>Actions</h6>
        <fieldset>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Save Student</button>
                        <button type="button" class="btn btn-success" id="generate-admission-doc" style="display:none;">Generate Admission Document</button>
                        <button type="button" class="btn btn-info" id="generate-fee-balance" style="display:none;">Generate Fee Balance Form</button>
                    </div>
                </div>
            </div>
        </fieldset>
    </form>
</div>

<script>
let stream = null;

function capturePhoto() {
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const photoInput = document.getElementById('photo-input');
    
    if (stream) {
        // Stop existing stream
        stream.getTracks().forEach(track => track.stop());
        stream = null;
        video.style.display = 'none';
        return;
    }
    
    navigator.mediaDevices.getUserMedia({ video: true })
        .then(function(mediaStream) {
            stream = mediaStream;
            video.srcObject = mediaStream;
            video.style.display = 'block';
            video.play();
            
            // Add capture button
            const captureBtn = document.createElement('button');
            captureBtn.type = 'button';
            captureBtn.className = 'btn btn-sm btn-success';
            captureBtn.textContent = 'Capture';
            captureBtn.onclick = function() {
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                canvas.getContext('2d').drawImage(video, 0, 0);
                
                canvas.toBlob(function(blob) {
                    const file = new File([blob], 'photo.jpg', { type: 'image/jpeg' });
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    photoInput.files = dataTransfer.files;
                    
                    stream.getTracks().forEach(track => track.stop());
                    stream = null;
                    video.style.display = 'none';
                    captureBtn.remove();
                }, 'image/jpeg');
            };
            document.querySelector('.camera-btn').after(captureBtn);
        })
        .catch(function(err) {
            alert('Error accessing camera: ' + err.message);
        });
}

function captureBirthCert() {
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const birthCertInput = document.getElementById('birth-cert-input');
    
    if (stream) {
        stream.getTracks().forEach(track => track.stop());
        stream = null;
        video.style.display = 'none';
        return;
    }
    
    navigator.mediaDevices.getUserMedia({ video: true })
        .then(function(mediaStream) {
            stream = mediaStream;
            video.srcObject = mediaStream;
            video.style.display = 'block';
            video.play();
            
            const captureBtn = document.createElement('button');
            captureBtn.type = 'button';
            captureBtn.className = 'btn btn-sm btn-success';
            captureBtn.textContent = 'Capture';
            captureBtn.onclick = function() {
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                canvas.getContext('2d').drawImage(video, 0, 0);
                
                canvas.toBlob(function(blob) {
                    const file = new File([blob], 'birth_certificate.jpg', { type: 'image/jpeg' });
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    birthCertInput.files = dataTransfer.files;
                    
                    stream.getTracks().forEach(track => track.stop());
                    stream = null;
                    video.style.display = 'none';
                    captureBtn.remove();
                }, 'image/jpeg');
            };
            document.querySelectorAll('.camera-btn')[1].after(captureBtn);
        })
        .catch(function(err) {
            alert('Error accessing camera: ' + err.message);
        });
}

// Override the default submitForm success handler for this form
$(document).ready(function() {
    $('form#ajax-reg').on('submit', function(ev){
        ev.preventDefault();
        var form = $(this);
        var btn = form.find('button[type=submit]');
        disableBtn(btn);
        
        var ajaxOptions = {
            url: form.attr('action'),
            type: 'POST',
            cache: false,
            processData: false,
            dataType: 'json',
            contentType: false,
            data: new FormData(form[0])
        };
        
        var req = $.ajax(ajaxOptions);
        req.done(function(resp){
            if(resp.status == 'success' && resp.student_record_id) {
                flash({msg: resp.message || 'Student admitted successfully!', type: 'success'});
                
                // Redirect to student profile after a short delay
                if(resp.redirect_url) {
                    setTimeout(function() {
                        window.location.href = resp.redirect_url;
                    }, 1000);
                } else {
                    // Fallback: redirect using student_record_id
                    setTimeout(function() {
                        window.location.href = '{{ url("students") }}/' + resp.student_record_id;
                    }, 1000);
                }
            } else {
                resp.ok && resp.msg
                    ? flash({msg: resp.msg, type: 'success'})
                    : flash({msg: resp.msg || 'Error occurred', type: 'danger'});
                enableBtn(btn);
                scrollTo('body');
            }
        });
        
        req.fail(function(e){
            if (e.status == 422){
                var errors = e.responseJSON.errors;
                displayAjaxErr(errors);
            }
            if(e.status == 500){
                displayAjaxErr([e.status + ' ' + e.statusText + ' Please Check for Duplicate entry or Contact School Administrator/IT Personnel']);
            }
            enableBtn(btn);
        });
    });
});
</script>
@endsection
