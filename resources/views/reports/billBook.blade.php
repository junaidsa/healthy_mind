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

        .table>:not(caption)>*>* {
            padding: .45rem .75rem;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <div class="page-content" style="min-height: 600px;">
        <div class="container-fluid">
            <!-- end page title -->
            <div class="card" style="border-radius: 20px">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <form id="range-form" action="{{ url()->current() }}">
                            <input type="hidden" name="search" value="{{ @$_GET['search'] }}">
                            <input type="text" class="form-control form-control-sm" id="date_range" name="date"
                                value="{{ @$_GET['date'] }}" style="width: 200px">
                        </form>
                        <div class="d-flex align-items-center fw-bold">
                            PRINT BILL <input type="text" class="form-control form-control-sm ms-2 me-2"
                                name="start_bill" id="start_bill" style="width: 100px"> TO <input type="text"
                                class=" ms-2 me-2 form-control form-control-sm" name="end_bill" id="end_bill"
                                style="width: 100px">
                            <label>

                                <input type="checkbox" id="duplicateCheck" class="float-end ms-2 me-2" />
                                <span class="fw-bold">DUPLICATE</span>
                            </label> <button class="btn btn-primary btn-sm btn-print  ms-2 me-2">Print</button> <button
                                class="ms-2 me-2 btn btn-primary btn-sm btn-download">Download</button>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex">
                            <a href="{{ url('billbook/pdf') }}{{ request()->has('date') ? '?date=' . request()->get('date') : '' }}{{ request()->has('search') ? (request()->has('date') ? '&' : '?') . 'search=' . request()->get('search') : '' }}"
                                class="btn btn-success me-3">
                                PDF
                            </a>
                            <a href="{{ url('billbook/excel') }}@if (request()->has('date')) ?date={{ request()->get('date') }} @endif
                        @if (request()->has('search')) {{ request()->has('date') ? '&' : '?' }}search={{ request()->get('search') }} @endif"
                                class="btn btn-success">
                                Excel
                            </a>
                        </div>
                        <div class="page-title-box d-sm-flex justify-content-between">
                            <div class="mt-6">

                            </div>

                            <form action="{{ url()->current() }}" method="get">
                                <input type="hidden" name="date" value="{{ @$_GET['date'] }}">
                                <div class="search-container">
                                    <button class="search-a">
                                        <i class="fa fa-search" class="search-a"></i>
                                    </button>
                                    <input type="text" placeholder="Search..." class="search-input" id="search"
                                        name="search" value="{{ Request::get('search') }}">

                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table mb-0">

                                    <thead class="table-blue">
                                        <tr>
                                            <th class="text-center">Select</th>
                                            <th class="text-center">Bill No.</th>
                                            <th class="text-center">File No.</th>
                                            <th class="text-center">Photo</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Father's Name</th>
                                            <th class="text-center">Age</th>
                                            <th class="text-center">Aadhar Number</th>
                                            <th class="text-center">Medicine</th>
                                            <th class="text-center">Amount</th>
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
                                                $med_qty = DB::table('bill_items')
                                                    ->where('bill_id', $row->id)
                                                    ->sum('qty');

                                                $bill_items = DB::table('bill_items')
                                                    ->where('bill_id', $row->id)
                                                    ->orderBy('medicine_id')
                                                    ->orderBy('batch_no')
                                                    ->get();
                                            @endphp
                                            <tr>
                                                <td class="text-center"><input type="checkbox" id="selected_export"
                                                        data-id="{{ @$row->id }}"></td>
                                                <td class="text-center">{{ @$row->bill_no }}</td>
                                                <td class="text-center">{{ @$row->file_no }}</td>
                                                <td class="text-center"><img
                                                        src="{{ asset('public') }}/media/photos/{{ @$row->Image }}"
                                                        alt="" width="40" height="40"
                                                        class="d-block rounded"></td>
                                                <td class="text-center">{{ @$row->first_name }}</td>
                                                <td class="text-center">{{ @$row->father_name }}</td>
                                                <td class="text-center">{{ @$row->date_of_birth }}</td>
                                                <td class="text-center">{{ @$row->other_id }}</td>
                                                <td class="text-center">{{ @$med_qty }}</td>
                                                <td class="text-center">{{ @$row->total_amount }} ₹</td>
                                                <td class="text-center"><a href="javascript:void();"
                                                        class="btn btn-success btn-sm waves-effect waves-light mb-2 mb-md-0 me-2"
                                                        data-id="{{ @$row->id }}">Edit</a><a href="{{ url('detail-bill').'/'.$row->id.'?from=billbook' }}"
                                                        class="btn btn-primary btn-sm btn-rounded me-2 waves-effect waves-light mb-2 mb-md-0"
                                                        data-id="{{ @$row->id }}">View Details</a> <a
                                                        href="{{ url('delete-bill' . '/' . @$row->id) }}"
                                                        onclick="return confirm('Are you sure?')"><i
                                                            class="fas fa-times text-danger"></i></a></td>
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
    <form id="print_form" action="{{ url('print_') }}">
        <input type="hidden" id="start_field" name="start_field">
        <input type="hidden" id="end_field" name="end_field">
    </form>
    <form id="pdf_form" action="{{ url('print_PDF') }}">
        <input type="hidden" id="start_field_" name="start_field">
        <input type="hidden" id="end_field_" name="end_field">
        <input type="hidden" id="duplicate_" name="duplicate">
    </form>
@endsection
@section('customJs')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr("#date_range", {
            mode: "range",
            onClose: function(selectedDates, dateStr, instance) {
                // Format the date range as "DD/MM/YYYY - DD/MM/YYYY"
                // if (selectedDates.length > 1) {
                //     const startDate = selectedDates[0];
                //     const endDate = selectedDates[1];
                //     const formattedStartDate = instance.formatDate(startDate, "d/m/Y");
                //     const formattedEndDate = instance.formatDate(endDate, "d/m/Y");
                //     instance.input.value = `${formattedStartDate} - ${formattedEndDate}`;
                // }
                $('#range-form').submit();
            }
        });

        $('.btn-print').on('click', function() {
            $(".is-invalid").removeClass('is-invalid');
            $(".invalid-feedback").html('');
            var isValid = true;
            var start_bill = $('#start_bill').val();
            var end_bill = $('#end_bill').val();
            if (start_bill === '') {
                $("#start_bill").addClass('is-invalid').siblings('.invalid-feedback').html(
                    'This field is required.');
                isValid = false;
            }
            if (end_bill === '') {
                $("#end_bill").addClass('is-invalid').siblings('.invalid-feedback').html('This field is required.');
                isValid = false;
            }
            if (isValid) {
                $('#start_field').val(start_bill);
                $('#end_field').val(end_bill);
                $('#print_form').submit();
            }
        })

        $('.btn-download').on('click', function() {
            $(".is-invalid").removeClass('is-invalid');
            $(".invalid-feedback").html('');
            var isValid = true;
            var start_bill = $('#start_bill').val();
            var end_bill = $('#end_bill').val();
            if (start_bill === '') {
                $("#start_bill").addClass('is-invalid').siblings('.invalid-feedback').html(
                    'This field is required.');
                isValid = false;
            }
            if (end_bill === '') {
                $("#end_bill").addClass('is-invalid').siblings('.invalid-feedback').html('This field is required.');
                isValid = false;
            }
            if (isValid) {
                $('#start_field_').val(start_bill);
                $('#end_field_').val(end_bill);
                if ($('#duplicateCheck').is(':checked')) {
                    $('#duplicate_').val('1');

                } else {
                    $('#duplicate_').val('0');

                }
                $('#pdf_form').submit();
            }
        })
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
