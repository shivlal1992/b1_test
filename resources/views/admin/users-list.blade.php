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
              <h5 class="card-title">District-Level Admins
                <a href="{{route('user-create')}}" class="btn btn-sm btn-primary " style="float:right;">Add</a>
              </h5>
               <div class="table-responsive">
                <table class="table ">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Name</th>
                      <th scope="col">Email</th>
                      <th scope="col">Mobile</th>
                      <th scope="col">Password</th>
                      <th scope="col">District</th>
                      <th scope="col">Status</th>
                      <th scope="col">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($data as $key => $item)
                    <tr>
                      <th scope="row">{{$key+1}}</th>
                      <td>{{$item->name ?? '-'}}</td>
                      <td>{{$item->email ?? '-'}}</td>
                      <td>{{$item->phone ?? '-'}}</td>
                      <td>{{$item->password_text ?? '-'}}</td>
                      <td>{{@$item->districtData->title ?? '-'}}</td>
                      <td>{{$item->status == '1' ? "Active" : 'Inactive'}}</td>
                      <td>
                        <a class="btn btn-sm btn-primary" href="{{route('user-edit',$item->id)}}">Edit</a>
                        <a class="btn btn-sm btn-danger" href="{{route('user-delete',$item->id)}}">Delete</a>
                        <!-- <a target="_blank" class="btn btn-sm btn-success" href="{{url('users/'.$item->id.'/permissions')}}">Assign Permissions</a> -->
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
