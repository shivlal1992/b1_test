@extends('admin.layouts.main')
@section('style')
@endsection
@section('content')
<div class="pagetitle">
      <!-- <h1>Plans</h1> -->
    </div>
    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">User Information
                <button onclick="history.back()" class="btn btn-sm btn-secondary" style="float:right;" >Go Back</button>
              </h5>
               <div class="table-responsive">
                    <table class="table table-bordered">
                    <tr><th>Full Name (As per official record)</th><td>{{ $user->name }}</td></tr>
                    <tr><th>Father’s Name (As per official record)</th><td>{{ $user->father_name }}</td></tr>
                    <tr><th>Date of Birth (As per official record)</th><td>{{ $user->dob }}</td></tr>
                    <tr><th>Gender</th><td>{{ $user->gender }}</td></tr>
                    <tr><th>Mobile Number</th><td>{{ $user->phone }}</td></tr>
                    <tr><th>Email</th><td>{{ $user->email }}</td></tr>
                    <tr><th>Permanent Address</th><td>{{ $user->permanent_address }}</td></tr>
                    <tr><th>Present Address</th><td>{{ $user->present_address }}</td></tr>
                    <tr><th>Aadhaar Number</th><td>{{ $user->aadhar_card }}</td></tr>
                    <tr><th>ID Card Number</th><td>{{ $user->id_card_no }}</td></tr>
                    <tr><th>PMIS Code</th><td>{{ $user->pmis_no }}</td></tr>
                    <tr>
                      <th>District/Unit</th>
                      <td>{{@$user->districtData->title ?? '-'}}</td>
                    </tr>
                    <tr><th>Unique Constable Number</th><td>{{ $user->uni_constable_no }}</td></tr>
                    <tr><th>Date of Appointment</th><td>{{ $user->date_of_join }}</td></tr>
                    <tr>
                        <th>Profile Image</th>
                        <td>
                            @if($user->profile_image)
                                <img src="{{ asset($user->profile_image) }}" width="100" alt="Profile Image">
                            @else
                                No Image Uploaded
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Signature</th>
                        <td>
                            @if($user->user_sign)
                                <img src="{{ asset($user->user_sign) }}" width="100" alt="Signature">
                            @else
                                No Signature Uploaded
                            @endif
                        </td>
                    </tr>
                    <tr><th>Self-Undertaking</th><td>{{ $user->is_self_undertaking ? 'Yes' : 'No' }}</td></tr>
                    <tr><th>Form Fill Date</th><td>{{ $user->form_fill_date }}</td></tr>
                    <tr><th>Form Fill Place</th><td>{{ $user->form_fill_place }}</td></tr>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
@endsection
@section('script')
@endsection
