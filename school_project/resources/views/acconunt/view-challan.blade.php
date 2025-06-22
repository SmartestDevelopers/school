@extends('layouts.front')

@section('content')
<style>
    body {
        font-family: "sans-serif", sans-serif;
        font-size: 14px !important;
    }
    .challan-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 10px;
        margin-bottom: 20px;
    }
    .card {
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        page-break-inside: avoid;
    }
    .card-header {
        background: linear-gradient(to right, #E4E5E6, #0072ff);
        color: #000;
        font-size: 27px;
        font-weight: bold;
        text-align: left;
        padding: 10px;
        position: relative;
    }
    .status {
        position: absolute;
        top: 10px;
        right: 10px;
        text-align: right;
    }
    .status h1 {
        font-size: 24px;
        margin: 0;
        color: {{ $challan->status == 'paid' ? 'green' : 'red' }};
    }
    .card-body {
        padding: 15px;
    }
    .inner-table {
        border-collapse: collapse;
        width: 100%;
        border: 1px solid #000;
        margin-bottom: 10px;
        font-size: 12px;
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
    .total-sum {
        font-size: 16px;
        font-weight: bold;
        text-align: right;
        margin-top: 20px;
    }
    .large {
        font-size: 16px;
        font-weight: bold;
    }
    .signature-box {
        border: 1px solid #000;
        width: 150px;
        height: 40px;
        display: inline-block;
        text-align: center;
        line-height: 40px;
        margin-right: 20px;
    }
    @media print {
        .challan-grid {
            display: block;
        }
        .card {
            page-break-after: always;
        }
    }
</style>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @foreach($challans as $ch)
                <div class="challan-grid">
                    @foreach(['Bank Copy', 'School Copy', 'Student Copy', 'Teacher Copy'] as $copy)
                        <div class="card">
                            <div class="card-header">
                                C H A L L A N
                                <div class="status">
                                    <h1><strong>{{ strtoupper($ch->status) }}</strong></h1>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="inner-table">
                                    <tbody>
                                        <tr>
                                            <td colspan="4" class="center">FEE CHALLAN ( NON - REFUNDABLE )</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="center">{{ strtoupper($copy) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="center">{{ $ch->school_name }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="center">Bank Makramah Ltd</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="center">STUDENT FUND</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="left">A/C No # 1-99-15-26201-714-114164</td>
                                        </tr>
                                        <tr>
                                            <td class="left" colspan="4">
                                                Issued on: <strong>{{ \Carbon\Carbon::parse($ch->created_at)->format('d/m/Y') }}</strong>
                                                Due Date: <strong>{{ $ch->due_date }}</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="left" colspan="4">
                                                Period = From: <strong>{{ $ch->from_month }}-{{ $ch->from_year }}</strong>
                                                @if($ch->to_month && $ch->to_year)
                                                    To: <strong>{{ $ch->to_month }}-{{ $ch->to_year }}</strong>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="left" colspan="4">
                                                Student Name: <strong>{{ $ch->full_name }}</strong> S/O <strong>{{ $ch->father_name }}</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="left" colspan="4">
                                                G.R No: <strong>{{ $ch->gr_number }}</strong> Class / Sec: <strong>{{ $ch->class }}-{{ $ch->section }}</strong>
                                            </td>
                                        </tr>
                                        <tr class="allBorders">
                                            <td style="background-color:#d3d3d3;">Sr</td>
                                            <td style="background-color:#d3d3d3;">Fee Type</td>
                                            <td style="background-color:#d3d3d3;">Rs</td>
                                            <td style="background-color:#d3d3d3;">Total</td>
                                        </tr>
                                        @php
                                            $total = 0;
                                        @endphp
                                        @foreach($fee_types as $index => $type)
                                            @if(isset($fees[$ch->id][$type]) && $fees[$ch->id][$type] > 0)
                                                <tr>
                                                    <td class="border">{{ $index + 1 }}</td>
                                                    <td class="border">{{ $type }}</td>
                                                    <td class="border"><strong>{{ number_format($fees[$ch->id][$type], 2) }}</strong></td>
                                                    <td class="border"><strong>{{ number_format($fees[$ch->id][$type], 2) }}</strong></td>
                                                </tr>
                                                @php
                                                    $total += $fees[$ch->id][$type];
                                                @endphp
                                            @endif
                                        @endforeach
                                        <tr>
                                            <td style="background-color:#d3d3d3;"></td>
                                            <td style="background-color:#d3d3d3;">Grand Total</td>
                                            <td style="background-color:#d3d3d3;"></td>
                                            <td style="background-color:#d3d3d3;"><strong>{{ number_format($total, 2) }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="left">
                                                Rupees (In words): <strong class="large">{{ strtoupper($ch->amount_in_words) }}</strong>
                                                <br><br>
                                                <span class="signature-box">Depositor's Sign</span>
                                                <span class="signature-box">Bank Officer's Sign</span>
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
                Rupees (In words): <strong>{{ $total_fee_sum_words }}</strong>
            </div>
        </div>
    </div>
</div>
@endsection