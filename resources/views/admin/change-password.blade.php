@extends('admin.layouts.main')
@section('style')
@endsection
@section('content')
<div class="pagetitle">
      <!-- <h1>My Profile</h1> -->
     
    </div>

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Change Password</h5>

              <form  method="POST" action="{{route('updateProfile')}}" enctype="multipart/form-data">
                @csrf()
                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">New Password</label>
                  <div class="col-sm-10">
                    <input type="text" name="password" class="form-control" required>
                  </div>
                </div>
              
               

                <div class="row mb-3">
                  <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </div>

              </form><!-- End General Form Elements -->


            </div>
          </div>

        </div>

       
      </div>
    </section>
@endsection
@section('script')
@endsection
