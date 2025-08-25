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
              <h5 class="card-title">Edit Registrar</h5>

              <!-- General Form Elements -->
              <form  method="POST" action="{{route('registrar-update')}}" enctype="multipart/form-data">
                @csrf()
               <input type="hidden" name="id" value="{{$user->id}}">
                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Name</label>
                  <div class="col-sm-10">
                    <input type="text" name="name" class="form-control" value="{{$user->name}}" required>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                  <div class="col-sm-10">
                    <input type="email" name="email" class="form-control" value="{{$user->email}}"  disabled>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputEmail" class="col-sm-2 col-form-label">Mobile</label>
                  <div class="col-sm-10">
                    <input type="text" name="phone" pattern="\d{10}" minlength="10" maxlength="10" class="form-control" value="{{$user->phone}}"  disabled>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputEmail" class="col-sm-2 col-form-label">Password</label>
                  <div class="col-sm-10">
                    <input type="password" name="password" class="form-control" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$" title="Password must be at least 8 characters, with upper and lowercase letters, a number, and a special character">
                  </div>
                </div>

              
                <div class="row mb-3">
                  <label for="inputEmail" class="col-sm-2 col-form-label">Profile Image</label>
                  <div class="col-sm-10">
                    <input type="file" name="profile_image" class="form-control"  >
                    <br>
                    @if($user->profile_image)
                        <img src="{{ asset($user->profile_image) }}" width="50" height="50" alt="Profile Image">
                    @else
                        No Image Uploaded
                    @endif
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Education</label>
                  <div class="col-sm-10">
                    <input type="text" name="education" class="form-control" value="{{$user->education}}" required>
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
