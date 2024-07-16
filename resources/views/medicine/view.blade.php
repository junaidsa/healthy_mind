@extends('layouts.app');
@section('main')
    <style>
        .table-blue {
            background-color: #2E4661;
            color: #FFFFFF;
        }

        .sm-card {
            height: 4.2rem;
            text-align: unset;

        }

        .lg-card {
            height: 5.2rem;
            text-align: unset;

        }

        .search-container {
            position: relative;
            display: flex;
            align-items: center;
            background: #fff;
            width: 220px;
            border: 1px solid #ccc;
            border-radius: 25px;
            overflow: hidden;
        }

        .btn-black {
            color: #303133;
        }

        .search-input {
            width: 100%;
            padding: 10px -18px;
            border: none;
            font-size: 14px;
            outline: none;
            border-radius: 25px 0 0 25px;
        }

        .search-button {
            background-color: #fff;
            padding: 10px 8px;
            border: none;
            cursor: pointer;
            border-radius: 0 25px 25px 0;
            margin-left: 2px;
        }

        .btn-font {
            font-size: 1rem;
        }

        .mt-6 {
            margin-top: 3.5rem !important;
        }
    </style>
    <div class="page-content">
        <div class="container-fluid">
            <div class="modal fade transaction-detailModal" tabindex="-1" role="dialog"
                        aria-labelledby="transaction-detailModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="transaction-detailModalLabel">Add Stock</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{url('stock/store')}}" id="createMedianForm" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="medicine" class="form-label">Medicine <span
                                        class="text-danger">*</span></label>
                                <select name="medicine" id="medicine" class="mb-3 form-select ">
                                    <option value="">Select Medicine</option>
                                    @foreach ($medicines as $m)
                                    <option value="{{$m->id}}">{{$m->name}}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="mb-3">
                                <label for="batch_no">Batch No <span class="text-danger">*</span></label>
                                <input type="text" autocomplete="off" class="form-control " name="batch_no" id="batch_no" placeholder="Enter Batch No"
                                    value="">
                                    <div class="invalid-feedback"></div>

                            </div>

                            <div class="mb-3">
                                <label for="incoming_stock" class="form-label">Stock <span class="text-danger">*</span></label>
                                <input type="number" autocomplete="off" class="form-control" id="quantity" name="quantity">
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="float-end">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success">Add stock</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
            <div class="row mt-2">
                @foreach ($medicines as $medicine)

                <div class="col-sm-3">
                    <div class="card mini-stats-wid">
                        <div class="card-body lg-card">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p style="margin-bottom: 0;"><strong style="font-size: larger;">{{$medicine->name}}</strong></p>
                                    <span class="font-g">{{$medicine->rate}}</span>
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
                @endforeach

            </div>

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex justify-content-between">
                        <div class="mt-6">
                        </div>

                        <div class="page-title-right">
                            <div class="m-4 mb-2">

                                <a href="{{ url('medicines/create') }}" class="btn-sm btn btn-success btn-font"> <span
                                        class="mdi mdi-plus"></span> Add Medicine</a>


                                <a href="javascript: void(0);" data-bs-toggle="modal"
                                    data-bs-target=".transaction-detailModal"
                                    class="btn-sm btn btn-success btn-font has-arrow waves-effect">
                                    <span class="mdi mdi-plus"></span>

                                    Add Stock
                                </a>
                            </div>
                            {{-- <div class="search-container">
                            <button class="search-button">
                                <i class="fa fa-search" class="search-button"></i>
                            </button>
                            <input type="text" placeholder="Search..." class="search-input" id="searchInput" value="{{Request::get('keywords')}}" >
                        </div> --}}

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table mb-0">

                                <thead class="table-blue">
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Name.</th>
                                        <th>Rate</th>
                                        <th>Tax</th>
                                        <th>Stock</th>
                                        <th>Stock Left</th>
                                        <th>Options</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        @foreach ($medicines as $medicine)
                                            <td>{{ $medicine->id }}</td>
                                            <td>{{ $medicine->name }}</td>
                                            <td>{{ $medicine->rate }}</td>
                                            <td>{{ $medicine->tax }}</td>
                                            @php
                                            $leftstock = DB::table('batches')
                                                ->where('medicine_id', $medicine->id)
                                                ->sum('quantity');
                                            $salestock = DB::table('bill_items')
                                                ->where('medicine_id', $medicine->id)
                                                ->sum('qty');

                                            $totalstock = $salestock + $leftstock;
                                        @endphp
                                            <td>{{$totalstock}}</td>
                                            <td>{{$leftstock}}</td>
                                            <td>
                                                <a href="{{ url('medicines') . '/' . $medicine->id . '/edit' }}"
                                                    class="btn-black">Edit </a>
                                                &nbsp;&nbsp;
                                                <a href="javascript: void(0);"
                                                    class="btn-stock btn-black" data-bs-toggle="modal"
                                                    data-bs-target=".transaction-detailModal" data-medicine_id="{{$medicine->id}}">Add Stock</a>
                                                &nbsp;&nbsp;
                                                <a href="{{ url('add-bill') . '/' . $medicine->id }}"
                                                    class="btn-black">History</a>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $medicines->links('pagination::bootstrap-5') }}
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row -->

            </div> <!-- container-fluid -->
        </div>
        <!-- end main content-->
    @endsection
    @section('customJs')
        <script>
            // function parseQueryString(url) {
            //     var params = {};
            //     var queryString = url.split('?')[1];
            //     if (queryString) {
            //         queryString.split('&').forEach(function(pair) {
            //             pair = pair.split('=');
            //             params[pair[0]] = decodeURIComponent(pair[1] || '');
            //         });
            //     }
            //     return params;
            // }
            // var baseUrl = "{{ route('patients.index') }}";
            // var currentUrl = window.location.href;
            // var parsedParams = parseQueryString(currentUrl);
            // var url = new URL(baseUrl);
            // Object.keys(parsedParams).forEach(function(key) {
            //     url.searchParams.append(key, parsedParams[key]);
            // });
            // const searchInput = document.getElementById('searchInput');
            // searchInput.addEventListener('keypress', function(event) {
            //     if (event.key === 'Enter') {
            //         var params = url.searchParams;
            //         var keywords = $("#searchInput").val();
            //         params.set("keywords", keywords);
            //         if (keywords) {} else {
            //             url.search = '';
            //         }
            //         url.search = params.toString();
            //         window.location.href = url.toString();
            //     }
            // });
            $('#createMedianForm').submit(function(event) {
            $(".is-invalid").removeClass('is-invalid');
            $(".invalid-feedback").html('');
            var quantity = $("#quantity").val();
            var medicine = $("#medicine").val();
            var batch_no = $("#batch_no").val();
            var isValid = true;
            if (quantity === '') {
                $("#quantity").addClass('is-invalid').siblings('.invalid-feedback').html('Stock. is required.');
                isValid = false;
            }
            if (medicine === '') {
                $("#medicine").addClass('is-invalid').siblings('.invalid-feedback').html('Medicine is required.');
                isValid = false;
            }

            if (batch_no === '') {
                $("#batch_no").addClass('is-invalid').siblings('.invalid-feedback').html('Batch No is required.');
                isValid = false;
            }

                 if (!isValid) {
                event.preventDefault();             }
        });
        var modalTriggerLinks = document.querySelectorAll('.btn-stock');

modalTriggerLinks.forEach(function(link) {
    link.addEventListener('click', function() {
        var medicineId = this.getAttribute('data-medicine_id');
        var modalForm = document.getElementById('createMedianForm');
        var modalSelect = modalForm.querySelector('#medicine');

        // Set the default selected medicine in the modal form
        modalSelect.value = medicineId;
});

        })
            </script>
    @endsection
