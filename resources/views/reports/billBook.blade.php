@extends('layouts.app');
@section('title', 'Bill Book Report')
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
                        {{-- <form id="range-form" action="{{ url()->current() }}"> --}}
                            {{-- <input type="hidden" name="search" value=""> --}}
                            <input type="text" class="form-control form-control-sm" id="date_range" name="date"
                                value="{{ date('d M Y') }}" style="width: 200px">
                        {{-- </form> --}}
                        <div class="d-flex align-items-center fw-bold">
                            PRINT BILL <input type="text" class="form-control form-control-sm ms-2 me-2"
                                name="start_bill" id="start_bill" style="width: 100px"> TO <input type="text"
                                class=" ms-2 me-2 form-control form-control-sm" name="end_bill" id="end_bill"
                                style="width: 100px">
                            <label>

                                <input type="checkbox" id="duplicateCheck" class="float-end ms-2 me-2" />
                                <span class="fw-bold">DUPLICATE</span>
                            </label> <button class="btn btn-primary btn-sm btn-print  ms-2 me-2" target="_blank">Print</button> <button
                                class="ms-2 me-2 btn btn-primary btn-sm btn-download" target="_blank">Download</button>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex">
                            <a href="javascript: void(0);" id="pdfView"
                                class="btn btn-success me-3">
                                PDF
                            </a>
                            <a href="javascript: void(0);" id="exlView"
                                class="btn btn-success">
                                Excel
                            </a>
                        </div>
                        <div class="page-title-box d-sm-flex justify-content-between">
                            <div class="mt-6">

                            </div>
                                <input type="hidden" name="date" value="{{ @$_GET['date'] }}">
                                <div class="search-container">
                                    <button class="search-a">
                                        <i class="fa fa-search" class="search-a"></i>
                                    </button>
                                    <input type="text" placeholder="Search..." class="search-input" id="search"
                                        name="search" value="">

                                </div>
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
                                        {{-- @php
                                            $last_batches = [];
                                        @endphp
                                        @foreach ($data as $row)
                                            @php
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
                                                <td class="text-center">
                                                    @if (@$row->bill_image && file_exists(public_path('media/photos/' . $row->bill_image)))
                                                        <img src="{{ asset('public/media/photos/' . $row->bill_image) }}"
                                                            alt="" width="40" height="40"
                                                            class="d-block rounded">
                                                    @else
                                                        <div style="width: 40px; height: 40px; background-color: grey;"
                                                            class="d-block rounded"></div>
                                                    @endif
                                                </td>
                                                <td class="text-center">{{ @$row->first_name }}</td>
                                                <td class="text-center">{{ @$row->father_name }}</td>
                                                <td class="text-center">{{ @$row->date_of_birth }}</td>
                                                <td class="text-center">{{ @$row->other_id }}</td>
                                                <td class="text-center">{{ @$med_qty }}</td>
                                                <td class="text-center">{{ @$row->total_amount }} ₹</td>
                                                <td class="text-center">
                                                    <a href="{{url('bill/edit').'/'.$row->id}}"  class="btn btn-success btn-sm waves-effect waves-light mb-2 mb-md-0 me-2" data-id="{{ @$row->id }}">Edit</a>
                                                    <a
                                                        href="{{ url('detail-bill') . '/' . $row->id . '?from=billbook' }}"
                                                        class="btn btn-primary btn-sm btn-rounded me-2 waves-effect waves-light mb-2 mb-md-0"
                                                        data-id="{{ @$row->id }}">View Details</a> <a
                                                        href="{{ url('delete-bill' . '/' . @$row->id) }}"
                                                        onclick="return confirm('Are you sure?')"><i
                                                            class="fas fa-times text-danger"></i></a></td>
                                            </tr>
                                        @endforeach --}}

                                    </tbody>

                                </table>
                                {{-- {{ $patients->links('pagination::bootstrap-5') }} --}}
                            </div>
                        </div> <!-- end col -->
                    </div> <!-- end row -->
                </div>
            </div>
            <div class="modal fade" id="modalImg" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="imageModalLabel">Image</h5>
                    </div>
                    <div class="modal-body">
                      <img id="modalImage" src="" alt="Patient Image" class="img-fluid">
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary close-model" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
        </div> <!-- container-fluid -->
    </div>
</div>
    <!-- end main content-->
    <form id="print_form" action="{{ url('print_') }}">
        <input type="hidden" id="start_field" name="start_field">
        <input type="hidden" id="end_field" name="end_field">
        <input type="hidden" id="duplicate" name="duplicate">
    </form>
    <form id="pdf_view" action="{{ url('billbook/pdf') }}">
        <input type="hidden" name="search_data" class="search_data"  >
        <input type="hidden" name="date_data"  class="date_data" >
    </form>
    <form id="exl_view" action="{{ url('billbook/excel') }}">
        <input type="hidden" name="search_data" class="search_data"  >
        <input type="hidden" name="date_data"  class="date_data" >
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


$(document).ready(function() {

    $('#date_range').change();
    $('#date_range').on('change', function() {

        if($(this).val()==undefined){
        fetchBills($('#search').val(),"<?php echo date('Y-m-d') ?>");
        }else{
        fetchBills($('#search').val(), $(this).val());
        }
    });
    function fetchBills(search = '', date) {
        console.log('Search value:', search);
        console.log('Date value:', date);
    console.log(date);

    if(date==undefined){
date="<?php echo date('Y-m-d') ?>";
    }
        $.ajax({
            url: '{{ url('/billbook') }}',
            type: 'GET',
            data: { search: search, date: date },
            success: function(data) {
                $('.search_data').val(search);
                $('.date_data').val(date);
                let rows = '';
                $.each(data, function(index, row) {
                    rows += `<tr>
                        <td class="text-center"><input type="checkbox" id="selected_export" data-id="${row.id}"></td>
                        <td class="text-center">${row.bill_no}</td>
                        <td class="text-center">${row.file_no}</td>
                        <td class="text-center">
                            ${row.bill_image ? `<img src="{{ asset('public/media/photos/${row.bill_image}') }}" alt="" width="40" height="40" class="d-block rounded photoClick" data="{{ asset('public/media/photos/${row.bill_image}') }}">` : `<div style="width: 40px; height: 40px; background-color: grey;" class="d-block rounded"></div>`}
                        </td>
                        <td class="text-center">${row.first_name}</td>
                        <td class="text-center">${row.father_name}</td>
                        <td class="text-center">${row.date_of_birth}</td>
                        <td class="text-center">${row.uid_number}</td>
                        <td class="text-center">${row.med_qty}</td>
                        <td class="text-center">${row.total_amount} ₹</td>
                        <td class="text-center">
                            <a href="{{ url('bill/edit') }}/${row.id}" class="btn btn-success btn-sm waves-effect waves-light mb-2 mb-md-0 me-2" data-id="${row.id}">Edit</a>
                            <a href="{{ url('detail-bill') }}/${row.id}?from=billbook" class="btn btn-primary btn-sm btn-rounded me-2 waves-effect waves-light mb-2 mb-md-0" data-id="${row.id}">View Details</a>
                            <a href="{{ url('delete-bill') }}/${row.id}" onclick="return confirm('Are you sure?')"><i class="fas fa-times text-danger"></i></a>
                        </td>
                    </tr>`;
                });
                $('table tbody').html(rows);
            }
        });
    }
    $(document).on('click','.photoClick',function(){
            var data=$(this).attr('data');
            $('#modalImage').attr('src',data);
            $('#modalImg').modal('show')
        })
        $(document).on('click','.close-model',function(){
            $('#modalImg').modal('hide')
        })

    $('#search').on('keyup', function() {
        fetchBills($(this).val(),
         $('#date_range').val());
    });

    fetchBills();
    $('#pdfView').click(function(){
        var form = $('#pdf_view');
        form.attr('target', '_blank');
        form.submit();
        form.removeAttr('target');
    })
    $('#exlView').click(function(){
        $('#exl_view')[0].submit();
    })
})
const today = new Date();
const endOfDay = new Date(today.getFullYear(), today.getMonth(), today.getDate(), 23, 59, 59);

        flatpickr("#date_range", {
                mode: "range",
                dateFormat: "Y-m-d",
                defaultDate: [today, endOfDay], // Set default dates to today
                onClose: function(selectedDates, dateStr, instance) {
                    if (selectedDates.length === 2) {
                        console.log('s')
                        const endDate = new Date();
                        selectedDates[1] = endDate;
                        instance.setDate(selectedDates, false);
                    }
                }
            });
        $('.btn-print').on('click', function() {
            $(".is-invalid").removeClass('is-invalid');
            $(".invalid-feedback").html('');
            var isValid = true;
            var start_bill = $('#start_bill').val();
            var end_bill = $('#end_bill').val();

            var selectedIds = [];
            $('input[type=checkbox]:checked').each(function() {
                var id = $(this).data('id');
                if (id) {
                    selectedIds.push(id);
                }
            });

            // If any checkboxes are checked, skip validation of input fields
            if (selectedIds.length === 0) {
                if (start_bill === '') {
                    $("#start_bill").addClass('is-invalid').siblings('.invalid-feedback').html(
                        'This field is required.');
                    isValid = false;
                }
                if (end_bill === '') {
                    $("#end_bill").addClass('is-invalid').siblings('.invalid-feedback').html(
                        'This field is required.');
                    isValid = false;
                }
            }

            // Create hidden input fields for each selected ID
            selectedIds.forEach(function(id) {
                $('#print_form').append('<input type="hidden" name="selected_ids[]" value="' + id + '">');
            });

            if (isValid) {
                $('#start_field').val(start_bill);
                $('#end_field').val(end_bill);
                if ($('#duplicateCheck').is(':checked')) {
                    $('#duplicate').val('1');

                } else {
                    $('#duplicate').val('0');

                }
                $('#print_form').submit();
            }
        });


        $('.btn-download').on('click', function() {
            $(".is-invalid").removeClass('is-invalid');
            $(".invalid-feedback").html('');
            var isValid = true;
            var start_bill = $('#start_bill').val();
            var end_bill = $('#end_bill').val();
            var selectedIds = [];
            $('input[type=checkbox]:checked').each(function() {
                var id = $(this).data('id'); // Assuming the checkboxes have a data-id attribute
                if (id) {
                    selectedIds.push(id);
                }
            });
            if (selectedIds.length === 0) {
                if (start_bill === '') {
                    $("#start_bill").addClass('is-invalid').siblings('.invalid-feedback').html(
                        'This field is required.');
                    isValid = false;
                }
                if (end_bill === '') {
                    $("#end_bill").addClass('is-invalid').siblings('.invalid-feedback').html(
                        'This field is required.');
                    isValid = false;
                }
            }

            selectedIds.forEach(function(id) {
                $('#pdf_form').append('<input type="hidden" name="selected_ids[]" value="' + id + '">');
            });

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
        });



    </script>
@endsection
