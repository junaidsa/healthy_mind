@extends('layouts.app');
@section('title', 'Create Bill')
@section('main')
    <style>
        .hr-boader {
            margin-top: 0;
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
        <form id="createpatientForm" action="" method="Post"
            enctype="multipart/form-data">
            @csrf
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex justify-content-between">
                            <div>
                                <a href="{{ url('/patients') }}" class="btn btn-primary"><i
                                        class="bx bx-arrow-back align-middle me-2"></i> Back</a>
                                <h4 style="margin-bottom: -16px;" class="mt-4">Edit Bill</h4>
                            </div>
                            <div>
                                <a href="{{ url('/patients') }}" class="btn btn-success">Old History</a>
                            </div>
                        </div>
                        <div class="hr-boader">
                        </div>
                    </div>
                    @php
                    $patient =  DB::table('patients')->where('id',$bill->patient_id)->whereNull('deleted_at')->first();
                  @endphp
                    <div class="row mt-3">
                        <input type="hidden" value="{{ $uniquePageNumber }}" id="lastPageNumber">
                        <input type="hidden" value="{{ $patient->id }}" id="patient_id">
                        <input type="hidden" value="{{ $patient->id }}" id="bill_id" name="bill_id">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">File No <span class="text-danger">*</span></label>
                            <input type="text" id="file_no" name="file_no"
                                class="form-control @error('file_no') is-invalid @enderror" value="{{ $patient->file_no }}"
                                disabled>
                            @error('file_no')
                                <div class=" invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Bill No. <span class="text-danger">*</span></label>
                            <input type="text" disabled class="form-control @error('bill_no') is-invalid @enderror"
                                name="bill_no" id="bill_no" tabindex="1" value="{{ $bill->bill_no }}" disabled>
                            @error('bill_no')
                                <div class=" invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Bill Date & Time</label>
                            <input type="text" disabled class="form-control @error('uid_number') is-invalid @enderror"
                                name="bill_date" id="bill_date" tabindex="1" value="{{ $bill->bill_date }}" disabled>
                            @error('uid_number')
                                <div class=" invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-3 mb-2">
                            <label class="form-label">Patient Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control  @error('first_name') is-invalid @enderror "
                                name="first_name" id="first_name" tabindex="1" value="{{ $patient->first_name }}"
                                disabled>
                            @error('first_name')
                                <div class=" invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-2 mb-2">
                            <label class="form-label">Father's Name.</label>
                            <input type="text" class="form-control " tabindex="2" name="father_name" id="father_name"
                                value="{{ $patient->father_name }}" disabled>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label">Date of Birth <span class="text-danger">*</span></label>
                            <div class="input-daterange input-group @error('date_of_birth') is-invalid @enderror"id="datepicker6"
                                data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker"
                                data-date-container="#datepicker6">
                                <input type="text" class="form-control" name="data_of_birth"
                                    value="{{ $patient->date_of_birth }}" disabled>
                                @error('date_of_birth')
                                    <div class=" invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label">Gender</label>
                            <input type="text" class="form-control @error('uid_number') is-invalid @enderror"
                                name="uid_number" disabled id="uid_number" tabindex="1"
                                value="{{ $patient->uid_number }}">
                            @error('uid_number')
                                <div class=" invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label">Moblie No</label>
                            <input type="number" class="form-control @error('mobile_no') is-invalid @enderror"
                                tabindex="2" name="mobile_no" id="mobile_no" value="{{ $patient->mobile_no }}" disabled>
                            @error('mobile_no')
                                <div class=" invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>


                {{--  Bill CreATE --}}
                <div class="row mt-4">
                    <div class="col-md-9">
                        <div class="title">
                            <h4>Medicine Details</h4>
                        </div>
                        <div id="bill_item">

                        </div>
                        <div id="showinventry">
                            <form id="bill_item">
                                <div data-repeater-item="" class="row stepinventryRow" data-ino="${ino}">
                                    <div class="mb-3 col-lg-5">
                                        <label for="name">Medicine Name</label>
                                        <select name="medicine" id="medicine" class="mb-3 form-select">
                                            <option value="">Select Medicine</option>
                                        </select>
                                        <p></p>
                                    </div>

                                    <div class="mb-3 col-lg-2">
                                        <label>Quantity</label>
                                        <input type="number" id="qty" name="qty" class="form-control">
                                        <p></p>
                                    </div>
                                    <div class="mb-3 col-lg-2">
                                        <label for="email">Dosage</label>
                                        <input type="number" name="dos" id="dos" class="form-control">
                                        <p></p>
                                    </div>
                                </div>
                                <div data-repeater-item="" class="row editinventryRow" data-ino="${ino}">
                                </div>
                                <input type="button" class="btn btn-success mt-3 mt-lg-0 add-button2" value="Add"
                                    id="add">
                            </form>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Note</label>
                                <textarea id="note" name="note" class="form-control" rows="3"></textarea>
                              </div>
                        </div>

                    </div>
                    <div class="col-md-3">
                        <div class="d-flex justify-content-center align-items-center">
                            <div class="box" id="imagePreview">
                                @if ($bill->bill_image)
                                <img src="{{ asset('public/media/photos').'/'.$bill->bill_image }}" alt="{{ $bill->id }}'s image" width="50" height="50" class="rounded photo-thumbnail">
                                @else
                                <img src="{{ asset('public/media/photos').'/'.'no-photo.png' }}" alt="{{ $bill->id }}'s image" width="50" height="50" class="rounded photo-thumbnail">
                                 @endif
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="button" class="btn btn-primary mt-2 waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#capimage">
                                Capture
                              </button>
                        </div>
                        <input type="file" id="bill_image" name="bill_image" style="display: none;" accept="image/*">
                    </div>
                </div>
                <div class="row  mt-4">
                    <div class="col-md-9">
                    </div>
                    <div class="col-md-2">
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-primary btn-font" id="save">
                                Save
                            </button>
                            <button class="btn btn-success mf-1 btn-font " type="button" id="saveAndPrint">Save &
                                Print</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
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
    </div>
    <footer class="footer">
        <div class="container-fluid">

            <div class="row">
                <div class="col-sm-6 btn-font">
                    Total <span id="total-price">{{$bill->total_amount}}</span>
                </div>
                <div class="col-sm-6">
                </div>
            </div>
        </div>
    </footer>
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
  var photoInput = document.getElementById('bill_image');
  var dataTransfer = new DataTransfer();
  dataTransfer.items.add(file);
  photoInput.files = dataTransfer.files;
});

        $("#add").click(function() {
            const page_no = $('#lastPageNumber').val();
            const medicineString = $('#medicine').val();
            const medicine = parseInt(medicineString, 10);
            const qty = $('#qty').val();
            const dos = $('#dos').val();
            $.ajax({
                url: "{{ url('demo/create') }}",
                method: 'POST',
                dataType: 'json',
                data: {
                    page_no: page_no,
                    medicine: medicine,
                    qty: qty,
                    dos: dos,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status == true) {
                        let total = response.total_price.total_price
                        $("#total-price").text(total);

                        $("#medicine").removeClass('is-invalid').siblings('p').removeClass(
                            'invalid-feedback').html('');
                        $("#qty").removeClass('is-invalid').siblings('p').removeClass(
                            'invalid-feedback').html('');
                        $("#dos").removeClass('is-invalid').siblings('p').removeClass(
                            'invalid-feedback').html('');
                        getDropdown();
                        fetchRows(page_no)
                        $('#qty').val('')
                        $('#dos').val('')

                    } else {
                        var errors = response.errors;

                        if (errors.medicine) {
                            setTimeout(function() {
                                $("#medicine").focus();
                            }, 100);
                            $("#medicine").addClass('is-invalid').siblings('p').addClass(
                                'invalid-feedback').html(errors.medicine);
                        } else {
                            $("#medicine").removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback').html('');
                        }

                        if (errors.qty) {
                            setTimeout(function() {
                                $("#qty").focus();
                            }, 100);
                            $("#qty").addClass('is-invalid').siblings('p').addClass(
                                'invalid-feedback').html(errors.qty);
                        } else {
                            $("#qty").removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback').html('');
                        }

                        if (errors.dos) {
                            setTimeout(function() {
                                $("#dos").focus();
                            }, 100);
                            $("#dos").addClass('is-invalid').siblings('p').addClass(
                                'invalid-feedback').html(errors.dos);
                        } else {
                            $("#dos").removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback').html('');
                        }
                    }
                },
            });
        });

        function getDropdown() {
            const page_no = $('#lastPageNumber').val();
            $.ajax({
                url: "{{ url('medicine/dropdown') }}/" + page_no,
                type: 'GET',
                success: function(data) {
                    var select = $('#medicine');
                    select.empty();
                    select.append('<option value="">Select Medicine</option>');
                    $.each(data, function(key, value) {
                        // select.append('<option value="' + value.id + '">' + value.name + ' (Stock ' +
                        //     value.totalQuantity + ') '+ value.totalQuantity <= 0 ? 'disabled' : '' +'</option>');
                        select.append('<option value="' + value.id + '" ' + (value.totalQuantity <= 0 ? 'disabled' : '') + '>' + value.name + ' (Stock ' + value.totalQuantity + ')</option>');

                    });
                }
            });
        }
        getDropdown();

        function fetchRows(page_no) {
            editRows()
            $.ajax({
                url: "{{ url('/demo/get-row') }}/" + page_no,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    $("#bill_item .stepinventryRow").remove();
                    response.forEach(function(row) {
                        var newRow = `
                    <div data-repeater-item="" class="row stepinventryRow" data-ino="${row.ino}">
                        <div class="mb-3 col-lg-5">
                                <label for="name">Medicine Name</label>
                                <select name="medicine" id="medicine-${row.ino}" class="mb-3 form-select" disabled>
                                    @foreach ($medicines as $m)
                                    <option value="{{ $m->id }}" {{ $m->id }}" ${row.medicine_id == {{ $m->id }} ? 'selected' : ''}>{{ $m->name }}</option>
                                    @endforeach
                                    </select>
                                    <p></p>
                                    </div>
                                    <div class="mb-3 col-lg-2">
                                <label>Quantity</label>
                                <input type="number" id="qty-${row.ino}" name="qty" class="form-control" value="${row.qty}" disabled>
                                <p></p>
                                </div>
                            <div class="mb-3 col-lg-2">
                                <label for="email">Dosage</label>
                                <input type="number" name="dos" id="dos-${row.ino}" class="form-control" value="${row.dos}" disabled>
                                <p></p>
                                </div>
                                <div class="col-lg-2 align-self-center">
                                    <div class="d-grid">
                                        <input type="button" class="btn btn-primary remove-button" value="Delete" data-id="${row.id}">
                                        </div>
                                        </div>
                                        </div>`;
                        $("#bill_item").append(newRow);
                    });
                    attachDeleteEvent(page_no);
                },
                error: function(error) {
                    console.error("There was an error fetching the rows: ", error);
                }
            });
        }
        editRows()
        function editRows() {
            const bill_id = $('#bill_id').val();
            $.ajax({
                url: "{{ url('/bill/get-item') }}/" + bill_id,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    $("#bill_item .editinventryRow").remove();
                    response.forEach(function(row) {
                        var newRow = `
                    <div data-repeater-item="" class="row editinventryRow item-row" data-ino="${row.ino}">
                        <div class="mb-3 col-lg-5">
                                <label for="name">Medicine Name</label>
                                <select name="medicine[]" id="medicine-${row.ino}" class="mb-3 form-select">
                                    @foreach ($medicines as $m)
                                    <option value="{{ $m->id }}" {{ $m->id }}" ${row.medicine_id == {{ $m->id }} ? 'selected' : ''}>{{ $m->name }}</option>
                                    @endforeach
                                    </select>
                                    <p></p>
                                    </div>
                                    <div class="mb-3 col-lg-2">
                                <label>Quantity</label>
                                <input type="number" id="qty-${row.ino}" name="qty[]"  class="form-control item-qty" value="${row.qty}">
                                <p></p>
                                </div>
                            <div class="mb-3 col-lg-2">
                                <label for="email">Dosage</label>
                                <input type="number" name="dos" id="dos-${row.ino}" class="form-control" value="${row.dos}">
                                <p></p>
                                </div>
                                <div class="col-lg-2 align-self-center">
                                    <div class="d-grid">
                                        <input type="button" class="btn btn-primary remove-button" value="Delete" data-id="${row.id}">
                                        </div>
                                        </div>
                                        </div>`;
                        $("#bill_item").append(newRow);
                    });
                    // attachDeleteEvent(page_no);
                },
                error: function(error) {
                    console.error("There was an error fetching the rows: ", error);
                }
            });
        }

        $(document).ready(function() {
            $('#bill_item').on('change', '.item-qty', function() {
            let $row = $(this).closest('.item-row');
            // let $row = $(this).closest('.item-row');
            alert($row);
            let medicineId = $row.find('input[name*="medicine_id"]').val();
            let qty = $(this).val();

            $.ajax({
                url: "{{url('check/batch-qty')}}",
                method: 'POST',
                data: {
                    medicine_id: medicineId,
                    qty: qty,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log(response);
                    if (response.status) {
                        $row.find('.stock-quantity').text('Stock: ' + response.new_stock);
                    } else {
                        alert(response.message);
                    }
                },
                error: function() {
                    alert('An error occurred while updating the stock.');
                }
            });
            });
            });

        function attachDeleteEvent(page_no) {
            $(".remove-button").off('click').on('click', function() {
                var rowId = $(this).data('id');
                // alert('ok');
                var rowElement = $(this).closest('.stepinventryRow');

                $.ajax({
                    url: "{{ url('/demo/delete-row') }}/" + rowId,
                    method: 'get',
                    dataType: 'json',
                    success: function(response) {
                        if (response.status = true) {
                            fetchRows(page_no);
                            getDropdown();
                        } else {
                            console.error("There was an error deleting the row: ", response.message);
                        }
                    },
                    error: function(error) {
                        console.error("There was an error deleting the row: ", error);
                    }
                });
            });
        }
        $("#save").click(function() {
            saveBill(false);
        });

        $("#saveAndPrint").click(function() {
            saveBill(true);
        });

        function saveBill(print) {
            const page_no = $('#lastPageNumber').val();
            const note = $('#note').val();
            const bill_date = $('#bill_date').val();
            const bill_no = $('#bill_no').val();
            const patient_id = $('#patient_id').val();
            var totalPrice = $('#total-price').text();
            const bill_image = $('#bill_image')[0].files[0];
            var formData = new FormData();
            formData.append('bill_date', bill_date);
            formData.append('page_no', page_no);
            formData.append('note', note);
            formData.append('bill_no', bill_no);
            formData.append('patient_id', patient_id);
            formData.append('totalPrice', totalPrice);
            formData.append('print', print);
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('bill_image', bill_image);

            $.ajax({
                url: "{{ url('bill/create') }}",
                method: 'POST',
                dataType: 'json',
                data:formData,
                cache:false,
                processData:false,
                contentType:false,
                success: function(response) {
                    if (response.status == true) {
                        // console.log(response);
                        const print_id = response.id
                        const printStatus = response.print === "true"; // Convert string "true" or "false" to boolean
                        // console.log( typeof print_id);
                        Swal.fire({
                            title: "Good job!",
                            text: "Bill created successfully.",
                            icon: "success"
                        }).then((result) => {
                            if (result.isConfirmed  && printStatus) {
                                // if (print_id) {
                                    window.location.href = "{{ url('print') }}" + '/'+ print_id;

                                }else{
                                window.location.href = "{{ url('patients') }}";
                            }
                        });
                    } else {
                        var errors = response.message;
                        alert(errors);

                    }
                },
            });
        }
    </script>
@endsection