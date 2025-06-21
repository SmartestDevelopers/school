<!DOCTYPE html>
<html>
<head>
    <style>
        @page {
            size: legal landscape;
            margin: 10mm;
        }
        body {
            font-family: "sans-serif", sans-serif;
            font-size: 14px !important;
            margin: 0;
            padding: 0;
        }
        .card {
            border-radius: 8px;
            border: 1px solid #000;
            margin-bottom: 20px;
            page-break-inside: avoid;
        }
        .card-header {
            background: linear-gradient(to right, #E4E5E6, #0072ff);
            color: #000;
            font-size: 27px;
            font-weight: bold;
            text-align: left;
            padding: 10px;
        }
        .card-body {
            padding: 15px;
        }
        .status {
            float: right;
            width: 200px;
            text-align: right;
        }
        .status h1 {
            font-size: 24px;
            margin: 0;
        }
        .challan-container {
            margin-bottom: 30px;
        }
        .inner-table {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid #000;
            margin-bottom: 10px;
        }
        td.center {
            text-align: center;
            border-bottom: 1px solid #000;
            font-weight: bold;
        }
        td.copy {
            text-align: left;
            border-bottom: none;
            font-weight: bold;
        }
        td.left {
            text-align: left;
            border-bottom: 1px solid #000;
            font-weight: bold;
        }
        tr.allBorders td {
            border: 1px solid #000 !important;
        }
        td.border {
            border: 1px solid #000 !important;
        }
        tr.lineBorders td {
            border: 1px solid #000;
        }
        tr {
            height: 10px !important;
        }
        .total-sum {
            font-size: 16px;
            font-weight: bold;
            text-align: right;
            margin-top: 20px;
            page-break-before: avoid;
        }
        .large {
            font-size: 16px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @foreach($challans as $challan)
                    <div class="challan-container">
                        @foreach(['Bank Copy', 'School Copy', 'Student Copy', 'Teacher Copy'] as $copy)
                            <div class="card">
                                <div class="card-header">
                                    C H A L L A N
                                    <div class="status">
                                        <h1><strong>{{ strtoupper($challan->status) }}</strong></h1>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table class="inner-table">
                                        <tbody>
                                            <tr>
                                                <td colspan="6" class="center">FEE CHALLAN ( NON - REFUNDABLE )</td>
                                            </tr>
                                            <tr>
                                                <td colspan="6" class="center">{{ strtoupper($copy) }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="6" class="center">{{ $challan->school_name }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="6" class="center">Bank Makramah Ltd</td>
                                            </tr>
                                            <tr>
                                                <td colspan="6" class="center">STUDENT FUND</td>
                                            </tr>
                                            <tr>
                                                <td colspan="6" class="left">A/C No # 1-99-15-26201-714-114164</td>
                                            </tr>
                                            <tr>
                                                <td class="left" colspan="6">
                                                    Issued on: <strong>{{ \Carbon\Carbon::parse($challan->created_at)->format('d/m/Y') }}</strong>
                                                    Due Date: <strong>{{ $challan->due_date }}</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="left" colspan="6">
                                                    Period = From: <strong>{{ $challan->from_month }}-{{ $challan->from_year }}</strong>
                                                    @if($challan->to_month && $challan->to_year)
                                                        To: <strong>{{ $challan->to_month }}-{{ $challan->to_year }}</strong>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="left" colspan="6">
                                                    Student Name: <strong>{{ $challan->full_name }}</strong> S/O <strong>{{ $challan->father_name }}</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="left" colspan="6">
                                                    G.R No: <strong>{{ $challan->gr_number }}</strong> Class / Sec: <strong>{{ $challan->class }}-{{ $challan->section }}</strong>
                                                </td>
                                            </tr>
                                            <tr class="allBorders">
                                                <td style="background-color:#d3d3d3;" class="">Sr</td>
                                                <td style="background-color:#d3d3d3;" class="">Govt Fee</td>
                                                <td style="background-color:#d3d3d3;" class="">Rs</td>
                                                <td style="background-color:#d3d3d3;" class="">Sr</td>
                                                <td style="background-color:#d3d3d3;" class="">Fund</td>
                                                <td style="background-color:#d3d3d3;" class="">Rs</td>
                                            </tr>
                                            @php
                                                $govtFees = ['Admission' => 0, 'Tuition' => 0, 'Breakage' => 0, 'Misc' => 0, 'SLC' => 0];
                                                $fundFees = ['IDF' => 0, 'Exams' => 0, 'IT' => 0, 'CSF' => 0, 'RDF / CDF' => 0, 'Security' => 0];
                                                $govtTotal = 0;
                                                $fundTotal = 0;
                                                if (isset($fees[$challan->id])) {
                                                    foreach ($fees[$challan->id] as $fee) {
                                                        if (array_key_exists($fee->fee_type, $govtFees)) {
                                                            $govtFees[$fee->fee_type] = $fee->fee_amount;
                                                            $govtTotal += $fee->fee_amount;
                                                        } elseif (array_key_exists($fee->fee_type, $fundFees)) {
                                                            $fundFees[$fee->fee_type] = $fee->fee_amount;
                                                            $fundTotal += $fee->fee_amount;
                                                        }
                                                    }
                                                }
                                            @endphp
                                            @foreach($govtFees as $type => $amount)
                                                <tr>
                                                    <td class="border">{{ $loop->iteration }}</td>
                                                    <td class="border">{{ $type }}</td>
                                                    <td class="border"><strong>{{ $amount }}</strong></td>
                                                    <td class="border">{{ $loop->iteration }}</td>
                                                    <td class="border">{{ array_keys($fundFees)[$loop->index] }}</td>
                                                    <td class="border"><strong>{{ $fundFees[array_keys($fundFees)[$loop->index]] }}</strong></td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td style="background-color:#d3d3d3;" class=""></td>
                                                <td style="background-color:#d3d3d3;" class="">Total</td>
                                                <td style="background-color:#d3d3d3;" class=""><strong>{{ $govtTotal }}</strong></td>
                                                <td style="background-color:#d3d3d3;" class=""></td>
                                                <td style="background-color:#d3d3d3;" class="">Total</td>
                                                <td style="background-color:#d3d3d3;" class=""><strong>{{ $fundTotal }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td style="background-color:#d3d3d3;" class=""></td>
                                                <td style="background-color:#d3d3d3;" class="">G.Total</td>
                                                <td style="background-color:#d3d3d3;" class=""><strong>{{ $challan->total_fee }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td colspan="6" class="left">
                                                    Rupees (In words): <strong class="large">{{ strtoupper($challan->amount_in_words) }}</strong>
                                                    <br><br><br><br><br><br><br><br>
                                                    Depositor's Sign        Bank Officer's Sign
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
                <div class="total-sum">
                    Total Fee for All Students: <strong>{{ number_format($total_fee_sum, 2) }}</strong>
                    <br>
                    Rupees (In words): <strong>{{ strtoupper((new NumberFormatter('en', NumberFormatter::SPELLOUT))->format($total_fee_sum)) . ' ONLY' }}</strong>
                </div>
            </div>
        </div>
    </div>
</body>
</html>