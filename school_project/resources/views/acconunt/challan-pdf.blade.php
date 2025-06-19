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
                                    Issued on: <strong>{{ $challan->issued_on }}</strong>
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
                                    Student Name: <strong>{{ $challan->student_name }}</strong>
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
                                $govtFees = ['Admission' => 0, 'Tution' => 40, 'Breakage' => 0, 'Misc' => 0, 'SLC' => 40];
                                $fundFees = ['IDF' => 215, 'Exams' => 85, 'IT' => 50, 'CSF' => 250, 'RDF/CDF' => 100, 'Security' => 100];
                                $govtTotal = array_sum($govtFees);
                                $fundTotal = array_sum($fundFees);
                                $grandTotal = $govtTotal + $fundTotal;
                            @endphp
                            @foreach($govtFees as $type => $amount)
                                @php $index = array_search($type, array_keys($govtFees)) + 1; @endphp
                                <tr class="allBorders">
                                    <td>{{ $index }}</td>
                                    <td>{{ $type }}</td>
                                    <td class="bold">{{ number_format($amount, 0) }}</td>
                                    @if($index <= count($fundFees))
                                        @php $fundType = array_keys($fundFees)[$index-1]; $fundAmount = $fundFees[$fundType]; @endphp
                                        <td>{{ $index }}</td>
                                        <td>{{ $fundType }}</td>
                                        <td class="bold">{{ number_format($fundAmount, 0) }}</td>
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
                                    Depositor's Sign       Bank Officer's Sign
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