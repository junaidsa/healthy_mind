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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">

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

        .bill {
            padding: 20px;
            width: 80%;
            margin: 10px;
        }

        .cut-line {
            margin-bottom: 20px;
            margin-top: 20px;
            border-left: 1px dashed #000;
            height: auto;
        }

        .duplicate {
            display: none;
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
    padding: .40    rem .75rem !important;
}

        p {
            margin-top: 0;
            margin-bottom: 0.4rem;
        }

        @media print {
            .container{
    padding-left: 10px!important;
    max-width: 100%;
    padding-right: 10px!important;
}

body{
    background-color: #ffffff !important;
}
            @page{
                orientation: landscape;
                margin-left: 0px;
                margin-right: 0px;
            }
            .hr-boader {
                height: 1px;
                background-color: #ced4da;
                margin-top: 0;
                margin-bottom: 8px;
            }

            .output-text {
                display: none;
            }

            /* .bill-container {
                display: block;
                margin: 0;
                width: 100%;
            } */
            /* .bill {
                width: 48%;
                margin: 0;
                border: none;
                /* page-break-after: always; */
            /* }  */
            /* .cut-line {
                display: none;
            } */
            .duplicate {
                display: block;
            }

            label,
            #duplicateCheck {
                display: none;
            }

            /* .text-center {
                text-align: center !important;
            } */
        }
    </style>
    <div class="container" >
        <label>

            <input type="checkbox" id="duplicateCheck" class="float-end" />
            <span>DUPLICATE</span>
        </label>

        <div class="text-center mt-2">

            <h1><b style="padding-left: 140px;" class="output-text">OUTPUT</b></h1>
        </div>
        <div class="bill-container" style="background-color: #fff;">
            <div class="bill" id="originalBill"  style="position: relative;">
                <img src="{{ asset('public/media/photos/scissors.png') }}" width="24px" style="position: absolute;right:-22.5px;top:20px" class="cutDiv d-none">
                <img src="{{ asset('public/media/photos/scissors.png') }}" width="24px" style="position: absolute;right:-22.5px;bottom:20px" class="cutDiv-bottom d-none">
                <h5 class="text-center"><b>MEDICAL RECEIPT</b></h5>
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
                    <div class="row justify-content-center">
                        <div class="col-6">
                            <p>RECEIPT NO: <span style="font-size: 14px; font-weight: 700;">{{ $bill->bill_no }}</span>
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
                    </div>
                </div>
                <div class="receipt-body">
                    <table class="table table-borderless">
                        <thead style="background: #eff2f766;">
                            <tr>
                                <th>S.No.</th>
                                <th>Medicine Name</th>
                                <th>BATCH</th>
                                <th>Quantity</th>
                                <th>Rate</th>
                                <th>Amount</th>
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
                    <div style="width: 30%">
                        <div class="d-flex justify-content-between">
                            <p style="font-weight: 500;">Sub Total:</p>
                            <p style="font-weight: 500;">{{ $bill->total_amount }} ₹</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p style="font-weight: 500;">Tax:</p>
                            <p style="font-weight: 500;">{{ $taxPercentage }} %</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p style="font-weight: 500;">Total:</p>
                            <p style="font-weight: 700;">{{ number_format($totalWithTax, 2) }} ₹</p>
                        </div>
                        {{-- <p style="font-weight: 500;">Sub Total: {{ $bill->total_amount }} ₹</p>
                        <p style="font-weight: 500;">Tax: <span>{{ $taxPercentage }}%</span></p>
                        <p style="font-weight: 500;">Total: <span style="font-size: 14px; font-weight: 500;">{{ number_format($totalWithTax, 2) }} ₹</span></p> --}}
                    </div>
                </div>
            </div>
            <div class="cut-line"></div>
            <div class="bill duplicate" id="duplicateBill">
                <h5 class="text-center"><b>MEDICAL RECEIPT</b></h5>
                <h3 class="text-center"><b>HEALTHY MIND (NEUROPSYCHIATRY CLINIC)<br>NAYA PARAS</b></h3>
                <p class="text-center" style="font-weight: 500; font-size: 14px;">Medical/hospital Address</p>
                <div class="hr-boader"></div>
                <div class="row justify-content-center" style="margin-bottom: 20px;">
                    <div class="col-6">
                        <p>RECEIPT NO: <span style="font-size: 14px; font-weight: 700;">{{ $bill->bill_no }}</span></p>
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
                </div>
                <div class="receipt-body">
                    <table class="table table-borderless">
                        <thead style="background: #eff2f766;">
                            <tr>
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
                    <div style="width: 30%">
                        <div class="d-flex justify-content-between">
                            <p style="font-weight: 500;">Sub Total:</p>
                            <p style="font-weight: 500;">{{ $bill->total_amount }} ₹</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p style="font-weight: 500;">Tax:</p>
                            <p style="font-weight: 500;">{{ $taxPercentage }} %</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p style="font-weight: 500;">Total:</p>
                            <p style="font-weight: 700;">{{ number_format($totalWithTax, 2) }} ₹</p>
                        </div>
                        {{-- <p style="font-weight: 500;">Sub Total: {{ $bill->total_amount }} ₹</p>
                        <p style="font-weight: 500;">Tax: <span>{{ $taxPercentage }}%</span></p>
                        <p style="font-weight: 500;">Total: <span style="font-size: 14px; font-weight: 500;">{{ number_format($totalWithTax, 2) }} ₹</span></p> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>




    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        document.getElementById('duplicateCheck').addEventListener('change', function() {
    if (this.checked) {

        this.nextElementSibling.style.backgroundColor = 'white';
        this.nextElementSibling.style.color = 'black';
    } else {
        this.nextElementSibling.style.backgroundColor = '';
        this.nextElementSibling.style.color = '';
    }
});
        $(document).ready(function() {
            $('.cut-line').addClass('d-none');
            $('#duplicateCheck').change(function() {
                if ($(this).is(':checked')) {
                    $('#duplicateBill').show();
                    $('.cut-line').removeClass('d-none');

                    $('.cutDiv').removeClass('d-none')
                    $('.cutDiv-bottom').removeClass('d-none')
                } else {
                    $('#duplicateBill').hide();
                    $('.cut-line').addClass('d-none');
                    $('.cutDiv').addClass('d-none')
                    $('.cutDiv-bottom').addClass('d-none')
                }
            });
            $('#duplicateCheck').change(function() {
                if ($(this).is(':checked')) {
                    var originalContent = $('#originalBill').html();
                    // $('#duplicateBill').html(originalContent).append('<h5 class="text-center">DUPLICATE</h5>');
                }
            });
        });
    </script>
</body>

</html>
