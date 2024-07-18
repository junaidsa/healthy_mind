@extends('layouts.app');
@section('title', 'Medicines')
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
        #bar {
    height: 400px;
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
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex justify-content-between">
                        <div class="mt-6">

                        </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">

                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
@php
  $md = DB::table('medicines')->where('id',$id)->first();
@endphp

                                <h4 class="card-title mb-4">{{$md->name}} Analystics</h4>
                                <canvas id="meds" style="display: block;height: 420px;width: 100%;"></canvas>
                                {{-- <canvas id="meds" width="4444" height="2222"  class="chartjs-render-monitor"></canvas> --}}

                            </div>
                        </div>
                    </div> <!-- end col -->
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table mb-0">

                                <thead class="table-blue">
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Date</th>
                                        <th>Batch No</th>
                                        <th>Time</th>
                                        <th>Status</th>
                                    </tr>
                                     <thead>
                                <tbody>
                                    <tr>
                                        @foreach ($history as $his)
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $his->created_at }}</td>
                                            <td>{{ $his->batch_no }}</td>
                                            <td>{{ $his->time }}</td>
                                            <td>{{ $his->status }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $history->links('pagination::bootstrap-5') }}
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row -->

            </div> <!-- container-fluid -->
        </div>
        <!-- end main content-->
    @endsection
    @section('customJs')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
    const ctx = document.getElementById('meds').getContext('2d');
    const data = {
        labels: {!! json_encode(array_keys($monthlyDataArray)) !!},
        datasets: [{
            label: 'Sale QTY',
            data: {!! json_encode(array_values($monthlyDataArray)) !!},
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    };
    const config = {
        type: 'bar',
        data: data,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    };
    new Chart(ctx, config);
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
