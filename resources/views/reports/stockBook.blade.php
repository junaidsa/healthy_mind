@extends('layouts.app');
@section('title', 'Stock Book Report')
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
        .table>:not(caption)>*>*{
            padding: .35rem .75rem;
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
    </style>
    <div class="page-content" style="min-height: 570px;">
        <div class="container">
            <div class="row">
                <div class="col-9 d-flex align-items-center">

                </div>
                <div class="col-3 text-end mb-2 d-print-none">
                    {{-- <a href="{{ url('stock/pdf') }}@if(isset($_GET['date']))?date={{ $_GET['date'] }}@endif" class="btn btn btn-success">
                        PDF
                    </a> --}}
                    <a href="{{ url('stock/pdf') }}@if(request()->has('date'))?date={{ request()->get('date') }}@endif
                        @if(request()->has('search')){{ request()->has('date') ? '&' : '?' }}search={{ request()->get('search') }}@endif"
                        class="btn btn-success" target="_blank">
                        PDF
                    </a>
                    {{-- <a href="{{ url('stock/excel') }}@if(isset($_GET['date']))?date={{ $_GET['date'] }}@endif" class="btn btn btn-success">
                        Excel
                    </a> --}}
                    <a href="{{ url('stock/excel') }}@if(request()->has('date'))?date={{ request()->get('date') }}@endif
                        @if(request()->has('search')){{ request()->has('date') ? '&' : '?' }}search={{ request()->get('search') }}@endif"
                        class="btn btn-success" target="_blank">
                        Excel
                    </a>
                    {{-- <a href="{{ url('stock/print') }}@if(isset($_GET['date']))?date={{ $_GET['date'] }}@endif" class="btn btn btn-success">
                        Print
                    </a> --}}
                    <a href="javascript: void(0);"
                    onclick="window.print()"
                        class="btn btn-success" >
                        Print
                    </a>
                </div>
            </div>
            <!-- end page title -->
            <div class="card" style="border-radius: 20px">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-9 d-flex align-items-center" style="font-size: 16px;">
                            <b class="mr-4 pb-2">Date</b>&nbsp;&nbsp; &nbsp;<span class="pl-4 pb-2"><b
                                    style="cursor: pointer;" id="datepicker6" data-date-format="dd M yyyy"
                                    data-date-autoclose="true" data-provide="datepicker"
                                    data-date-container="#datepicker6">{{ isset($_GET['date']) ? $_GET['date'] : date('d M Y') }}</b></span>
                        </div>
                        <div class="col-3 text-end mb-2">

                        </div>
                    </div>
                    <div class="table-responsive mb-3">
                        <table class="table mb-0">
                            <tbody>
                                @foreach ($medicnes as $med)
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
                                <tr>
                                    <td class="fw-bold" style="width: 20%">{{ $med->name }}</td>
                                    <td style="width: 20%">Opening: <span class="fw-bold">{{ @$opening_balence }}</span></td>
                                    <td style="width: 20%">Closing: <span class="fw-bold">{{ @$opening_balence - $closing_balence  }}</span></td>
                                    <td style="width: 40%">Left: <span class="fw-bold">{{ $closing_balence}}</span></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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
                                    <tbody>
                                        @php
                                            $last_batches = []; // Initialize outside the loop to keep track globally
                                        @endphp
                                        @foreach ($data as $row)
                                            @php
                                                // $bill_items = DB::table('bill_items')->where('bill_id', $row->id)->get();
                                                // dd($bill_items);
                                                // $med_qty = DB::table('bill_items')->where('bill_id', $row->id)->sum('qty');

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
                                                <td class="text-center d-print-none"><a href="{{ url('detail-bill').'/'.$row->id.'?from=stockbook' }}"
                                                        class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0"
                                                        data-id="{{ @$row->id }}">View Details</a></td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                                {{-- {{ $patients->links('pagination::bootstrap-5') }} --}}
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
           const today = new Date();
    const formattedToday = today.toLocaleString('en-GB', {
        day: '2-digit',
        month: 'short',
        year: 'numeric'
    }).replace(/ /g, ' ');
    var datepicker = $('#datepicker6').datepicker({
        format: 'dd M yyyy',
        autoclose: true,
        defaultViewDate: today
    }).on('changeDate', function(e) {
        var selectedDate = $('#datepicker6').datepicker('getFormattedDate');
        $('#datepicker6').text(selectedDate);
        var currentUrl = window.location.href.split('?')[0];
        var newUrl = currentUrl + '?date=' + encodeURIComponent(selectedDate);
        window.location.href = newUrl;
    });

    // Manually set the datepicker's date to today
    $('#datepicker6').datepicker('update', today);

        function parseQueryString(url) {
            var params = {};
            var queryString = url.split('?')[1];
            if (queryString) {
                queryString.split('&').forEach(function(pair) {
                    pair = pair.split('=');
                    params[pair[0]] = decodeURIComponent(pair[1] || '');
                });
            }
            return params;
        }
        var baseUrl = "{{ route('patients.index') }}";
        var currentUrl = window.location.href;
        var parsedParams = parseQueryString(currentUrl);
        var url = new URL(baseUrl);
        Object.keys(parsedParams).forEach(function(key) {
            url.searchParams.append(key, parsedParams[key]);
        });
        const searchInput = document.getElementById('searchInput');
        searchInput.addEventListener('keypress', function(event) {
            if (event.key === 'Enter') {
                var params = url.searchParams;
                var keywords = $("#searchInput").val();
                params.set("keywords", keywords);
                if (keywords) {} else {
                    url.search = '';
                }
                url.search = params.toString();
                window.location.href = url.toString();
            }
        });
    </script>
@endsection
