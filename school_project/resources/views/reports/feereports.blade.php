<!DOCTYPE html>
<html>
<head>
    <title>Fee Reports</title>
</head>
<body>
    <h1>Class-wise Fee Report</h1>
    <table border="1">
        <tr>
            <th>Class</th>
            <th>Total Fee</th>
            <th>Total Paid</th>
            <th>Total Unpaid</th>
        </tr>
        @foreach ($classWiseFeeReport as $report)
            <tr>
                <td>{{ $report->class }}</td>
                <td>{{ $report->total_fee }}</td>
                <td>{{ $report->total_paid }}</td>
                <td>{{ $report->total_unpaid }}</td>
            </tr>
        @endforeach
    </table>

    <h1>Class-wise Student Fee History (Last 12 Months)</h1>
    <table border="1">
        <tr>
            <th>Class</th>
            <th>Student ID</th>
            <th>Student Name</th>
            <th>Roll</th>
            <th>Month</th>
            <th>Year</th>
            <th>Fee Amount</th>
            <th>Paid Amount</th>
            <th>Status</th>
            <th>Unpaid Amount</th>
        </tr>
        @foreach ($classWiseFeeHistory as $history)
            <tr>
                <td>{{ $history->class }}</td>
                <td>{{ $history->student_id }}</td>
                <td>{{ $history->student_name }}</td>
                <td>{{ $history->roll }}</td>
                <td>{{ $history->month }}</td>
                <td>{{ $history->year }}</td>
                <td>{{ $history->fee_amount }}</td>
                <td>{{ $history->paid_amount }}</td>
                <td>{{ $history->status }}</td>
                <td>{{ $history->unpaid_amount }}</td>
            </tr>
        @endforeach
    </table>

    <h1>Class-wise Months Paid/Unpaid</h1>
    <table border="1">
        <tr>
            <th>Class</th>
            <th>Months Paid</th>
            <th>Months Unpaid</th>
        </tr>
        @foreach ($classWiseMonthsStatus as $status)
            <tr>
                <td>{{ $status->class }}</td>
                <td>{{ $status->months_paid }}</td>
                <td>{{ $status->months_unpaid }}</td>
            </tr>
        @endforeach
    </table>

    <h1>Student Fee Status (Last 12 Months)</h1>
    <table border="1">
        <tr>
            <th>Class</th>
            <th>Student ID</th>
            <th>Student Name</th>
            <th>Roll</th>
            <th>Paid Months</th>
            <th>Unpaid Months</th>
            <th>Total Paid</th>
            <th>Total Unpaid</th>
        </tr>
        @foreach ($studentFeeStatus as $status)
            <tr>
                <td>{{ $status->class }}</td>
                <td>{{ $status->student_id }}</td>
                <td>{{ $status->student_name }}</td>
                <td>{{ $status->roll }}</td>
                <td>{{ $status->paid_months ?? 'None' }}</td>
                <td>{{ $status->unpaid_months ?? 'None' }}</td>
                <td>{{ $status->total_paid }}</td>
                <td>{{ $status->total_unpaid }}</td>
            </tr>
        @endforeach
    </table>
</body>
</html>