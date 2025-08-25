<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admit Card</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      font-size: 14px;
      margin: 0;
      padding: 0;
    }
    .container {
      width: 100%;
      max-width: 800px;
      margin: auto;
      padding: 10px;
    }
    .admit-card {
      border: 2px solid #000;
      padding: 10px;
    }
    .row {
      display: flex;
      flex-wrap: wrap;
    }
    .col-4 {
      width: 33.33%;
    }
    .col-6 {
      width: 50%;
    }
    .col-8 {
      width: 66.66%;
    }
    .col-10 {
      width: 83.33%;
    }
    .col-12 {
      width: 100%;
    }
    .col-2 {
      width: 16.66%;
    }
    .txt-center {
      text-align: center;
    }
    .border {
      border: 1px solid #000;
    }
    .padding {
      padding: 10px;
    }
    .mar-bot {
      margin-bottom: 5px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    table td, table th {
      border: 1px solid #000;
      padding: 5px;
    }
    img {
      display: block;
      margin: auto;
      max-width: 100%;
      height: auto;
    }
    #qrcode {
      width: 100px;
      height: 100px;
    }
  </style>
</head>
<body>

<div style="width: 100%; max-width: 800px; margin: auto; padding: 10px;">
  <div style="border: 2px solid #000; padding: 10px;">
    
      <table style="width: 100%; border-collapse: collapse;">
        <tr>
          <td style="width: 80%; text-align: center;">
            <h3 style="margin: 0;">Admit Card</h3>
            <p style="margin: 0;">{{ @$exam->title }}</p>
          </td>

          <td style="width: 20%; text-align: right;">
            <img src="{{ @$qrPath }}" alt="QR Code" style="width: 100px; height: 100px;">
          </td>
        </tr>
      </table>
    <br>
    <table style="width: 100%; border-collapse: collapse; border: 1px solid #000; margin-bottom: 10px;">
        <tr>
            <td style="width: 75%; vertical-align: top; padding: 10px;">
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                <td style="border: 1px solid #000; padding: 5px;"><b>Exam ID:</b> {{ @$allocation->unique_id }}</td>
                <td style="border: 1px solid #000; padding: 5px;"><b>Center ID:</b> {{ @$center->id }}</td>
                </tr>
                <tr>
                <td style="border: 1px solid #000; padding: 5px;"><b>Candidate Name:</b> {{ @$user->name }}</td>
                <td style="border: 1px solid #000; padding: 5px;"><b>DOB:</b> {{ \Carbon\Carbon::parse($user->dob)->format('d M Y') }}</td>
                </tr>
                <tr>
                <td style="border: 1px solid #000; padding: 5px;"><b>Father Name:</b> {{ @$user->father_name }}</td>
                <td style="border: 1px solid #000; padding: 5px;"><b>Gender:</b> {{ @$user->gender }}</td>
                </tr>
                <tr>
                <td style="border: 1px solid #000; padding: 5px;"><b>Email:</b> {{ @$user->email }}</td>
                <td style="border: 1px solid #000; padding: 5px;"><b>Phone:</b> {{ @$user->phone }}</td>
                </tr>
                <tr>
                <td colspan="2" style="border: 1px solid #000; padding: 5px; height: 100px;">
                    <b>Address:</b> {{ @$user->permanent_address ?? '-' }}
                </td>
                </tr>
            </table>
            </td>

            <td style="width: 25%; vertical-align: top; text-align: center; padding: 10px;">
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                <td style="border: 1px solid #000; padding: 5px;">
                <div style="text-align: center;">
                  @if($user->profile_image)
                    <img src="{{ public_path($user->profile_image) }}"
                        style="width:100px; height:130px; object-fit:cover;" alt="Photo" />
                        @endif
                </div>
                </td>
                </tr>
                <tr>
                <td style="border: 1px solid #000; padding: 5px; margin-top: 5px;">
                <div style="text-align: center;">
                  @if($user->user_sign)
                    <img src="{{ public_path($user->user_sign) }}"
                        style="width:100px; height:50px; object-fit:contain;" alt="Signature" />
                        @endif
                </div>
                </td>
                </tr>
            </table>
            </td>
        </tr>
        </table>


    <div class="row border padding mar-bot txt-center">
      <div class="col-12">
        <h4 style="margin: 0;">EXAMINATION VENUE</h4>
        <p style="margin: 5px 0;">{{ $center->location }}</p>
        <p><b>Exam Date:</b> {{ \Carbon\Carbon::parse($exam->date)->format('d M Y') }}</p>

        <!-- ✅ Dynamic slot & time -->
        <p><b>Slot:</b> {{ ucfirst($allocation->slot) }}</p>
        <p><b>Time:</b> 
          {{ \Carbon\Carbon::parse($allocation->start_time)->format('h:i A') }}
           - 
          {{ \Carbon\Carbon::parse($allocation->end_time)->format('h:i A') }}
        </p>
      </div>
    </div>

  </div>
</div>

</body>
</html>
