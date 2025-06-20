<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 10px; }
        .fluid-container { width: 100%; }
        #challanTable { width: 100%; border-collapse: collapse; }
        .copy { width: 25%; padding: 5px; vertical-align: top; }
        .inner-table { width: 100%; border: 1px solid #000; font-size: 12px; }
        .inner-table td { padding: 5px; }
        .center { text-align: center; }
        .left { text-align: left; }
        .allBorders td { border: 1px solid #000; }
        .inner-table tr td:not(:last-child) { border-right: 1px solid #000; }
        .inner-table tr:not(:last-child) td { border-bottom: 1px solid #000; }
        .bg-gray { background-color: #d3d3d3; }
        .bold { font-weight: bold; }
        .large { font-size: 14px; }
    </style>
</head>
<body>
    <div class="fluid-container">
        <table id="challanTable">
            <tr>
                @foreach(['Bank Copy', 'School Copy', 'Student Copy', 'Teacher Copy'] as $copy)
                    <td class="copy">
                        <table class="inner-table">
                            <tr>
                                <td colspan="6" class="center bold">FEE CHALLAN (NON-REFUNDABLE)</td>
                            </tr>
                            <tr>
                                <td colspan="6" class="center bold">{{ strtoupper(str_replace('Copy', "'s Copy", $copy)) }}</td>
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
                                <td colspan="6" class="left bold">
                                    Due Date: <strong>{{ $challan->due_date }}</strong>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6" class="left">
                                    Period = From: <strong>{{ $challan->from_month }}-{{ $challan->from_year }}</strong>
                                    @if($challan->to_month) To: <strong>{{ $challan->to_month }}-{{ $challan->to_year }}</strong> @endif
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6" class="left">
                                    Student Name: <strong>{{ $challan->full_name }}</strong>
                                    D/O <strong>{{ $challan->father_name }}</strong>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6" class="left">
                                    G.R No: <strong>{{ $challan->gr_number }}</strong>
                                    Class/Sec: <strong>{{ $challan->class }}-{{ $challan->section }}</strong>
                                </td>
                            </tr>
                            <tr class="allBorders bg-gray">
                                <td>Sr</td><td>Govt Fee</td><td>Rs</td>
                                <td>Sr</td><td>Fund</td><td>Rs</td>
                            </tr>
                            @php
                                $govtFeeTypes = ['Admission', 'Tution', 'Breakage', 'Misc', 'SLC'];
                                $fundFeeTypes = ['IDF', 'Exams', 'IT', 'CSF', 'RDF/CDF', 'Security'];
                                $govtFees = $fees->whereIn('fee_type', $govtFeeTypes);
                                $fundFees = $fees->whereIn('fee_type', $fundFeeTypes);
                                $govtTotal = $govtFees->sum('fee_amount');
                                $fundTotal = $fundFees->sum('fee_amount');
                                $grandTotal = $govtTotal + $fundTotal;
                            @endphp
                            @foreach($govtFees as $index => $fee)
                                <tr class="allBorders">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $fee->fee_type }}</td>
                                    <td class="bold">{{ number_format($fee->fee_amount, 0) }}</td>
                                    @php $fundFee = $fundFees->skip($index)->first() @endphp
                                    @if($fundFee)
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $fundFee->fee_type }}</td>
                                        <td class="bold">{{ number_format($fundFee->fee_amount, 0) }}</td>
                                    @else
                                        <td></td><td></td><td></td>
                                    @endif
                                </tr>
                            @endforeach
                            <tr class="allBorders bg-gray">
                                <td></td><td>Total</td><td class="bold">{{ number_format($govtTotal, 0) }}</td>
                                <td></td><td>Total</td><td class="bold">{{ number_format($fundTotal, 0) }}</td>
                            </tr>
                            <tr class="allBorders bg-gray">
                                <td></td><td></td><td></td>
                                <td></td><td>G.Total</td><td class="bold">{{ number_format($grandTotal, 0) }}</td>
                            </tr>
                            <tr>
                                <td colspan="6" class="left">
                                    Rupees (In words): <strong class="large">{{ strtoupper($challan->amount_in_words) }}</strong>
                                    <br><br><br><br><br><br><br><br>
                                    Depositor's Sign        Bank Officer's Sign
                                </td>
                            </tr>
                        </table>
                    </td>
                @endforeach
            </tr>
        </table>
    </div>
</body>
</html>