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
              <h5 class="card-title">Update Exam Center</h5>

              <!-- General Form Elements -->
              <form class="row g-3 "  method="POST" action="{{route('exam-center-update')}}" enctype="multipart/form-data">
                @csrf()
               <input type="hidden" name="id" value="{{$data->id}}">
                <div class="col-6">
                  <label for="yourUsername" class="form-label">District</label>
                  <div class="input-group has-validation">
                   <select name="district_id" id="" class="form-control" required>
                      <option value="">Select Option</option>
                      @foreach($districts as $item)
                      <option value="{{$item->id}}" @if($item->id == $data->district_id) selected @endif>{{$item->title}}</option>
                      @endforeach  
                    </select>
                  </div>
				  
                </div>
               <div class="col-12">
                  <label for="yourUsername" class="form-label">Location</label>
                  <div class="input-group has-validation">
                    <textarea name="location" class="form-control" rows="2" cols="10" id="" placeholder="Enter Location" value="{{$data->location}}" required>{{$data->location}}</textarea>
                  </div>
                </div>

                
                <div class="col-4">
                  <label for="yourUsername" class="form-label">Latitude</label>
                  <div class="input-group has-validation">
                    <input type="text" name="lat" class="form-control" value="{{$data->lat}}" required>
                  </div>
                </div>


               
                
                <div class="col-4">
                  <label for="yourUsername" class="form-label">Longitude</label>
                  <div class="input-group has-validation">
                    <input type="text" name="long" class="form-control" value="{{$data->long}}"  required>
                  </div>
                </div>
                <div class="col-4">
                  <label for="yourUsername" class="form-label">Seat Capacity</label>
                  <div class="input-group has-validation">
                    <input type="number" name="capacity_seat" class="form-control"  value="{{$data->capacity_seat}}" required>
                  </div>
                </div>

                 <div class="col-4">
  <label class="form-label">Slot</label>
  <input type="text" name="slot" class="form-control" 
         value="{{ $data->slot }}" placeholder="e.g. Morning / Slot 1">
</div>

<div class="col-4">
  <label class="form-label">Start Time</label>
  <input type="time" name="start_time" class="form-control" 
         value="{{ $data->start_time }}">
</div>

<div class="col-4">
  <label class="form-label">End Time</label>
  <input type="time" name="end_time" class="form-control" 
         value="{{ $data->end_time }}">
</div>



                <div class="col-12">
                  <label for="yourUsername" class="form-label">Facilities</label>
                  <div class="input-group has-validation">
                    <textarea name="facilities" class="form-control" rows="5" cols="5" id="" placeholder="Enter Facilities" value="{{$data->facilities}}" required>{{$data->facilities}}</textarea>
                  </div>
                </div>

                
                <div class="col-12">
                  <label for="yourUsername" class="form-label">Other Logistics</label>
                  <div class="input-group has-validation">
                  <textarea name="logistics" class="form-control" rows="5" cols="5" id="" placeholder="Enter Other Logistics" value="{{$data->logistics}}" required>{{$data->logistics}}</textarea>
                  </div>
                </div>
               
               
                <div class=" mb-3">
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
