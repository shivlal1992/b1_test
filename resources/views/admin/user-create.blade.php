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
              <h5 class="card-title">New District Admin</h5>
              <!-- General Form Elements -->
              <form  method="POST" action="{{route('user-create')}}" enctype="multipart/form-data">
                @csrf()
                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Name</label>
                  <div class="col-sm-10">
                    <input type="text" name="name" class="form-control" value="" required>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                  <div class="col-sm-10">
                    <input type="email" name="email" class="form-control"  required>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputEmail" class="col-sm-2 col-form-label">Mobile</label>
                  <div class="col-sm-10">
                    <input type="text" name="phone" pattern="\d{10}" minlength="10" maxlength="10" class="form-control"  required>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputEmail" class="col-sm-2 col-form-label">Password</label>
                  <div class="col-sm-10">
                    <input type="password" name="password" class="form-control"  pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$" title="Password must be at least 8 characters, with upper and lowercase letters, a number, and a special character"  required>
                  </div>
                </div>
             
                <div class="row mb-3">
                  <label for="inputEmail" class="col-sm-2 col-form-label">District</label>
                  <div class="col-sm-10">
                    <select name="district_id" id="" class="form-control" required>
                      <option value="">Select Option</option>
                      @foreach($districts as $item)
                      <option value="{{$item->id}}">{{$item->title}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>


                <div class="row mb-3">
                  <label for="inputEmail" class="col-sm-2 col-form-label">Status</label>
                  <div class="col-sm-10">
                    <select name="status" id="" class="form-control" >
                      <option value="">Select Option</option>
                      <option value="1">Active</option>
                      <option value="0">Inactive</option>
                    </select>
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
