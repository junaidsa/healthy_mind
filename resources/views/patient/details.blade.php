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
                                        <img src="https://customization-doctorly.pixeleyez.com/build/images/profile-img.png" alt="" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="avatar-xl profile-user-wid mb-4">
                                            <img src="https://customization-doctorly.pixeleyez.com/build/images/users/noImage.png " alt="JHVDFHJVhjf" class="img-thumbnail">
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="pt-4">
                                            <div class="row">
                                                <div class="col-12">
                                                    <table>
                                                        <tbody><tr>
                                                            <td>
                                                                <h5 class="font-size-12 mb-0">Reg. Date &amp; Time :</h5>
                                                            </td>
                                                            <td>
                                                                <p class="text-muted mb-0 ms-4"> 2024-07-14 16:20:42 </p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h5 class="font-size-12 mb-0">File No. :</h5>
                                                            </td>
                                                            <td>
                                                                <p class="text-muted mb-0 ms-4"> NPC-22 </p>
                                                            </td>
                                                        </tr>
                                                    </tbody></table>
                                                </div>
                                            </div>
                                            <div class="mt-4">
                                                <a href="https://customization-doctorly.pixeleyez.com/patient/54/edit" class="btn btn-primary waves-effect waves-light btn-sm">Edit Profile <i class="mdi mdi-arrow-right ms-1"></i></a>
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
                                                <td>JHVDFHJVhjf jbvdkjbjfhcv</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Father's Name:</th>
                                                <td>kjbdajbvad</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Age:</th>
                                                <td> 2024-02-13 </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Gender:</th>
                                                <td> Male </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Aadhar No:</th>
                                                <td> 374748262827 </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Mobile No:</th>
                                                <td> 8323456785 </td>
                                            </tr>

                                            <tr>
                                                <th scope="row">Address:</th>
                                                <td> dajkbjfbd </td>
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
                                                        <p>No Notes Found</p>
                                                </div>
                        </div>
                    </div>
                    {{-- <div class="col-xl-8"> --}}
                        <div class="col-xl-8">
                            <div class="row">
                                                <div class="col-md-4">
                                    <div class="card mini-stats-wid">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <p class="text-muted fw-medium">Total Pills</p>
                                                    <h4 class="mb-0">0</h4>
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
                                                    <h4 class="mb-0">0</h4>
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
                                                        <th>Date</th>
                                                        <th>Time</th>
                                                        <th>Pills</th>
                                                        <th>Option</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                                                                                                                                                                                                        </tbody>
                                            </table>
                                            <div class="col-md-12 text-center mt-3">
                                                <div class="d-flex justify-content-start">
                                                    Showing  to
                                                    of 0 entries
                                                </div>
                                                <div class="d-flex justify-content-end">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="documents" role="tabpanel">
                                            <div class="row mb-4 justify-content-end">
                                                <div class="col-lg-5">
                                                    <form action="https://customization-doctorly.pixeleyez.com/patient/upload-document/23" class="d-flex" method="post" enctype="multipart/form-data">
                                                        <input type="hidden" name="_token" value="xmuepWkJgUEC1Eh5KBeabAUNIUimO4mtkjoSYfcp" autocomplete="off">                                        <div>
                                                            <input type="file" name="patient_document" id="patient_document" title="Upload Document" class="form-control" required="">
                                                            <small>Allowed extensions: jpg, jpeg, png, txt.</small>
                                                            <small>Allowed Size: 2MB Max</small>
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
                                                        <th>Size</th>
                                                        <th>Option</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                                                                                                                                                                                                        </tbody>
                                            </table>
                                            <div class="col-md-12 text-center mt-3">
                                                <div class="d-flex justify-content-start">
                                                    Showing  to
                                                    of 0 entries
                                                </div>
                                                <div class="d-flex justify-content-end">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="notes" role="tabpanel">
                                            <table class="table dt-responsive nowrap " style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <tbody>
                                                                                                                                                                                                                                        </tbody>
                                            </table>
                                            <div class="col-md-12 text-center mt-3">
                                                <div class="d-flex justify-content-start">
                                                    Showing  to
                                                    of 0 entries
                                                </div>
                                                <div class="d-flex justify-content-end">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

    </div> <!-- container-fluid -->
</div>
@endsection
