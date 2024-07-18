@extends('layouts.app');
@section('main')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-xl-4">
                        <div class="card overflow-hidden">
                            <div class="bg-primary-subtle">
                                <div class="row">
                                    <div class="col-7">
                                        <div class="text-primary p-3">
                                            <h5 class="text-primary">Patient Information</h5>
                                        </div>
                                    </div>
                                    <div class="col-5 align-self-end">
                                        <img src="#" alt="" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="row">
                                    <div class="col-sm-4 mt-4">
                                        <div class="avatar-xl profile-user-wid mb-4 mt-2">
                                            @if ($patient->Image)
                                            <a href="{{ asset('public/media/photos') . '/' . $patient->Image }}" data-lightbox="patient-gallery">
                                                <img src="{{ asset('public/media/photos') . '/' . $patient->Image }}"
                                                    alt="{{ $patient->name }}'s photo"
                                                    class="img-thumbnail">
                                            </a>
                                        @else
                                            <img src="{{ asset('public/media/photos') . '/' . 'nophoto.png' }}"
                                                alt="{{ $patient->name }}'s photo"
                                                class="img-thumbnail">
                                        @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="pt-4">
                                            <div class="row">
                                                <div class="col-12">
                                                    <table>
                                                        <tbody>
                                                            <tr>
                                                            <td>
                                                                <h5 class="font-size-12 mb-0">Reg. Date &amp; Time :</h5>
                                                            </td>
                                                            <td>
                                                                <p class="text-muted mb-0 ms-4">{{$patient->registration_date}} </p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h5 class="font-size-12 mb-0">File No. :</h5>
                                                            </td>
                                                            <td>
                                                                <p class="text-muted mb-0 ms-4">{{$patient->file_no}}</p>
                                                            </td>
                                                        </tr>
                                                    </tbody></table>
                                                </div>
                                            </div>
                                            <div class="mt-4">
                                                <a href="{{ url('patients') . '/' . $patient->id . '/edit' }}" class="btn btn-primary waves-effect waves-light btn-sm">Edit Profile <i class="mdi mdi-arrow-right ms-1"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end card -->
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Personal Information</h4>
                                <div class="table-responsive">
                                    <table class="table mb-0">
                                        <tbody>
                                            <tr>
                                                <th scope="row">Full Name:</th>
                                                <td>{{$patient->first_name}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Father's Name:</th>
                                                <td>{{$patient->father_name}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Age:</th>
                                                <td> {{$patient->date_of_birth}} </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Gender:</th>
                                                <td>{{$patient->gender}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Aadhar No:</th>
                                                <td> {{$patient->other_no}} </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Mobile No:</th>
                                                <td>{{$patient->mobile_no}}</td>
                                            </tr>

                                            <tr>
                                                <th scope="row">Address:</th>
                                                <td> {{$patient->address}} </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- end card -->

                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Last Notes</h4>
                             @php
    $latest_note = DB::table('patient_bills')
    ->where('patient_id', $patient->id)
    ->whereNull('deleted_at')
    ->whereNotNull('note')
    ->orderBy('created_at', 'desc')
    ->select('note', 'created_at')
    ->first();

    $latest_note_text = '';
                                  if ($latest_note) {
                                    $latest_note_text = $latest_note->note;
                                } else {
                                    $latest_note_text = "No notes found.";
                                }
                             @endphp
                                                        <p>{{$latest_note_text}}</p>
                                                </div>
                        </div>
                    </div>
                    @php
$totalBills = DB::table('patient_bills')
    ->where('patient_id', $patient->id)
    ->count();
$total_doc = DB::table('documents')
    ->where('patient_id', $patient->id)
    ->count();
    $patient_bills = DB::table('patient_bills')
        ->where('patient_id', $patient->id)
        ->whereNull('deleted_at')
        ->paginate(5);
    $bills_note = DB::table('patient_bills')
        ->where('patient_id', $patient->id)
        ->whereNull('deleted_at')
        ->whereNotNull('note')
        ->paginate(5);
    $docs = DB::table('documents')
        ->where('patient_id', $patient->id)
        ->whereNull('deleted_at')
        ->paginate(5);
  @endphp
                        <div class="col-xl-8">
                            <div class="row">
                                                <div class="col-md-4">
                                    <div class="card mini-stats-wid">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <p class="text-muted fw-medium">Total Bills</p>
                                                    <h4 class="mb-0">{{$totalBills}}</h4>
                                                </div>
                                                <div class="avatar-sm align-self-center mini-stat-icon rounded-circle bg-primary">
                                                    <span class="avatar-title">
                                                        <i class="bx bx-hourglass font-size-24"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card mini-stats-wid">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <p class="text-muted fw-medium">Documents</p>
                                                    <h4 class="mb-0">{{$total_doc}}</h4>
                                                </div>
                                                <div class="avatar-sm align-self-center mini-stat-icon rounded-circle bg-primary">
                                                    <span class="avatar-title">
                                                        <i class="bx bx-package font-size-24"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link active" data-bs-toggle="tab" href="#PrescriptionList" role="tab" aria-selected="true">
                                                <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                                <span class="d-none d-sm-block">Bills</span>
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" data-bs-toggle="tab" href="#documents" role="tab" aria-selected="false" tabindex="-1">
                                                <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                                <span class="d-none d-sm-block">Documents</span>
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" data-bs-toggle="tab" href="#notes" role="tab" aria-selected="false" tabindex="-1">
                                                <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                                <span class="d-none d-sm-block">Notes</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <!-- Tab panes -->
                                    <div class="tab-content p-3 text-muted">
                                        <div class="tab-pane active show" id="PrescriptionList" role="tabpanel">
                                            <table class="table table-bordered dt-responsive nowrap " style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>Sr. No</th>
                                                        <th>Bill. No</th>
                                                        <th>Photo</th>
                                                        <th>Date / Time</th>
                                                        <th>Pills</th>
                                                        <th>Option</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($patient_bills as $bill)
                                                    <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{$bill->bill_no}}</td>
                                                            <td>
                                                                @if ($bill->bill_image)
                                                                </a>
                                                                <a href="{{ asset('public/media/photos') . '/' . $bill->bill_image }}" data-lightbox="patient-gallery">
                                                                    <img src="{{ asset('public/media/photos') . '/' . $patient->Image }}"
                                                                    alt="{{ $patient->name }}'"
                                                                    class="avatar-sm photo-thumbnail cursor-pointer">
                                                                </a>
                                                            @else
                                                               <a href="{{ asset('public/media/photos') . '/' . 'nophoto.png' }}" data-lightbox="patient-gallery">
                                                                <img src="{{ asset('public/media/photos') . '/' . 'nophoto.png' }}"
                                                                alt="{{ $patient->name }}'s photo"
                                                                class="avatar-sm photo-thumbnail cursor-pointer">
                                                               </a>
                                                            @endif
                                                            <td>{{ $bill->created_at}}</td>
                                                            <td>{{
                                                                $totalQty = DB::table('bill_items')
                                                                ->where('bill_id', $bill->id)
                                                                ->sum('qty');
                                                                }}</td>
                                                            <td>
                                                                <a href="{{ url('print').'/'.$bill->id}}">
                                                                    <button type="button" class="btn btn-success btn-sm btn-rounded waves-effect waves-light">
                                                                        Print
                                                                    </button>
                                                                </a>
                                                                <a href="{{ url('print').'/'.$bill->id}}">
                                                                    <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light">
                                                                        View Details
                                                                    </button>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                @endforeach
                                                    </tbody>
                                            </table>
                                            {{ $patient_bills->links('pagination::bootstrap-5') }}
                                        </div>
                                        <div class="tab-pane" id="documents" role="tabpanel">
                                            <div class="row mb-4 justify-content-end">
                                                <div class="col-lg-5">
                                                    <form id="uploadForm" action="{{ route('doc.upload') }}" method="Post" enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="hidden" value="{{$patient->id}}" name="patient_id">
                                                         <div>
                                                            <input type="file" name="file" id="file" title="Upload Document" class="form-control @error('fill') is-invalid @enderror" required="">
                                                            <small>Allowed extensions: jpg, jpeg, png, txt.</small>
                                                            <small>Allowed Size: 2MB Max</small>
                                                            @error('fill')
                                                            <div class=" invalid-feedback">{{ $message }}</div>
                                                                 @enderror
                                                        </div>

                                                        <div>
                                                            <button type="submit" class="btn btn-success ms-2">Upload</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <table class="table table-bordered dt-responsive nowrap " style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>Sr. No</th>
                                                        <th>Name</th>
                                                        <th>Date Uploaded</th>
                                                        {{-- <th>Size</th> --}}
                                                        <th>Option</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($docs as $doc)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>
                                                    <a href="{{ asset('public/media/photos') . '/' . $doc->file_name }}" target="_blank">{{ $doc->file_name }}</a>
                                                        </td>
                                                        <td>{{ $doc->created_at }}</td>
                                                        <td>
                                                        <a href="javascript:;" class="delete-btn " id="{{$doc->id}}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                                        <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"/>
                                                          </svg>
                                                        </a>
                                                        </td>
                                                    </tr>
                                                    @endforeach

                                                <tbody>
                                                                                                                                                                                                                                        </tbody>
                                            </table>
                                            {{ $docs->links('pagination::bootstrap-5') }}
                                        </div>
                                        <div class="tab-pane" id="notes" role="tabpanel">
                                            <table class="table dt-responsive nowrap " style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <th>
                                                        Sr
                                                    </th>

                                                    <th>
                                                        Bill No
                                                    </th>

                                                    <th>
                                                        Note
                                                    </th>
                                                </thead>
                                                <tbody>
                                                    @foreach ($bills_note as $note)
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{$note->bill_no}}</td>
                                                        <td><p>{{$note->note}}</p><td>
                                                    @endforeach

                                                <tbody>
                                                                                                                                                                                                 </tbody>
                                            </table>
                                            {{ $bills_note->links('pagination::bootstrap-5') }}
                                                                                                                                                                                            </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

    </div> <!-- container-fluid -->
</div>
@endsection
