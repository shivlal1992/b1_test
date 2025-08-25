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
              <h5 class="card-title">Question Information
                <button onclick="history.back()" class="btn btn-sm btn-secondary" style="float:right;" >Go Back</button>
              </h5>
               <div class="table-responsive">
                    <table class="table table-bordered">
                    <tr><th>Question ID</th><td>{{$data->id ?? '-'}}</td></tr>
                    <tr><th>Subject</th><td>{{$data->subjectData->title ?? '-'}}</td></tr>
                    <tr><th>Question</th><td>{{$data->title ?? '-'}}</td></tr>
                    <tr><th>Option A</th><td>{{$data->opt_a ?? '-'}}</td></tr>
                    <tr><th>Option B</th><td>{{$data->opt_b ?? '-'}}</td></tr>
                    <tr><th>Option C</th><td>{{$data->opt_c ?? '-'}}</td></tr>
                    <tr><th>Option D</th><td>{{$data->opt_d ?? '-'}}</td></tr>
                    <tr><th>Answer</th><td>Option {{strtoupper(\Illuminate\Support\Str::after($data->answer, 'opt_')) ?? '-'}}</td></tr>
                    <tr><th>Difficulty Level</th><td>{{ucfirst($data->difficulty_level) ?? '-'}}</td></tr>
                  
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
