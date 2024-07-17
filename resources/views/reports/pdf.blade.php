<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Bootstrap Css -->
    <link href="{{ asset('public') }}/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public') }}/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet"
        type="text/css" />

    <title>Bill Printing</title>
</head>

<body style="background:#f2f2f2;">
    <style>

        .bill-container {
            border: 1px solid #ced4da;
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
th{
    padding:10px
}
        .bill {
            padding: 20px;
            width: 100%;
            margin: 10px;
        }

        .cut-line {
            margin-bottom: 20px;
            margin-top: 20px;
            border-left: 1px dashed #000;
            height: auto;
        }



        label {
            display: inline-block;
            margin: 10px;
            float: right;

        }

        input[type="checkbox"] {
            width: 20px;
            height: 20px;
            margin: 0 10px 0 10px;
            vertical-align: middle;
        }

        table tbody td {
            border: none;
        }

        .receipt-footer {
            text-align: right;
        }

        .receipt-header,
        .receipt-body {
            margin-bottom: 20px;
        }

        input[type="checkbox"]:checked {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3E%3Cpath fill='none' stroke='%23fff' stroke-width='3' d='M1 1 L9 9 L19 1'/%3E%3C/svg%3E");
            background-size: 20px 20px;
            background-position: center;
            background-repeat: no-repeat;
            border: none;
        }

        .no-wrap {
            white-space: nowrap;
        }

        span {
            font-size: 16px;
            vertical-align: middle;
        }

        .container {
            font-family: "Roboto", sans-serif;
            font-style: normal;
        }

        input[type="checkbox"]:checked+span {
            background-color: white;
            color: black;
        }

        .hr-boader {
            height: 1px;
            background-color: #ced4da;
            margin-top: 0;
            margin-bottom: 8px;
        }

        .table>:not(caption)>*>* {
            padding: .40 rem .75rem !important;
        }

        p {
            margin-top: 0;
            margin-bottom: 0.4rem;
        }

        @page {
            margin-left: 0px;
            margin-right: 0px;
            orientation: landscape;
        }
    </style>
    <div class="container" style="float:left;width:100%">
        @foreach ($bills as $bill)
        <div class="bill-container"
        style="width:100%; background-color: #fff;{{ $loop->last ? '' : 'page-break-after: always;' }}">

                <div class="bill" id="originalBill" style="position: relative; {{ $duplicate == 0 ? 'width:100%' : 'width:45%;float: left;border-right:2px dotted;' }}">
                    {{-- <img src="{{ asset('public/media/photos/scissors.png') }}" width="24px"
                        style="position: absolute;right:-22.5px;top:20px" class="cutDiv d-none">
                    <img src="{{ asset('public/media/photos/scissors.png') }}" width="24px"
                        style="position: absolute;right:-22.5px;bottom:20px" class="cutDiv-bottom d-none"> --}}
                    <h5 class="text-center" style="font-weight: 800"><strong>MEDICAL RECEIPT</strong></h5>
                    <h3 class="text-center"><b>HEALTHY MIND (NEUROPSYCHIATRY CLINIC)<br>NAYA PARAS</b></h3>
                    <p class="text-center" style="font-weight: 500; font-size: 14px;">Medical/hospital Address</p>
                    <div class="hr-boader"></div>
                    @php
                        $patient = DB::table('patients')
                            ->where('id', $bill->patient_id)
                            ->first();
                        $dateOfBirth = \Carbon\Carbon::parse($patient->date_of_birth);
                        $age = $dateOfBirth->age;
                    @endphp
                    <div class="receipt-header">
                        <div class="row justify-content-center" style="width: 100%;">
                            <div class="col-6" style="float: left; width: 50%">
                                <p>RECEIPT NO: <span
                                        style="font-size: 14px; font-weight: 700;">{{ $bill->bill_no }}</span>
                                </p>
                                <p>File No: <span
                                        style="font-size: 14px; font-weight: 700; padding-left: 33px;">{{ $patient->file_no }}</span>
                                </p>
                                <p>Father's N: <span
                                        style="font-size: 14px; font-weight: 700; padding-left: 16px;">{{ $patient->father_name }}</span>
                                </p>
                                <p>UID No: <span
                                        style="font-size: 14px; font-weight: 700; padding-left: 35px;">{{ $patient->uid_number }}</span>
                                </p>
                                <p class="no-wrap">Address: <span
                                        style="font-size: 14px; font-weight: 700; padding-left: 28px;">{{ $patient->address }}</span>
                                </p>
                            </div>
                            <div class="col-6" style="float: left; width: 50%">
                                <p>Date & Time:&nbsp;&nbsp;<span
                                        style="font-size: 14px; font-weight: 700;">{{ $formattedDateTime }}</span></p>
                                <p>Name: <span
                                        style="font-size: 14px; font-weight: 700; padding-left: 40px;">{{ $patient->first_name }}</span>
                                </p>

                                <p>Age/Sex: <span
                                        style="font-size: 14px; font-weight: 700; padding-left: 26px;">{{ $age }}/{{ $patient->gender }}</span>
                                </p>

                                <p>M. No: <span
                                        style="font-size: 14px; font-weight: 700; padding-left: 41px;">+{{ $patient->mobile_no }}</span>
                                </p>
                            </div>
                            <div style="clear: both;"></div>
                        </div>
                    </div>
                    <div class="receipt-body">
                        <table class="table">
                            <thead style="background: #eff2f766;">
                                <tr  style="background: #eff2f766;">
                                    <th style="font-weight: 700;">S.No.</th>
                                    <th style="font-weight: 700;">Medicine Name</th>
                                    <th style="font-weight: 700;">BATCH</th>
                                    <th style="font-weight: 700;">Quantity</th>
                                    <th style="font-weight: 700;">Rate</th>
                                    <th style="font-weight: 700;">Amount</th>
                                </tr>
                            </thead>
                            @php
                                $items = DB::table('bill_items')
                                    ->join('medicines', 'bill_items.medicine_id', '=', 'medicines.id')
                                    ->where('bill_items.bill_id', $bill->id)
                                    ->get();
                            @endphp
                            <tbody>
                                @foreach ($items as $it)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $it->name }}</td>
                                        <td>{{ $it->batch_no }}</td>
                                        <td>{{ $it->qty }}</td>
                                        <td>{{ $it->rate }}</td>
                                        <td>{{ $it->qty * $it->rate }}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="receipt-footer d-flex justify-content-end">
                        @php
                            $taxPercentage = 18;
                            $taxAmount = $bill->total_amount * ($taxPercentage / 100);
                            $totalWithTax = $bill->total_amount + $taxAmount;
                        @endphp
                        <div style="width: 50%;float: right;">
                            <div class="d-flex justify-content-between" style="width: 100%">
                                <p style="font-weight: 500; width: 40%; float: left;">Sub Total:</p>
                                <p style="font-weight: 500;  width: 50%; float: left;">{{ $bill->total_amount }} ₹</p>
                            </div>
                            <div class="d-flex justify-content-between" style="width: 100%">
                                <p style="font-weight: 500; width: 40%; float: left;">Tax:</p>
                                <p style="font-weight: 500; width: 50%; float: left;">{{ $taxPercentage }} %</p>
                            </div>
                            <div class="d-flex justify-content-between" style="width: 100%">
                                <p style="font-weight: 500; width: 40%; float: left;">Total:</p>
                                <p style="font-weight: 700;  width: 50%; float: left;">{{ number_format($totalWithTax, 2) }} ₹</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div style=" {{ $duplicate == 0 ? 'display: none;' : 'width:50%; float: right;' }}">
                    <div class="cut-line"></div>
                    <div class="bill duplicate" id="duplicateBill">
                        <h5 class="text-center"><b>MEDICAL RECEIPT</b></h5>
                        <h3 class="text-center"><b>HEALTHY MIND (NEUROPSYCHIATRY CLINIC)<br>NAYA PARAS</b></h3>
                        <p class="text-center" style="font-weight: 500; font-size: 14px;">Medical/hospital Address</p>
                        <div class="hr-boader"></div>
                        {{-- <div class="row justify-content-center" style="margin-bottom: 20px;">
                            <div class="col-6">
                                <p>RECEIPT NO: <span
                                        style="font-size: 14px; font-weight: 700;">{{ $bill->bill_no }}</span>
                                </p>
                                <p>File No: <span
                                        style="font-size: 14px; font-weight: 700; padding-left: 33px;">{{ $patient->file_no }}</span>
                                </p>
                                <p>Father's N: <span
                                        style="font-size: 14px; font-weight: 700; padding-left: 16px;">{{ $patient->father_name }}</span>
                                </p>
                                <p>UID No: <span
                                        style="font-size: 14px; font-weight: 700; padding-left: 35px;">{{ $patient->uid_number }}</span>
                                </p>
                                <p class="no-wrap">Address: <span
                                        style="font-size: 14px; font-weight: 700; padding-left: 28px;">{{ $patient->address }}</span>
                                </p>
                            </div>
                            <div class="col-6">
                                <p>Date & Time:&nbsp;&nbsp;<span
                                        style="font-size: 14px; font-weight: 700;">{{ $formattedDateTime }}</span></p>
                                <p>Name: <span
                                        style="font-size: 14px; font-weight: 700; padding-left: 40px;">{{ $patient->first_name }}</span>
                                </p>

                                <p>Age/Sex: <span
                                        style="font-size: 14px; font-weight: 700; padding-left: 26px;">{{ $age }}/{{ $patient->gender }}</span>
                                </p>

                                <p>M. No: <span
                                        style="font-size: 14px; font-weight: 700; padding-left: 41px;">+{{ $patient->mobile_no }}</span>
                                </p>
                            </div>
                        </div> --}}
                        <div class="row justify-content-center" style="width: 100%;margin-bottom: 20px;">
                            <div class="col-6" style="float: left; width: 50%">
                                <p>RECEIPT NO: <span
                                        style="font-size: 14px; font-weight: 700;">{{ $bill->bill_no }}</span>
                                </p>
                                <p>File No: <span
                                        style="font-size: 14px; font-weight: 700; padding-left: 33px;">{{ $patient->file_no }}</span>
                                </p>
                                <p>Father's N: <span
                                        style="font-size: 14px; font-weight: 700; padding-left: 16px;">{{ $patient->father_name }}</span>
                                </p>
                                <p>UID No: <span
                                        style="font-size: 14px; font-weight: 700; padding-left: 35px;">{{ $patient->uid_number }}</span>
                                </p>
                                <p class="no-wrap">Address: <span
                                        style="font-size: 14px; font-weight: 700; padding-left: 28px;">{{ $patient->address }}</span>
                                </p>
                            </div>
                            <div class="col-6" style="float: left; width: 50%">
                                <p>Date & Time:&nbsp;&nbsp;<span
                                        style="font-size: 14px; font-weight: 700;">{{ $formattedDateTime }}</span></p>
                                <p>Name: <span
                                        style="font-size: 14px; font-weight: 700; padding-left: 40px;">{{ $patient->first_name }}</span>
                                </p>

                                <p>Age/Sex: <span
                                        style="font-size: 14px; font-weight: 700; padding-left: 26px;">{{ $age }}/{{ $patient->gender }}</span>
                                </p>

                                <p>M. No: <span
                                        style="font-size: 14px; font-weight: 700; padding-left: 41px;">+{{ $patient->mobile_no }}</span>
                                </p>
                            </div>
                            <div style="clear: both;"></div>
                        </div>
                        <div class="receipt-body">
                            <table class="table table-borderless">
                                <thead style="background: #eff2f766;">
                                    <tr  style="background: #eff2f766;">
                                        <th>S.No.</th>
                                        <th>Medicine Name</th>
                                        <th>BATCH</th>
                                        <th>Quantity</th>
                                        <th>Rate</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($items as $it)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $it->name }}</td>
                                            <td>{{ $it->batch_no }}</td>
                                            <td>{{ $it->qty }}</td>
                                            <td>{{ $it->rate }}</td>
                                            <td>{{ $it->qty * $it->rate }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="receipt-footer d-flex justify-content-end">
                            @php
                                $taxPercentage = 18;
                                $taxAmount = $bill->total_amount * ($taxPercentage / 100);
                                $totalWithTax = $bill->total_amount + $taxAmount;
                            @endphp
                            <div style="width: 50%;float: right;">
                                <div class="d-flex justify-content-between" style="width: 100%">
                                    <p style="font-weight: 500; width: 40%; float: left;">Sub Total:</p>
                                    <p style="font-weight: 500;  width: 50%; float: left;">{{ $bill->total_amount }} ₹</p>
                                </div>
                                <div class="d-flex justify-content-between" style="width: 100%">
                                    <p style="font-weight: 500; width: 40%; float: left;">Tax:</p>
                                    <p style="font-weight: 500; width: 50%; float: left;">{{ $taxPercentage }} %</p>
                                </div>
                                <div class="d-flex justify-content-between" style="width: 100%">
                                    <p style="font-weight: 500; width: 40%; float: left;">Total:</p>
                                    <p style="font-weight: 700;  width: 50%; float: left;">{{ number_format($totalWithTax, 2) }} ₹</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>





</body>

</html>
