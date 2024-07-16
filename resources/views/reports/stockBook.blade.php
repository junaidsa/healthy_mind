@extends('layouts.app');
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
    </style>
    <div class="page-content" style="min-height: 570px;">
        <div class="container">
            <div class="row">
                <div class="col-9 d-flex align-items-center">

                </div>
                <div class="col-3 text-end mb-2">
                    <a href="{{ url('dispense/pdf') }}@if(isset($_GET['date']))?date={{ $_GET['date'] }}@endif" class="btn btn btn-success">
                        PDF
                    </a>
                    <a href="{{ url('dispense/excel') }}@if(isset($_GET['date']))?date={{ $_GET['date'] }}@endif" class="btn btn btn-success">
                        Excel
                    </a>
                    <a href="{{ url('dispense/print') }}@if(isset($_GET['date']))?date={{ $_GET['date'] }}@endif" class="btn btn btn-success">
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
                                    $open_stock = DB::table('stock_history')->where('medicine_id', $med->id)->where('date', date('Y-m-d'))->first();
                                    $current_stock = DB::table('batches')->where('quantity', '>' , '0')->where('medicine_id', $med->id)->sum('quantity');
                                @endphp
                                <tr>
                                    <td class="fw-bold" style="width: 20%">{{ $med->name }}</td>
                                    <td style="width: 20%">Opening: <span class="fw-bold">{{ $open_stock->qty }}</span></td>
                                    <td style="width: 20%">Closing: <span class="fw-bold">{{ $current_stock }}</span></td>
                                    <td style="width: 40%">Left: <span class="fw-bold">{{ $open_stock->qty - $current_stock }}</span></td>
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
                                            <th class="text-center">Options</th>
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
                                                <td class="text-center"><a href=""
                                                        class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0"
                                                        data-id="{{ @$row->id }}">View Details</a></td>
                                            </tr>
                                        @endforeach
                                        {{-- <tr>
                                            <td class="text-center">2</td>
                                            <td class="text-center">AB-19</td>
                                            <td class="text-center">NPC-06</td>
                                            <td class="text-center">Alex Saif</td>
                                            <td class="text-center">Simon Rey</td>
                                            <td class="text-center">1252 2512 5232</td>
                                            <td class="text-center">5</td>
                                            <td class="text-center"><a class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0">View Details</a></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">3</td>
                                            <td class="text-center">AB-18</td>
                                            <td class="text-center">NPC-06</td>
                                            <td class="text-center">Alex Saif</td>
                                            <td class="text-center">Simon Rey</td>
                                            <td class="text-center">1252 2512 5232</td>
                                            <td class="text-center">5</td>
                                            <td class="text-center"><a class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0">View Details</a></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">4</td>
                                            <td class="text-center">AB-17</td>
                                            <td class="text-center">NPC-06</td>
                                            <td class="text-center">Alex Saif</td>
                                            <td class="text-center">Simon Rey</td>
                                            <td class="text-center">1252 2512 5232</td>
                                            <td class="text-center">5</td>
                                            <td class="text-center"><a class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0">View Details</a></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">5</td>
                                            <td class="text-center">AB-16</td>
                                            <td class="text-center">NPC-06</td>
                                            <td class="text-center">Alex Saif</td>
                                            <td class="text-center">Simon Rey</td>
                                            <td class="text-center">1252 2512 5232</td>
                                            <td class="text-center">5</td>
                                            <td class="text-center"><a class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0">View Details</a></td>
                                        </tr>
                                        <tr class="batch-info">
                                            <td class="text-center" colspan="8" class="text-center"><b>Paracetamol Batch Changed: 106505</b></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">6</td>
                                            <td class="text-center">AB-15</td>
                                            <td class="text-center">NPC-06</td>
                                            <td class="text-center">Alex Saif</td>
                                            <td class="text-center">Simon Rey</td>
                                            <td class="text-center">1252 2512 5232</td>
                                            <td class="text-center">5</td>
                                            <td class="text-center"><a class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0">View Details</a></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">7</td>
                                            <td class="text-center">AB-14</td>
                                            <td class="text-center">NPC-06</td>
                                            <td class="text-center">Alex Saif</td>
                                            <td class="text-center">Simon Rey</td>
                                            <td class="text-center">1252 2512 5232</td>
                                            <td class="text-center">5</td>
                                            <td class="text-center"><a class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0">View Details</a></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">8</td>
                                            <td class="text-center">AB-13</td>
                                            <td class="text-center">NPC-06</td>
                                            <td class="text-center">Alex Saif</td>
                                            <td class="text-center">Simon Rey</td>
                                            <td class="text-center">1252 2512 5232</td>
                                            <td class="text-center">5</td>
                                            <td class="text-center"><a class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0">View Details</a></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">9</td>
                                            <td class="text-center">AB-12</td>
                                            <td class="text-center">NPC-06</td>
                                            <td class="text-center">Alex Saif</td>
                                            <td class="text-center">Simon Rey</td>
                                            <td class="text-center">1252 2512 5232</td>
                                            <td class="text-center">5</td>
                                            <td class="text-center"><a href="" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0">View Details</a></td>
                                        </tr> --}}
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
        var datepicker = $('#datepicker6').datepicker({
            format: 'dd M yyyy',
            autoclose: true
        }).on('changeDate', function(e) {
            // Get the selected date
            var selectedDate = $('#datepicker6').datepicker('getFormattedDate');
            // Update the displayed date
            $('#datepicker6').text(selectedDate);
            // Reload the current URL with the selected date as a query parameter
            var currentUrl = window.location.href.split('?')[0]; // Remove existing query parameters
            var newUrl = currentUrl + '?date=' + encodeURIComponent(selectedDate);
            window.location.href = newUrl;
        });

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
