@extends('admin.layouts.main')
@section('style')
@endsection
@section('content')
<div class="pagetitle">
      <h1>Profile Details</h1>
    </div>
    <section class="section profile">
      <div class="row">
        <div class="col-xl-12">
          <div class="card">
            <div class="card-body pt-3">
              <ul class="nav nav-tabs nav-tabs-bordered">
                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                </li>
              </ul>
              <div class="tab-content pt-2">
                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                  <div class="row mt-3">
                    <div class="col-lg-3 col-md-4 label ">Profile Image</div>
                    <div class="col-lg-9 col-md-8">
                      @if($data->profile_image)
                          <img src="{{ asset($data->profile_image) }}" width="100" alt="Profile Image">
                      @else
                          No Image Uploaded
                      @endif
                    </div>
                  </div>
                  <div class="row mt-3">
                    <div class="col-lg-3 col-md-4 label ">Name</div>
                    <div class="col-lg-9 col-md-8">{{$data->name}}</div>
                  </div>
                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Mobile</div>
                    <div class="col-lg-9 col-md-8">{{$data->phone}}</div>
                  </div>
                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Email</div>
                    <div class="col-lg-9 col-md-8">{{$data->email ?? '-'}}</div>
                  </div>
                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">District</div>
                    <div class="col-lg-9 col-md-8">{{@$data->districtData->title ?? '-'}}</div>
                  </div>
                 
                </div>
              </div><!-- End Bordered Tabs -->
            </div>
          </div>
        </div>
      </div>
    </section>
@endsection
@section('script')
@endsection
