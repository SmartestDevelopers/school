<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Challan Receipt</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .container { width: 100%; max-width: 800px; margin: 0 auto; padding: 20px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 18px; }
        .header p { margin: 5px 0; }
        .details { margin-bottom: 20px; }
        .details table { width: 100%; border-collapse: collapse; }
        .details table th, .details table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .details table th { background-color: #f2f2f2; }
        .total { font-weight: bold; text-align: right; margin-top: 10px; }
        .status { text-align: right; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ $challan->school_name }}</h1>
            <p>Branch: {{ $challan->school_branch }}</p>
            <p>Challan Receipt</p>
        </div>
        <div class="details">
            <table>
                <tr>
                    <th>Academic Session</th>
                    <td>{{ $challan->academic_session }}</td>
                </tr>
                <tr>
                    <th>Year</th>
                    <td>{{ $challan->year }}</td>
                </tr>
                <tr>
                    <th>Class</th>
                    <td>{{ $challan->class }}</td>
                </tr>
                <tr>
                    <th>Section</th>
                    <td>{{ $challan->section }}</td>
                </tr>
                <tr>
                    <th>Months</th>
                    <td>{{ $challan->months }}</td>
                </tr>
                <tr>
                    <th>Students</th>
                    <td>{{ $challan->students }}</td>
                </tr>
                <tr>
                    <th>Student Name</th>
                    <td>{{ $challan->student_name }}</td>
                </tr>
                <tr>
                    <th>Roll Number</th>
                    <td>{{ $challan->roll_number }}</td>
                </tr>
                <tr>
                    <th>Fee Details</th>
                    <td>
                        @foreach($fees as $fee)
                            {{ $fee->fee_type }}: {{ number_format($fee->fee_amount, 2) }}<br>
                        @endforeach
                    </td>
                </tr>
            </table>
        </div>
        <div class="total">
            Total Fee: {{ number_format($challan->total_fee, 2) }}
        </div>
        <div class="status">
            Status: {{ ucfirst($challan->status) }}
        </div>
    </div>
</body>
</html>