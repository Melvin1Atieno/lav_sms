<!DOCTYPE html>
<html>
<head>
    <title>Admission Document - {{ $sr->adm_no }}</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h2 { margin: 0; }
        .info-section { margin-bottom: 20px; }
        .info-row { margin-bottom: 10px; }
        .label { font-weight: bold; display: inline-block; width: 200px; }
        .value { display: inline-block; }
        .signature-section { margin-top: 50px; }
        .signature-line { border-top: 1px solid #000; width: 300px; margin-top: 50px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>{{ Qs::getSystemName() }}</h2>
        <h3>ADMISSION DOCUMENT</h3>
    </div>

    <div class="info-section">
        <h4>Student Information</h4>
        <div class="info-row">
            <span class="label">Admission Number:</span>
            <span class="value">{{ $sr->adm_no }}</span>
        </div>
        <div class="info-row">
            <span class="label">Full Name:</span>
            <span class="value">{{ $sr->user->name }}</span>
        </div>
        @if($sr->user->first_name)
        <div class="info-row">
            <span class="label">First Name:</span>
            <span class="value">{{ $sr->user->first_name }}</span>
        </div>
        <div class="info-row">
            <span class="label">Last Name:</span>
            <span class="value">{{ $sr->user->last_name }}</span>
        </div>
        <div class="info-row">
            <span class="label">Surname:</span>
            <span class="value">{{ $sr->user->surname }}</span>
        </div>
        @endif
        <div class="info-row">
            <span class="label">Date of Birth:</span>
            <span class="value">{{ $sr->user->dob }}</span>
        </div>
        <div class="info-row">
            <span class="label">Gender:</span>
            <span class="value">{{ $sr->user->gender }}</span>
        </div>
        <div class="info-row">
            <span class="label">Grade:</span>
            <span class="value">{{ $sr->my_class->name }}</span>
        </div>
        <div class="info-row">
            <span class="label">Section:</span>
            <span class="value">{{ $sr->section->name }}</span>
        </div>
        @if($sr->nemis_number)
        <div class="info-row">
            <span class="label">NEMIS Number:</span>
            <span class="value">{{ $sr->nemis_number }}</span>
        </div>
        @endif
        @if($sr->previous_school)
        <div class="info-row">
            <span class="label">Previous School:</span>
            <span class="value">{{ $sr->previous_school }}</span>
        </div>
        @endif
        <div class="info-row">
            <span class="label">Year Admitted:</span>
            <span class="value">{{ $sr->year_admitted }}</span>
        </div>
        <div class="info-row">
            <span class="label">Session:</span>
            <span class="value">{{ $sr->session }}</span>
        </div>
    </div>

    @if($parents->count() > 0)
    <div class="info-section">
        <h4>Parent/Guardian Information</h4>
        @foreach($parents as $parent)
        <div style="margin-bottom: 15px;">
            <strong>{{ ucfirst($parent->relationship) }}:</strong><br>
            Name: {{ $parent->first_name }} {{ $parent->last_name }}<br>
            ID Number: {{ $parent->id_number }}<br>
            Phone: {{ $parent->phone_number }}
        </div>
        @endforeach
    </div>
    @endif

    <div class="signature-section">
        <p>This document certifies that the above student has been admitted to {{ Qs::getSystemName() }}.</p>
        <p>Date: {{ date('d/m/Y') }}</p>
        <div class="signature-line"></div>
        <p>Authorized Signature</p>
    </div>
</body>
</html>

