@extends('layouts.app');
@section('main')
    <style>
        .hr-boader {
            height: 1px;
            background-color: #474747;
            margin-top:0;
        }

        #profile_display {
            display: block;
            width: 80px;
            margin: 10px auto;
        }

        img,
        svg {
            vertical-align: middle;
        }

        .box {
            width: 250px;
            height: 250px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 20px;
            padding: 20px;
        }

        .btn-font {
            font-size: 1rem;
        }

        .mt-6 {
            margin-top: 3.5rem !important;
        }

        .mf-1 {
            margin-left: 1rem !important;
        }
        .box img {
            box-sizing: border-box;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
    <div class="page-content">
    <form id="createpatientForm" action="{{url('/patients')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex justify-content-between">
                        <div>
                            <a href="{{ url('/patients') }}" class="btn btn-primary"><i
                                    class="bx bx-arrow-back align-middle me-2"></i> Back</a>
                            <h4 style="margin-bottom: -16px;" class="mt-4">Add Patient</h4>
                        </div>
                    </div>
                    <div class="hr-boader">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="mb-3 mt-4 col-md-2">
                    <label for="disabledTextInput" class="form-label">File No. <span class="text-danger">*</span></label>
                    <input type="text" id="file_no" name="file_no" class="form-control @error('file_no') is-invalid @enderror" value="{{$fileNo}}" readonly>
                    @error('file_no')
                    <div class=" invalid-feedback">{{ $message }}</div>
                         @enderror
                </div>

                <div class="col-md-3 mb-3 mt-4 offset-md-7">
                    <label for="disabledTextInput" class="form-label"style=" position: relative; left: 29px;">Registration
                        Date & Time <span class="text-danger">*</span></label>
                    <input type="text" id="registration_date" name="registration_date" class="form-control @error('registration_date') is-invalid @enderror" value="{{ $formattedDateTime }}"
                        style="
                        margin-left: 20px;
                        width: 85%;
                    ">
                            @error('registration_date')
                            <div class=" invalid-feedback">{{ $message }}</div>
                                 @enderror
                </div>
                <div class="col-md-9">

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">First Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control  @error('first_name') is-invalid @enderror " name="first_name" id="first_name" tabindex="1"
                                value="">
                                @error('first_name')
                            <div class=" invalid-feedback">{{ $message }}</div>
                                    @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Father Name</label>
                            <input type="text" class="form-control " tabindex="2" name="father_name" id="father_name"
                                value="">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Date Of Birth <span class="text-danger">*</span></label>
                        <div class="input-daterange input-group @error('date_of_birth') is-invalid @enderror"id="datepicker6" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container="#datepicker6">
                             <input type="text" class="form-control" name="data_of_birth">
                                @error('date_of_birth')
                                <div class=" invalid-feedback">{{ $message }}</div>
                                     @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">UID No <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('uid_number') is-invalid @enderror" name="uid_number" id="uid_number" tabindex="1"
                                value="">
                                @error('uid_number')
                                <div class=" invalid-feedback">{{ $message }}</div>
                                     @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Other ID </label>
                            <input type="number" class="form-control " tabindex="2" name="other_id" id="other_id"
                                value="">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Mobile No <span class="text-danger">*</span> </label>
                            <input type="number" class="form-control @error('mobile_no') is-invalid @enderror" tabindex="2" name="mobile_no" id="mobile_no"
                                value="">
                                @error('mobile_no')
                                <div class=" invalid-feedback">{{ $message }}</div>
                                     @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4  mb-3">
                            <label class="form-label">Gender <span class="text-danger">*</span></label>
                            <select class="form-control @error('gender') is-invalid @enderror" tabindex="9" name="gender" id="gender">
                                <option selected="" disabled=""></option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                            @error('gender')
                            <div class=" invalid-feedback">{{ $message }}</div>
                                 @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Alternative No </label>
                            <input type="text" class="form-control" tabindex="2" name="alternative_no" id="alternative_no"
                                value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label">Address <span class="text-danger">*</span></label>
                            <textarea id="address" name="address" tabindex="10" class="form-control @error('address') is-invalid @enderror" rows="3"></textarea>
                        </div>
                        @error('address')
                        <div class=" invalid-feedback">{{ $message }}</div>
                             @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="box" id="imagePreview"></div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <a href="#" style="display: block; width:85%;" type="button"
                            class="btn btn-success mt-2 pl-4 align-items-center" data-bs-target="#capturePhotoModal"
                            data-bs-toggle="modal">
                            Upload
                        </a>
                    </div>
                    <input type="file" id="photo" name="photo" style="display: none;" accept="image/*">
                </div>
            </div>
            <div class="row  mb-3" style="position: relative;left: 49px;">
                <div class="col-md-3  offset-md-8 pl-2">
                    <div class="d-flex justify-content-center align-items-center ">
                        <button class="btn btn-primary mf-1 btn-font " type="submit">Save Patient</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    </div>
    </div>
    </div>
@endsection
@section('customJs')
<script>
     document.querySelector('.btn-success').addEventListener('click', function (e) {
            e.preventDefault();
            document.getElementById('photo').click();
        });

        document.getElementById('photo').addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    const imagePreview = document.getElementById('imagePreview');
                    imagePreview.innerHTML = '';
                    imagePreview.appendChild(img);
                };
                reader.readAsDataURL(file);
            }
        });
        $(document).ready(function() {
        $('#createpatientForm').submit(function(event) {
            $(".is-invalid").removeClass('is-invalid');
            $(".invalid-feedback").html('');
            var file_no = $("#file_no").val().trim();
            var registration_date = $("#registration_date").val().trim();
            var first_name = $("#first_name").val().trim();
            var uid_number = $("#uid_number").val().trim();
            var mobile_no = $("#mobile_no").val().trim();
            var address = $("#address").val().trim();
            var gender = document.getElementById("gender").value.trim();
            var photo = $("#photo").prop('files')[0];
            var isValid = true;
            if (file_no === '') {
                $("#file_no").addClass('is-invalid').siblings('.invalid-feedback').html('File No. is required.');
                isValid = false;
            }
            if (registration_date === '') {
                $("#registration_date").addClass('is-invalid').siblings('.invalid-feedback').html('Registration Date & Time is required.');
                isValid = false;
            }

            if (first_name === '') {
                $("#first_name").addClass('is-invalid').siblings('.invalid-feedback').html('First Name is required.');
                isValid = false;
            }

            if (uid_number === '') {
                $("#uid_number").addClass('is-invalid').siblings('.invalid-feedback').html('UID No. is required.');
                isValid = false;
            }
            if (uid_number === '') {
                $("#uid_number").addClass('is-invalid').siblings('.invalid-feedback').html('UID No. is required.');
                isValid = false;
            }
            if (mobile_no === '') {
                $("#mobile_no").addClass('is-invalid').siblings('.invalid-feedback').html('Mobile No. is required.');
                isValid = false;
            }
            if (gender === '') {
                $("#gender").addClass('is-invalid').siblings('.invalid-feedback').html('Gender is required.');
                isValid = false;
            }

            if (address === '') {
                $("#address").addClass('is-invalid').siblings('.invalid-feedback').html('Address is required.');
                isValid = false;
            }
            if (photo) {
                var fileSize = photo.size;
                var fileType = photo.type;
                var validExtensions = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/svg'];

                if ($.inArray(fileType, validExtensions) == -1) {
                    $("#photo").addClass('is-invalid').siblings('.invalid-feedback').html('Invalid file type. Please upload an image file.');
                    isValid = false;
                }

                if (fileSize > 2048000) { // Max size in bytes (2MB)
                    $("#photo").addClass('is-invalid').siblings('.invalid-feedback').html('File size exceeds the limit of 2MB.');
                    isValid = false;
                }
            }
            if (!isValid) {
                event.preventDefault();
            }
        });
    });
</script>
@endsection
