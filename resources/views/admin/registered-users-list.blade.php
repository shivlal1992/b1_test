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
              <h5 class="card-title">Registered Users
              </h5>

               <div class="table-responsive">
                <table class="table ">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Name</th>
                      <th scope="col">Email</th>
                      <th scope="col">Mobile</th>
                      <th scope="col">District</th>
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
                      <td>{{$item->district ?? '-'}}</td>
                      <td>
                        <a class="btn btn-sm btn-primary" href="{{route('user-edit',$item->id)}}">Edit</a>
                        <a class="btn btn-sm btn-danger" href="{{route('user-delete',$item->id)}}">Delete</a>
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
    