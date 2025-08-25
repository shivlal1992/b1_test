<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Invoice PDF</title>
</head>
<body>
    <h1>Invoice with QR Code</h1>
    <p>Scan this QR:</p>

    {{-- Embed local PNG file --}}
    <img src="{{ $qrPath }}" alt="QR Code" width="300" height="300" />
</body>
</html>
