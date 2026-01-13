<!DOCTYPE html>
<html>
<head>
    <title>Fee Balance Form - {{ $sr->adm_no }}</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h2 { margin: 0; }
        .info-section { margin-bottom: 20px; }
        .info-row { margin-bottom: 10px; }
        .label { font-weight: bold; display: inline-block; width: 200px; }
        .value { display: inline-block; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f0f0f0; }
        .total-row { font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h2>{{ Qs::getSystemName() }}</h2>
        <h3>FEE BALANCE FORM</h3>
    </div>

    <div class="info-section">
        <div class="info-row">
            <span class="label">Admission Number:</span>
            <span class="value">{{ $sr->adm_no }}</span>
        </div>
        <div class="info-row">
            <span class="label">Student Name:</span>
            <span class="value">{{ $sr->user->name }}</span>
        </div>
        <div class="info-row">
            <span class="label">Grade:</span>
            <span class="value">{{ $sr->my_class->name }}</span>
        </div>
        <div class="info-row">
            <span class="label">Session:</span>
            <span class="value">{{ $sr->session }}</span>
        </div>
        <div class="info-row">
            <span class="label">Date:</span>
            <span class="value">{{ date('d/m/Y') }}</span>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Fee Item</th>
                <th>Amount (KES)</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Admission Fee</td>
                <td>5,000.00</td>
                <td>{{ $admission_fee_paid ? 'PAID' : 'PENDING' }}</td>
            </tr>
            <tr>
                <td>Tuition Fee</td>
                <td>50,000.00</td>
                <td>PENDING</td>
            </tr>
            <tr>
                <td>Activity Fee</td>
                <td>2,000.00</td>
                <td>PENDING</td>
            </tr>
            <tr>
                <td>Library Fee</td>
                <td>1,000.00</td>
                <td>PENDING</td>
            </tr>
            <tr class="total-row">
                <td>Total Balance</td>
                <td>{{ $admission_fee_paid ? '58,000.00' : '63,000.00' }}</td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <div style="margin-top: 30px;">
        <p><strong>Note:</strong> Please settle all outstanding fees before the end of the term.</p>
        <p>For inquiries, contact: {{ Qs::getSetting('phone') }}</p>
    </div>
</body>
</html>

