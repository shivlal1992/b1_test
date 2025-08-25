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
              <h5 class="card-title">Edit Suprintendent</h5>
              <!-- General Form Elements -->
              <form  method="POST" action="{{route('suprintendent-update')}}" enctype="multipart/form-data">
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
                    <input type="password" name="password" class="form-control"  pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$" title="Password must be at least 8 characters, with upper and lowercase letters, a number, and a special character">
                  </div>
                </div>
               
                
                <div class="row mb-3">
                  <label for="inputEmail" class="col-sm-2 col-form-label">District</label>
                  <div class="col-sm-10">
                    <select name="district_id" id="" class="form-control" required>
                      @foreach($districts as $item)
                      <option value="{{$item->id}}" @if($user->district_id == $item->id) selected @endif>{{$item->title}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputEmail" class="col-sm-2 col-form-label">Exam Centers</label>
                  <div class="col-sm-10">
                    <select name="exam_center_id" id="" class="form-control" required>
                      @foreach($exam_centers as $item)
                      <option value="{{$item->id}}" @if($user->exam_center_id == $item->id) selected @endif>{{$item->location}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>


                <div class="row mb-3">
                  <label for="inputEmail" class="col-sm-2 col-form-label">Status</label>
                  <div class="col-sm-10">
                    <select name="status" id="" class="form-control" >
                      <option value="1" @if($user->status == '1') selected @endif>Active</option>
                      <option value="0" @if($user->status == '0') selected @endif>Inactive</option>
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
