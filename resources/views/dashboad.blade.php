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
        .datediv{
            cursor: pointer;
            font-weight: bold;
            border: none;
            background: none;
            margin-top:-12px;
        }
        .datein{
            border: none;
            font-weight: 700;
            font-size: 1.3rem;
            outline: none;
        }
        input.datein:focus-visible{
            border: none;
            font-weight: 700;
        }
    </style>
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">

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
                    {{-- <p style="font-weight: bold;font-size: 1rem;margin-top: -12px;" style="cursor: pointer !important;" id="datepicker6" data-date-format="dd M yyyy"
                    data-date-autoclose="true" data-provide="datepicker"
                    data-date-container="#datepicker6"></p> --}}
                    <div class="datediv">
                        <input type="text" class="datein" id="data_dash" name="data_dash" value="{{ isset($_GET['date']) ? $_GET['date'] : date('d M Y') }}"  data-date-format="dd M yyyy" style="
                            background: none;"
                            data-date-autoclose="true" data-provide="datepicker">
                        </div>
                     </div>
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
                @php
                                $currentDate = date('Y-m-d');
                                $check_date = isset($_GET['date']) ? date('Y-m-d', strtotime($_GET['date'].' - 1 day')) : date('Y-m-d',strtotime( $currentDate.' - 1 day'));
                                $check_date2 = isset($_GET['date']) ? date('Y-m-d', strtotime($_GET['date'])) : date('Y-m-d',strtotime( $currentDate));
                                $check_time1=DB::table('bill_items')->where('medicine_id', $med->id)->whereDate('created_at', $check_date2)->orderBy('id','asc')->first();

                                    $check_time=$check_date2.' 23:59:59';
                                    $open_stock = DB::table('medicine_history')->where('medicine_id', $med->id)->where('created_at','<=', $check_time )->orderBy('id','desc')->sum('stock');


       $open_sold = DB::table('bill_items')->where('medicine_id', $med->id)->where('created_at','<=', $check_date.' 23:59:59')->orderBy('id','desc')->sum('qty');
                                    $opening_balence = $open_stock - $open_sold;
                                    $close_stock = DB::table('medicine_history')->where('medicine_id', $med->id)->where('created_at','<=', $check_date2.' 23:59:59')->orderBy('id','desc')->sum('stock');
                                    $close_sold = DB::table('bill_items')->where('medicine_id', $med->id)->where('created_at','<=', $check_date2.' 23:59:59')->orderBy('id','desc')->sum('qty');
                                    $closing_balence = $close_stock - $close_sold;
                                    // $current_stock = DB::table('batches')->where('quantity', '>' , '0')->where('medicine_id', $med->id)->sum('quantity');
                                @endphp
                    <div class="col-sm-3 mb-2">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <p class="fw-medium m-0 p-0" style="font-size: 14px;">{{ $med->name }}</p>
                                        <h2 class="mb-0">{{ $opening_balence }}</h2>
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
                                        <h2 class="mb-0">{{ @$opening_balence - $closing_balence  }}</h2>
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

    @section('customJs')
    <script>
                   const today = new Date();
    const formattedToday = today.toLocaleString('en-GB', {
        day: '2-digit',
        month: 'short',
        year: 'numeric'
    }).replace(/ /g, ' ');
        var datepicker = $('#data_dash').datepicker({
            format: 'dd M yyyy',
            autoclose: true
        }).on('changeDate', function(e) {
            var selectedDate = $('#data_dash').datepicker('getFormattedDate');
            $('#data_dash').text(selectedDate);
            // Reload the current URL with the selected date as a query parameter
            var currentUrl = window.location.href.split('?')[0]; // Remove existing query parameters
            var newUrl = currentUrl + '?date=' + encodeURIComponent(selectedDate);
            window.location.href = newUrl;
        });
    </script>
    @endsection
