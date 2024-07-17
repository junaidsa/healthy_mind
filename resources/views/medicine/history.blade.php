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
                                <canvas id="bar" data-colors='["--bs-success-rgb, 0.8", "--bs-success" ]' height="200"></canvas>

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
    const ctx = document.getElementById('bar').getContext('2d');
    const data = {
        labels: {!! json_encode(array_keys($monthlyDataArray)) !!},
        datasets: [{
            label: 'Quantity',
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
            </script>
    @endsection
