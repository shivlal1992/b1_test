@extends('admin.layouts.main')
@section('style')
@endsection
@section('content')

<div class="pagetitle">
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
                  <th scope="col">Candidate Profile</th>
                  <th scope="col">Candidate Signature</th>
                  <th scope="col">Candidate Name</th>
                  <th scope="col">Center</th>
                  <th scope="col">Center District</th>
                  <th scope="col">Slot</th>
                  <th scope="col">Exam Time</th>
                  <th scope="col">Total Questions</th>
                  <th scope="col">Que. Attempted</th>
                  <th scope="col">Que. Answered</th>
                  <th scope="col">Que. Unattempted</th>
                  <th scope="col">Exam Score</th>
                  <th scope="col">Attendance</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($data as $key => $item)
                <tr>
                  <th scope="row">{{$key+1}}</th>

                  {{-- Candidate Profile --}}
                  <td>
                    @if(!empty($item->userData) && !empty($item->userData->profile_image))
                      <a target="_blank" href="{{ asset($item->userData->profile_image) }}">
                        <img src="{{ asset($item->userData->profile_image) }}" width="50" height="50" alt="">
                      </a>
                    @else
                      <span class="badge bg-secondary">No Image</span>
                    @endif
                  </td>

                  {{-- Candidate Signature --}}
                  <td>
                    @if(!empty($item->userData) && !empty($item->userData->user_sign))
                      <a target="_blank" href="{{ asset($item->userData->user_sign) }}">
                        <img src="{{ asset($item->userData->user_sign) }}" width="50" height="50" alt="">
                      </a>
                    @else
                      <span class="badge bg-secondary">No Sign</span>
                    @endif
                  </td>

                  {{-- Candidate Name --}}
                  <td>
                    @if(!empty($item->userData))
                      @php
                        $fullName = trim(($item->userData->first_name ?? '') . ' ' . ($item->userData->middle_name ?? '') . ' ' . ($item->userData->last_name ?? ''));
                      @endphp
                      {{ $fullName ?: ($item->userData->name ?? '-') }}
                    @else
                      -
                    @endif
                  </td>

                  <td>{{@$item->examCenterData->location ?? '-'}}</td>
                  <td>{{@$item->examCenterData->districtData->title ?? '-'}}</td>
                  <td>{{@$item->slot ?? '-'}}</td>
                  <td>
    @if(!empty($item->start_time) && !empty($item->end_time))
        {{ \Carbon\Carbon::parse($item->start_time)->format('g:i A') }}
        to
        {{ \Carbon\Carbon::parse($item->end_time)->format('g:i A') }}
    @else
        -
    @endif
</td>

                  <td>{{@$item->examResultData->total_question ?? '-'}}</td>
                  <td>{{@$item->examResultData->attempted ?? '-'}}</td>
                  <td>{{@$item->examResultData->answered ?? '-'}}</td>
                  <td>{{@$item->examResultData->unanswered ?? '-'}}</td>
                  <td>{{@$item->examResultData->score ?? '-'}} ({{@$item->examResultData->percentage}}%)</td>
                  <td>
                    <a class="btn btn-sm btn-secondary" href="#" data-bs-toggle="dropdown">{{ucfirst(str_replace("_"," ",$item->attendance))}}</a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                      <li class="dropdown-header text-start">
                        <h6>Mark As</h6>
                      </li>
                      <li><a class="dropdown-item" href="{{ url('attendance-marking') }}/{{$item->user_id}}/{{$item->exam_id}}/available">Available</a></li>
                      <li><a class="dropdown-item" href="{{ url('attendance-marking') }}/{{$item->user_id}}/{{$item->exam_id}}/not_available">Not Available</a></li>
                    </ul>
                  </td>
                  <td>
                    @if(!empty($item->admitcard_url))
                        <a href="{{ route('download.admit', ['filename' => basename($item->admitcard_url)]) }}" class="btn btn-primary">
                            Download Admit Card
                        </a>
                    @else
                        <span class="badge bg-warning">Not Generated</span>
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
