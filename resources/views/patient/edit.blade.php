@extends('layouts.app');
@section('title', 'Patients')
@section('main')
    <style>
        .hr-boader {
            margin-top:0;
            height: 1px;
            background-color: #474747;
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
    <form id="EditpatientForm" action="{{ route('patients.update', $patient->id) }}" method="Post" enctype="multipart/form-data">
        @csrf
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex justify-content-between">
                        <div>
                            <a href="{{ url('/patients') }}" class="btn btn-primary"><i
                                    class="bx bx-arrow-back align-middle me-2"></i> Back</a>
                            <h4 style="margin-bottom: -16px;" class="mt-4">Patient information</h4>
                        </div>
                    </div>
                    <div class="hr-boader">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="mb-3 mt-4 col-md-2">
                    <label for="" class="form-label">File No. <span class="text-danger">*</span></label>
                    <input type="text" id="file_no" name="file_no"
                           class="form-control @error('file_no') is-invalid @enderror"
                           value="{{ old('file_no', $patient->file_no) }}" tabindex="1">
                    @error('file_no')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3 mb-3 mt-4 offset-md-7">
                    <label for="disabledTextInput" class="form-label"style=" position: relative; left: 29px;">Registration
                        Date & Time <span class="text-danger">*</span></label>
                    <input type="text" id="registration_date" name="registration_date" class="form-control @error('registration_date') is-invalid @enderror"   value="{{$patient->registration_date}}"
                        style="
                        margin-left: 20px;
                        width: 85%;
                    " readonly tabindex="2">
                            @error('registration_date')
                            <div class=" invalid-feedback">{{ $message }}</div>
                                 @enderror
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">First Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control  @error('first_name') is-invalid @enderror" tabindex="2" name="first_name" id="first_name" value="{{ old('first_name', $patient->first_name) }}">
                            <p></p>
                                @error('first_name')
                            <div class=" invalid-feedback">{{ $message }}</div>
                                    @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Father Name</label>
                            <input type="text" class="form-control" tabindex="3" name="father_name" id="father_name"
                                value="{{ old('father_name', $patient->father_name) }}" >
                                <p></p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Date Of Birth <span class="text-danger">*</span></label>
                        <div class="input-daterange input-group @error('date_of_birth') is-invalid @enderror"id="datepicker6" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container="#datepicker6" tabindex="4">
                             <input type="text" class="form-control" name="data_of_birth" autocomplete="off" value="{{ old('data_of_birth', $patient->data_of_birth) }}">
                             <p></p>
                                @error('date_of_birth')
                                <div class=" invalid-feedback">{{ $message }}</div>
                                     @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">UID No <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('uid_number') is-invalid @enderror" name="uid_number" id="uid_number" tabindex="5"  value="{{ old('uid_number', $patient->uid_number) }}">
                            <p></p>
                            @error('uid_number')
                            <div class=" invalid-feedback">{{ $message }}</div>
                                     @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Other ID </label>
                            <input type="number" class="form-control " tabindex="6" name="other_id" id="other_id"
                                value="{{ old('other_id', $patient->other_id) }}">
                                <p></p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Mobile No <span class="text-danger">*</span> </label>
                            <input type="number" class="form-control @error('mobile_no') is-invalid @enderror"  tabindex="7" name="mobile_no" id="mobile_no"   value="{{ old('mobile_no', $patient->mobile_no) }}">
                            <p></p>
                                @error('mobile_no')
                                <div class=" invalid-feedback">{{ $message }}</div>
                                     @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4  mb-3">
                            <label class="form-label">Gender <span class="text-danger">*</span></label>
                            <select class="form-control @error('gender') is-invalid @enderror" tabindex="8" name="gender" id="gender">
                                <option value="Male" {{($patient->gender == 'Male') ? 'selected' : ''}}>Male</option>
                                <option value="Female" {{($patient->gender == 'Female') ? 'selected' : ''}}>Female</option>
                                <option value="Other" {{($patient->gender == 'Other') ? 'selected' : ''}}>Other</option>
                            </select>
                            @error('gender')
                            <div class=" invalid-feedback">{{ $message }}</div>
                                 @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Alternative No </label>
                            <input type="text" class="form-control" tabindex="8" name="alternative_no" id="alternative_no"
                                value="{{ old('alternative_no', $patient->alternative_no) }}">
                                <p></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label">Address <span class="text-danger">*</span></label>
                            <textarea id="address" name="address" tabindex="9" class="form-control @error('address') is-invalid @enderror" rows="3" tabindex="9">{{ old('address', $patient->address) }}</textarea>
                        </div>
                        <p></p>
                        @error('address')
                        <div class=" invalid-feedback">{{ $message }}</div>
                             @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="box" id="imagePreview">
                            @if ($patient->Image)
                            <img src="{{ asset('public/media/photos').'/'.$patient->Image }}" alt="{{ $patient->name }}'s photo" width="50" height="50" class="rounded photo-thumbnail">
                            @else
                            <img src="{{ asset('public/media/photos').'/'.'no-photo.png' }}" alt="{{ $patient->name }}'s photo" width="50" height="50" class="rounded photo-thumbnail">
                             @endif
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn btn-primary mt-2 waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#capimage" tabindex="10">
                            Capture
                          </button>
                    </div>
                    <input type="file" id="photo" name="photo" style="display: none;" accept="image/*">
                </div>
            </div>
            <div class="row  mb-3" style="position: relative;left: 49px;">
                <div class="col-md-3  offset-md-8 pl-2">
                    <div class="d-flex justify-content-center align-items-center ">
                        <button type="button" class="btn btn-primary btn-font" tabindex="12" data-bs-toggle="modal" data-bs-target=".transaction-detailModal">
                            Upload Docs
                        </button>
                        <button class="btn btn-primary mf-1 btn-font " type="submit" tabindex="11">Save</button>
                    </div>
                </div>
            </div>
    <div class="modal fade" id="capimage" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Capture photo</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-center">
                    <canvas id="captured-image" class="d-none"></canvas>
                    <video id="camera-preview" width="500" height="300" autoplay></video>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" id="captureBtn">Capture</button>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection
@section('customJs')
<script>
    var imageData = '';
$('#capimage').on('shown.bs.modal', function () {
  if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
    navigator.mediaDevices.getUserMedia({ video: true })
      .then(function(stream) {
        var video = document.getElementById('camera-preview');
        video.srcObject = stream;
        video.play();
      })
      .catch(function(error) {
        console.log('Error accessing the camera:', error);
      });
  } else {
    console.log('getUserMedia is not supported');
  }
});

$('#captureBtn').on('click', function(e) {
  e.preventDefault();

  var video = document.getElementById('camera-preview');

  var canvas = document.getElementById('captured-image');
  var context = canvas.getContext('2d');
  canvas.width = video.videoWidth;
  canvas.height = video.videoHeight;
  context.drawImage(video, 0, 0, canvas.width, canvas.height);

  // Save the image data
  imageData = canvas.toDataURL('image/png');

  // Set the image preview
  var imagePreview = document.getElementById('imagePreview');
  imagePreview.innerHTML = '<img src="' + imageData + '" alt="Captured Image">';
  var byteString = atob(imageData.split(',')[1]);
  var mimeString = imageData.split(',')[0].split(':')[1].split(';')[0];
  var ab = new ArrayBuffer(byteString.length);
  var ia = new Uint8Array(ab);
  for (var i = 0; i < byteString.length; i++) {
    ia[i] = byteString.charCodeAt(i);
  }
  var blob = new Blob([ab], { type: mimeString });
  var file = new File([blob], "photo.png", { type: mimeString });

  // Set the file input
  var photoInput = document.getElementById('photo');
  var dataTransfer = new DataTransfer();
  dataTransfer.items.add(file);
  photoInput.files = dataTransfer.files;
});
        $("body").on('click', '.delete-btn', function () {
        var id = $(this).attr('id')
        if (confirm('Are you sure you want to delete this record?')) {
             window.location.href = "{{url('/document/delete/')}}/"+id
     }
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
            $('#EditpatientForm').submit(function(event) {
                var file_no = $("#file_no").val().trim();
                var registration_date = $("#registration_date").val().trim();
                var first_name = $("#first_name").val().trim();
                var uid_number = $("#uid_number").val();
                var mobile_no = $("#mobile_no").val().trim();
                var address = $("#address").val().trim();
                var data_of_birth = $("#data_of_birth").val()
                var gender = document.getElementById("gender").value.trim();
                var photo = $("#photo").prop('files')[0];
                var isValid = true;
                if (file_no === '') {
                    $("#file_no").addClass('is-invalid').siblings('.invalid-feedback').html(
                        'File No. is required.');
                    isValid = false;
                }
                if (registration_date === '') {
                    $("#registration_date").addClass('is-invalid').siblings('.invalid-feedback').html(
                        'Registration Date & Time is required.');
                    isValid = false;
                }
                if (data_of_birth === '') {
                    $("#data_of_birth").addClass('is-invalid').siblings('.invalid-feedback').html(
                        'Date of Birth is required.');
                    isValid = false;
                }

                if (first_name === '') {
                    $("#first_name").addClass('is-invalid').siblings('p').addClass(
                        'invalid-feedback').html('First Name is required.');
                    isValid = false;
                } else {
                    $("#first_name").removeClass('is-invalid').siblings('p').removeClass(
                        'invalid-feedback').html('');
                }
                if (uid_number === '') {
                    $("#uid_number").addClass('is-invalid').siblings('p').addClass(
                        'invalid-feedback').html('Addhar Number is required.');
                    isValid = false;
                } else if (uid_number.length !== 12 || !/^\d{12}$/.test(uid_number)) {
                    $("#uid_number").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(
                        'UID No. must be exactly 12 digits.');
                    isValid = false;
                } else {
                    $("#uid_number").removeClass('is-invalid').siblings('p').removeClass(
                        'invalid-feedback').html('');
                }
                if (mobile_no === '') {
                    $("#mobile_no").addClass('is-invalid').siblings('p').addClass(
                        'invalid-feedback').html('Mobile No. is required.');
                        isValid = false;
                     }else{
                        $("#mobile_no").removeClass('is-invalid').siblings('p').removeClass(
                            'invalid-feedback').html('');
                     }
                if (gender === '') {
                    $("#gender").addClass('is-invalid').siblings('.invalid-feedback').html(
                        'Gender is required.');
                    isValid = false;
                }
                if (address === '') {
                    $("#address").addClass('is-invalid').siblings('p').addClass(
                        'invalid-feedback').html('Address is required.');
                    isValid = false;
                }else{
                    $("#address").removeClass('is-invalid').siblings('p').removeClass(
                        'invalid-feedback').html('');
                }

                if (!isValid) {
                    event.preventDefault();
                }
            });
        });
</script>
@endsection
