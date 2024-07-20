@extends('layouts.app');
@section('title', 'Dispense Report')
@section('main')
    <style>
        .table-blue {
            background-color: #2E4661;
            color: #FFFFFF;
        }

        .search-container {
            height: 36;
            position: relative;
            display: flex;
            align-items: center;
            background: #fff;
            width: 220px;
            border: 1px solid #ccc;
            border-radius: 25px;
            overflow: hidden;
        }

        .search-input {
            width: 100%;
            padding: 10px -18px;
            border: none;
            font-size: 14px;
            outline: none;
            border-radius: 25px 0 0 25px;
        }

        tbody,
        td,
        tfoot,
        th,
        thead,
        tr {
            border-color: #999;
            border-style: solid;
            border-width: 0px;
        }

        .search-a {
            background-color: #fff;
            padding: 10px 8px;
            border: none;
            cursor: pointer;
            border-radius: 0 25px 25px 0;
            margin-left: 2px;
        }

        .btn-font {
            font-size: 1.2rem;
        }

        .mt-6 {
            margin-top: 3.5rem !important;
        }

        .page-title-box {
            padding-bottom: 0px;
        }
        @media print {

            .table {
                width: 100%;
                border-collapse: collapse;
            }
                .table td {
                border: 1px solid black;
                padding: 8px;
                text-align: center;
                color: #1a1919;


            }
            .batch-info {
                background-color: #f2f2f2;
            }
            .page-break {
                page-break-before: always;
            }
            .table th{
                font-weight:700;
                background-color:#0000;
                  border: 1px solid black;
                padding: 8px;
                color: #000;
                text-align: center;
            }
        }
        .datediv{
            cursor: pointer;
            font-weight: bold;
            border: none;
        }
        .datein{
            border: none;
            font-weight: 700;
            outline: none;
        }
        input.datein:focus-visible{
            border: none;
            font-weight: 700;
        }
    </style>
    {{-- @dd($this->request->path()); --}}
    <div class="page-content" style="min-height: 570px;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex justify-content-between">
                        <div class="mt-6">

                        </div>

                        <form action="{{ url()->current() }}{{ isset($_GET['date']) ? '?date=' . $_GET['date'] : '' }}" method="get">
                            <div class="search-container">
                                <button class="search-a">
                                    <i class="fa fa-search" class="search-a"></i>
                                </button>
                                <input type="text" placeholder="Search..." class="search-input" id="search" name="search"
                                    value="{{ Request::get('search') }}">

                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="card" style="border-radius: 20px">
                <div class="card-body">
                    {{-- <input type="text" name="" id=""> --}}
                    <div class="row">
                        <div class="col-9 d-flex align-items-center" style="font-size: 16px;">
                             <div class="d-flex datediv">
                                <div class="ml-2"><b>Date</b> &nbsp; &nbsp;</div> <div> <input type="text" class="datein" id="datepicker6" name="date" value="{{ date('d M Y') }}"  data-date-format="dd M yyyy"
                                    data-date-autoclose="true" data-provide="datepicker"></div>
                             </div>
                        </div>
                        <div class="col-3 text-end mb-2 d-print-none">
                            <a href="{{ url('dispense/pdf') }}@if (isset($_GET['date']))?date={{ $_GET['date'] }} @endif"
                                class="btn btn btn-success">
                                PDF
                            </a>
                            <a href="{{ url('dispense/excel') }}@if (isset($_GET['date']))?date={{ $_GET['date'] }} @endif"
                                class="btn btn btn-success">
                                Excel
                            </a>
                            <a href="javascript: void(0);" onclick="window. print()"
                                class="btn btn btn-success">
                                Print
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table mb-0">

                                    <thead class="table-blue">
                                        <tr>
                                            <th class="text-center">S.No.</th>
                                            <th class="text-center">Bill No.</th>
                                            <th class="text-center">File No.</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Father's Name</th>
                                            <th class="text-center">Aadhar Number</th>
                                            <th class="text-center">Medicine</th>
                                            <th class="text-center d-print-none">Options</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <tbody id="bill-table-body">
                                        {{-- @php
                                            $last_batches = [];
                                        @endphp
                                        @foreach ($data as $row)
                                            @php
                                                $bill_items = DB::table('bill_items')
                                                    ->where('bill_id', $row->id)
                                                    ->orderBy('medicine_id')
                                                    ->orderBy('batch_no')
                                                    ->get();
                                                $batch_notifications = [];

                                                foreach ($bill_items as $item) {
                                                    if (
                                                        isset($last_batches[$item->medicine_id]) &&
                                                        $last_batches[$item->medicine_id] != $item->batch_no
                                                    ) {
                                                        $med_name = DB::table('medicines')
                                                            ->where('id', $item->medicine_id)
                                                            ->first();
                                                        $batch_notifications[] = [
                                                            'medicine_name' => $med_name->name,
                                                            'batch_no' => $item->batch_no,
                                                        ];
                                                    }
                                                    $last_batches[$item->medicine_id] = $item->batch_no;
                                                }
                                                $med_qty = $bill_items->sum('qty');
                                            @endphp

                                            @foreach ($batch_notifications as $change)
                                                <tr class="batch-info">
                                                    <td class="text-center" colspan="8"><b>
                                                            {{ $change['medicine_name'] }} Batch Changed:
                                                            {{ $change['batch_no'] }}</b></td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td class="text-center">{{ @$loop->iteration }}</td>
                                                <td class="text-center">{{ @$row->bill_no }}</td>
                                                <td class="text-center">{{ @$row->file_no }}</td>
                                                <td class="text-center">{{ @$row->first_name }}</td>
                                                <td class="text-center">{{ @$row->father_name }}</td>
                                                <td class="text-center">{{ @$row->other_id }}</td>
                                                <td class="text-center">{{ @$med_qty }}</td>
                                                <td class="text-center d-print-none"><a href="{{ url('detail-bill').'/'.$row->id.'?from=dispense' }}"
                                                        class="btn btn-primary d-print-none btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0"
                                                        data-id="{{ @$row->id }}">View Details</a></td>
                                            </tr>
                                        @endforeach
</a></td>
                                        </tr> --}}
 </div>
                        </div> <!-- end col -->
                    </div> <!-- end row -->
                </div>
            </div>

        </div> <!-- container-fluid -->
    </div>
    <!-- end main content-->
@endsection
@section('customJs')
    <script>
        $(document).ready(function() {
            var datepicker = $('#datepicker6').datepicker({
                format: 'dd M yyyy',
                autoclose: true
            }).on('changeDate', function(e) {
                // Fetch data when the date is changed
                fetchBillData();
            });
              // Initialize datepicker
            function fetchBillData(){
                let search = $('#search').val();
                let date = $('#datepicker6').datepicker('getFormattedDate', 'yyyy-mm-dd');
                $.ajax({
                    url:"{{url('/dispense')}}",
                    type: 'GET',
                    data: {
                        search: search,
                        date: date
                    },
                    success: function(response) {
                        const tableBody = $('#bill-table-body');
                        tableBody.empty();
                    if (response.length > 0) {
                        for (let index = 0; index < response.length; index++) {
                             let row = response[index];
                             if (row.batch_notifications.length > 0) {
                            for (let i = 0; i < row.batch_notifications.length; i++) {
                                var bill_id = row.id;
                                        let notification = row.batch_notifications[i];
                                        let notificationRow = `<tr class="batch-info">
                                            <td class="text-center" colspan="8"><b>${notification.medicine_name} Batch Changed: ${notification.batch_no}</b></td>
                                        </tr>`;

                                        tableBody.append(notificationRow);
                                    }
                                }

                            let billRow = `<tr>
                                <td class="text-center">${index + 1}</td>
                                <td class="text-center">${row.bill_no}</td>
                                <td class="text-center">${row.file_no}</td>
                                <td class="text-center">${row.first_name}</td>
                                <td class="text-center">${row.father_name}</td>
                                <td class="text-center">${row.other_id}</td>
                                <td class="text-center">${row.med_qty}</td>
                                <td class="text-center d-print-none"><a href="{{ url('detail-bill') }}/${row.bill_id}?from=dispense"
                                    class="btn btn-primary d-print-none btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0"
                                    data-id="${row.bill_id}">View Details</a></td>
                            </tr>`;
                            tableBody.append(billRow);
                        }
                        }else{
             let noDataRow = `<tr>
        <td class="text-center" colspan="8"><b>No Bill found</b></td>
    </tr>`;
    tableBody.append(noDataRow);
                        }

                    }
                  })
            }
            fetchBillData()
            $(document).on('keyup', '#search', function() {
                fetchBillData();
            });
        })


    </script>
@endsection
