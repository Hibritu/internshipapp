<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Certificate of Completion</title>
    <style>
        body {
            text-align: center;
            font-family: Arial, sans-serif;
            border: 10px solid #ccc;
            padding: 50px;
        }

        h1 {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .content {
            margin-top: 30px;
            font-size: 18px;
        }

        .name {
            font-size: 24px;
            font-weight: bold;
            margin: 15px 0;
        }

        .category {
            font-size: 20px;
            font-weight: bold;
            margin: 15px 0;
        }

        .company {
            font-size: 20px;
            font-weight: bold;
        }

        .date-range {
            margin: 20px 0;
            font-size: 18px;
        }

        .signature {
            margin-top: 60px;
            font-size: 18px;
        }

        .signature-image {
            width: 150px;
            height: auto;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <h1>Certificate of Completion</h1>

    <div class="content">
        <p>This certifies that</p>

        <p class="name">{{ $name }}</p>

        <p>has successfully completed an internship program with</p>

        <p class="company">Ewnet Communication P.L.C</p>

        @if(isset($category))
            <p class="category">as a {{ $category }}</p>
        @endif

        <p class="date-range">
            from {{ $start_date }} to {{ $end_date }}
        </p>

        <div class="signature">
            <img src="{{ public_path('images/signature.png') }}" class="signature-image" alt="Signature">
            <p><strong>Samual</strong></p>
            <p>Manager</p>
            <p>Ewnet Communication P.L.C</p>
        </div>
    </div>
</body>
</html>
