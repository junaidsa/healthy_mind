@extends('layouts.app');
@section('main')
<style>
    .sm-card{
        height: 4.2rem;
         text-align: unset;

    }
    .lg-card{
        height: 5.2rem;
         text-align: unset;

    }
    .hr-boader{
             height: 1px;
            background-color: #474747;
            margin-top: 4rem;
            margin-buttom: 4rem;
    }
    .font-g{
        font-size: 1.3rem;
    }
    .w-50{
       width: 50px;
    }
</style>
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="card mini-stats-wid">
                            <div class="card-body sm-card">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p><strong style="font-size: larger;">Add Bill</strong></p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <span class="icon">
                                            <img src="{{ asset('public') }}/assets/images/tag.png" class="w-50">
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="card mini-stats-wid">
                            <div class="card-body sm-card">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p><strong style="font-size: larger;">Add Patients</strong></p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <span class="icon">
                                            <img src="{{ asset('public') }}//assets/images/tag.png" alt="bitbucket"style="width: 50px;">
                                        </span>
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
                <div class="row mt-2">
                    <div class="col-sm-3">
                        <div class="card mini-stats-wid">
                            <div class="card-body lg-card">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p style="margin-bottom: 0;"><strong
                                                style="font-size: larger;">Paracetamol</strong></p>
                                        <span class="font-g">200</span>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <span class="icon">
                                            <img src="http://localhost/healthy_mind/public/assets/images/tag.png" class="w-50">
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="card mini-stats-wid">
                            <div class="card-body gl-card">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p style="margin-bottom: 0;"><strong style="font-size: larger;">Paracetamol</strong></p>
                                        <span  class="font-g">200</span>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <span class="icon">
                                            <img src="{{ asset('public') }}/assets/images/tag.png" class="w-50">
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-sm-3">
                        <div class="card mini-stats-wid">
                            <div class="card-body gl-card">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p style="margin-bottom: 0;"><strong style="font-size: larger;">Paracetamol</strong></p>
                                                    <span class="font-g">200</span>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <span class="icon">
                                            <img src="{{ asset('public') }}/assets/images/tag.png" class="w-50">
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="card mini-stats-wid">
                            <div class="card-body gl-card">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p style="margin-bottom: 0;"><strong style="font-size: larger;">Paracetamol</strong></p>
                                        <span class="font-g">200</span>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <span class="icon">
                                            <img src="{{ asset('public') }}/assets/images/tag.png"
                                                alt="bitbucket" class="w-50">
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hr-boader">

                </div>
                </div>
            </div>
            <!-- End Page-content -->

    @endsection
