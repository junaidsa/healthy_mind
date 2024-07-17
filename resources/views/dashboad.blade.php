@extends('layouts.app');
@section('main')
    <style>
        .sm-card {
            height: 4.2rem;
            text-align: unset;

        }

        .lg-card {
            height: 5.2rem;
            text-align: unset;

        }

        .hr-boader {
            height: 1px;
            background-color: #474747;
            margin-top: 4rem;
            margin-buttom: 4rem;
        }

        .font-g {
            font-size: 1.3rem;
        }

        .w-50 {
            width: 50px;
        }

        .avatar-sm {
            height: 2.5rem;
            width: 2.5rem;
        }
    </style>
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                {{-- <div class="col-sm-3"> --}}
                {{-- <div class="card mini-stats-wid">
                            <div class="card-body sm-card">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p><strong style="font-size: larger;">Add Bill</strong></p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <span class="icon">
                                            {{-- <simg src="{{ asset('public') }}/assets/images/tag.png" class="w-50"> --}}
                {{-- </span>
                                    </div>
                                </div>
                            </div> --}}
                {{-- </div> --}}
                {{-- <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex justy">
                                        <p class="text-muted fw-medium">Add Bill</p>
                                    </div>

                                    <div class="flex-shrink-0 align-self-center">
                                        <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                            <span class="avatar-title rounded-circle bg-primary">
                                                <i class="bx bx-purchase-tag-alt font-size-20"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                {{-- </div> --}}
                <div class="col-sm-3" style="cursor: pointer;">
                    <div class="card mini-stats-wid" onclick="window.location = '{{ url('add-bill') }}'">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <p class="fw-bold m-0 p-0" style="font-size: 18px;">Add Bill</p>
                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                        <span class="avatar-title rounded-circle bg-primary">
                                            <i class="bx bx-purchase-tag-alt font-size-20"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3" style="cursor: pointer;">
                    <div class="card mini-stats-wid" onclick="window.location = '{{ url('patients/create') }}'">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <p class="fw-bold m-0 p-0" style="font-size: 18px;">Add Patient</p>
                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                        <span class="avatar-title rounded-circle bg-primary">
                                            <i class="bx bx-purchase-tag-alt font-size-20"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hr-boader">

            </div>
            <div class="row mt-4">
                <div class="col-sm-3">
                    <p style="font-weight: bold; font-size: 1rem;">Select Date</p>
                    <p style="font-weight: bold;font-size: 1rem;margin-top: -12px;">24 May 2024</p>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-sm-3">
                    <h3 style="font-weight: 600;font-size: 1.4rem;">Opening Stock</h3>
                </div>
                <div class="col-sm-3">
                    <h3 style="font-weight: 600;font-size: 1.4rem;">Closing Stock</h3>
                </div>
            </div>
            @php
                $all_medicne = DB::table('medicines')->whereNull('deleted_at')->get();
            @endphp
            <div class="row mt-2">
                @foreach ($all_medicne as $med)
                    <div class="col-sm-3 mb-2">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <p class="fw-medium m-0 p-0" style="font-size: 14px;">{{ $med->name }}</p>
                                        <h2 class="mb-0">200</h2>
                                    </div>

                                    <div class="flex-shrink-0 align-self-center">
                                        <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                            <span class="avatar-title rounded-circle bg-primary">
                                                <i class="bx bx-purchase-tag-alt font-size-20"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 mb-2">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <p class="fw-medium m-0 p-0" style="font-size: 14px;">{{ $med->name }}</p>
                                        <h2 class="mb-0">200</h2>
                                    </div>

                                    <div class="flex-shrink-0 align-self-center">
                                        <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                            <span class="avatar-title rounded-circle bg-primary">
                                                <i class="bx bx-purchase-tag-alt font-size-20"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 mb-2"></div>
                @endforeach
            </div>
        </div>
        <!-- End Page-content -->
    @endsection
