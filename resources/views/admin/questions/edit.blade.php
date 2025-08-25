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
              <h5 class="card-title">Update Question
              <button onclick="history.back()" class="btn btn-sm btn-secondary" style="float:right;" >Go Back</button>
              </h5>

              <!-- General Form Elements -->
              <form class="row g-3 mt-2"  method="POST" action="{{route('question-update')}}" enctype="multipart/form-data">
                @csrf()
               <input type="hidden" name="id" value="{{$data->id}}">
               <div class="col-6">
                  <label for="yourUsername" class="form-label">Subject</label>
                  <div class="input-group has-validation">
                    <select name="subject_id" id="" class="form-control" required>
                      <option value="">Select Option</option>
                      @foreach($test_subjects as $item)
                      <option value="{{$item->id}}" @if($data->subject_id == $item->id) selected @endif>{{$item->title}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                
                <div class="col-12">
                  <label for="yourUsername" class="form-label">Title</label>
                  <div class="input-group has-validation">
                  <textarea name="title" class="form-control"  value="{{$data->title}}" rows="5" cols="5" id="" placeholder="Enter Title" required>{{$data->title}}</textarea>
                  </div>
                </div>

                
                <div class="col-6">
                  <label for="yourUsername" class="form-label">Option A</label>
                  <div class="input-group has-validation">
                  <textarea name="opt_a" class="form-control"  value="{{$data->opt_a}}" rows="5" cols="5" id="" placeholder="Enter Option A" required>{{$data->opt_a}}</textarea>
                  </div>
                </div>
                <div class="col-6">
                  <label for="yourUsername" class="form-label">Option B</label>
                  <div class="input-group has-validation">
                  <textarea name="opt_b" class="form-control"  value="{{$data->opt_b}}" rows="5" cols="5" id="" placeholder="Enter Option B" required>{{$data->opt_b}}</textarea>
                  </div>
                </div>
                <div class="col-6">
                  <label for="yourUsername" class="form-label">Option C</label>
                  <div class="input-group has-validation">
                  <textarea name="opt_c" class="form-control"  value="{{$data->opt_c}}" rows="5" cols="5" id="" placeholder="Enter Option C" required>{{$data->opt_c}}</textarea>
                  </div>
                </div>
                <div class="col-6">
                  <label for="yourUsername" class="form-label">Option D</label>
                  <div class="input-group has-validation">
                  <textarea name="opt_d" class="form-control"  value="{{$data->opt_d}}" rows="5" cols="5" id="" placeholder="Enter Option D" required>{{$data->opt_d}}</textarea>
                  </div>
                </div>

                <div class="col-6">
                  <label for="yourUsername" class="form-label">Answer</label>
                  <div class="input-group has-validation">
                    <select name="answer" id="" class="form-control" required>
                      <option value="opt_a" @if($data->answer == "opt_a") selected @endif>Option A</option>
                      <option value="opt_b" @if($data->answer == "opt_b") selected @endif>Option B</option>
                      <option value="opt_c" @if($data->answer == "opt_c") selected @endif>Option C</option>
                      <option value="opt_d" @if($data->answer == "opt_d") selected @endif>Option D</option>
                     
                    </select>
                  </div>
                </div>
                <div class="col-6">
                  <label for="yourUsername" class="form-label">Difficulty Level</label>
                  <div class="input-group has-validation">
                    <select name="difficulty_level" id="" class="form-control" required>
                      <option value="easy"  @if($data->difficulty_level == "easy") selected @endif>Easy</option>
                      <option value="medium"  @if($data->difficulty_level == "medium") selected @endif>Medium</option>
                      <option value="hard"  @if($data->difficulty_level == "hard") selected @endif>Hard</option>
                     
                    </select>
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
