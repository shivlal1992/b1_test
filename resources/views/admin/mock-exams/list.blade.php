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
          <h5 class="card-title">Mock Test
            @if(auth()->user()->hasAnyRole(['Super Admin']))
              <a href="{{route('mock-test-create')}}" class="btn btn-sm btn-primary " style="float:right;">Add</a>
            @endif
          </h5>

          <div class="table-responsive">
            <table class="table ">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Title</th>
                  <th scope="col">Date</th>
                  <th scope="col">Exam Link</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($data as $key => $item)
                <tr>
                  <th scope="row">{{$key+1}}</th>
                  <td>{{$item->title ?? '-'}}</td>
                  <td>{{$item->date ?? '-'}}</td>
                  <td>{{url('practice-mock-test',$item->id)}}</td>
                  <td>
                    @if(auth()->user()->hasAnyRole(['Super Admin']))
                      <a class="btn btn-sm btn-primary" href="{{route('mock-test-edit',$item->id)}}">Edit</a>
                      <a class="btn btn-sm btn-danger" href="{{route('mock-test-delete',$item->id)}}">Delete</a>
                    @endif

                    @if(auth()->user()->hasAnyRole(['Super Admin','Registrar']))
                      <a class="btn btn-sm btn-success" href="{{route('mock-test-candidates',$item->id)}}">Candidate(s)</a>
                      <a class="btn btn-sm btn-info" href="{{route('mock-test-merit',$item->id)}}">Merit</a>
                    @endif
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
