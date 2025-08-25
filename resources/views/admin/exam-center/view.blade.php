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
              <h5 class="card-title">Exam Center Information
                <button onclick="history.back()" class="btn btn-sm btn-secondary" style="float:right;" >Go Back</button>
              </h5>
               <div class="table-responsive">
                    <table class="table table-bordered">
                    <tr><th>Location</th><td>{{ $data->location }}</td></tr>
                    <tr><th>Latitude</th><td>{{ $data->lat }}</td></tr>
                    <tr><th>Longitude</th><td>{{ $data->long }}</td></tr>
                    <tr>
                      <th>District</th>
                      <td>{{@$data->districtData->title ?? '-'}}</td>
                    </tr>
                    <tr><th>Seat Capacity</th><td>{{ $data->capacity_seat }}</td></tr>
                    <tr><th>Slot</th><td>{{ $data->slot }}</td></tr>
                   <tr><th>Start Time</th><td>{{ $data->start_time }}</td></tr>
                  <tr><th>End Time</th><td>{{ $data->end_time }}</td></tr>

                    <tr><th>Facilities</th><td>{{ $data->facilities }}</td></tr>
                    <tr><th>Logistics</th><td>{{ $data->logistics }}</td></tr>
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
