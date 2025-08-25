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
          <h5 class="card-title">Exam Centers
             @if(auth()->user()->hasAnyRole(['Super Admin']))
            <a href="{{route('exam-center-create')}}" class="btn btn-sm btn-primary " style="float:right;">Add</a>
            @endif
          </h5>

           <div class="table-responsive">
            <table class="table ">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Location</th>
                  <th scope="col">Latitude</th>
                  <th scope="col">Longitude</th>
                  <th scope="col">District</th>
                  <th scope="col">Seat Capacity</th>
                  <th scope="col">Slot</th>
                  <th scope="col">Start Time</th>
                  <th scope="col">End Time</th>
                  <th scope="col">CreatedBy</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($data as $key => $item)
                <tr>
                  <th scope="row">{{$key+1}}</th>
                  <td>{{$item->location ?? '-'}}</td>
                  <td>{{$item->lat ?? '-'}} </td>
                  <td>{{$item->long ?? '-'}}</td>
                  <td>{{@$item->districtData->title ?? '-'}}</td>
                  <td>{{$item->capacity_seat ?? '-'}}</td>
                  <td>{{$item->slot ?? '-'}}</td>
                  <td>{{$item->start_time ?? '-'}}</td>
                  <td>{{$item->end_time ?? '-'}}</td>
                  <td>{{@$item->createdByData->name ?? '-'}}</td>
                  <td>
                     @if(auth()->user()->hasAnyRole(['Super Admin']))
                    <a class="btn btn-sm btn-primary" href="{{route('exam-center-edit',$item->id)}}">Edit</a>
                    <a class="btn btn-sm btn-danger" href="{{route('exam-center-delete',$item->id)}}">Delete</a>
                    @endif
                    <a class="btn btn-sm btn-success" href="{{route('exam-center-view',$item->id)}}">View</a>
                  </td>
                </tr>
                @endforeach
              </tbody>
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
