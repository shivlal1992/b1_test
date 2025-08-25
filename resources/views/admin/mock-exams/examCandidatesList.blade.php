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
              <h5 class="card-title">Exam Candidate(s) 
                <button onclick="history.back()" class="btn btn-sm btn-secondary" style="float:right;" >Go Back</button>
              </h5>

               <div class="table-responsive">
                <table class="table ">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Profile</th>
                      <th scope="col">Signature</th>
                      <th scope="col">Name</th>
                      <th scope="col">Email</th>
                      <th scope="col">Phone</th>
                       <th scope="col">Total Questions</th>
                      <th scope="col">Que. Attempted</th>
                      <th scope="col">Que. Answered</th>
                      <th scope="col">Que. Unattempted</th>
                      <th scope="col">Exam Score</th>

                    </tr>
                  </thead>
                  <tbody>
                    @foreach($data as $key => $item)
                    @if($item->userData)
                    <tr>
                      <th scope="row">{{$key+1}}</th>
                      <td>
                        @if($item->userData)
                        <a target="_blank" href="{{asset($item->userData->profile_image)}}">
                          <img src="{{asset($item->userData->profile_image)}}" width="50" height="50" alt="">
                        </a>
                        @else
                        -
                        @endif
                      </td>
                      <td>
                         @if($item->userData)
                        <a target="_blank" href="{{asset($item->userData->user_sign)}}">
                          <img src="{{asset($item->userData->user_sign)}}" width="50" height="50" alt="">
                        </a>

                        @else
                        -
                        @endif
                      </td>
                      <td>{{@$item->userData->name ?? '-'}}</td>
                      <td>{{@$item->userData->email ?? '-'}}</td>
                      <td>{{@$item->userData->phone ?? '-'}}</td>
                      <td>{{@$item->total_question ?? '-'}}</td>
                        <td>{{@$item->attempted ?? '-'}}</td>
                        <td>{{@$item->answered ?? '-'}}</td>
                        <td>{{@$item->unanswered ?? '-'}}</td>
                        <td>{{@$item->score ?? '-'}} ({{@$item->percentage}}%)</td>
                     
                    </tr>
                    @endif
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
