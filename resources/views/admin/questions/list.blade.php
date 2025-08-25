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
              <h5 class="card-title">Filter
              </h5>
              <form class="row g-3"  method="GET" >
                <div class="col-4">
                  <label for="yourUsername" class="form-label">Question</label>
                  <div class="input-group has-validation">
                    <input type="text" name="question" value="{{@$_GET['question']}}" class="form-control" placeholder="Enter Question">
                  </div>
                </div>
                <div class="col-4">
                  <label for="yourUsername" class="form-label">Subject</label>
                  <div class="input-group has-validation">
                    <select name="subject_id" id="" class="form-control" >
                      <option value="">Select Option</option>
                      @foreach($test_subjects as $item)
                      <option value="{{$item->id}}" @if(@$_GET['subject_id'] == $item->id) selected @endif>{{$item->title}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-4">
                  <label for="yourUsername" class="form-label">Difficulty Level</label>
                  <div class="input-group has-validation">
                    <select name="difficulty_level" id="" class="form-control" >
                      <option value="">Select Option</option>
                      <option value="easy" @if(@$_GET['difficulty_level'] == "easy") selected @endif>Easy</option>
                      <option value="medium" @if(@$_GET['difficulty_level'] == "medium") selected @endif>Medium</option>
                      <option value="hard" @if(@$_GET['difficulty_level'] == "hard") selected @endif>Hard</option>
                    </select>
                  </div>
                </div>

                <div class=" mb-3">
                  <div class="col-sm-10">
                    <button type="submit" class="btn btn-sm btn-primary"><i class="bi bi-search"></i> Search</button>
                    <a href="{{route('questions')}}" class="btn btn-sm btn-danger"  >Reset</a>
                  </div>
                </div>
              </form>
               
            </div>
          </div>
        </div>


        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Questions
                <a href="{{route('question-create')}}" class="btn btn-sm btn-primary " style="float:right;">Add</a>
              </h5>

               <div class="table-responsive">
                <table class="table ">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Question ID</th>
                      <th scope="col">Subject</th>
                      <th scope="col">Question</th>
                      <th scope="col">Option A</th>
                      <th scope="col">Option B</th>
                      <th scope="col">Option C</th>
                      <th scope="col">Option D</th>
                      <th scope="col">Answer</th>
                      <th scope="col">Difficulty Level</th>
                      <th scope="col">Action</th>

                    </tr>
                  </thead>
                  <tbody>
                    @foreach($data as $key => $item)
                    
                    <tr>
                      <th scope="row">{{$key+1}}</th>
                      <td>{{$item->id ?? '-'}}</td>
                      <td>{{\Illuminate\Support\Str::limit(@$item->subjectData->title, 30)  ?? '-'}} </td>
                      <td>{{\Illuminate\Support\Str::limit(@$item->title, 30, '...')  ?? '-'}} </td>
                      <td>{{\Illuminate\Support\Str::limit(@$item->opt_a, 20, '...')  ?? '-'}}</td>
                      <td>{{\Illuminate\Support\Str::limit(@$item->opt_b, 20, '...')  ?? '-'}}</td>
                      <td>{{\Illuminate\Support\Str::limit(@$item->opt_c, 20, '...')  ?? '-'}}</td>
                      <td>{{\Illuminate\Support\Str::limit(@$item->opt_d, 20, '...')  ?? '-'}}</td>
                      <td>Option {{strtoupper(\Illuminate\Support\Str::after($item->answer, 'opt_')) ?? '-'}}</td>
                      <td>{{ucfirst($item->difficulty_level) ?? '-'}}</td>
                      <td>
                        <div class="d-flex flex-wrap gap-1">
                          <!-- <a class="btn btn-sm btn-outline-primary" href="{{ route('question-edit', $item->id) }}">
                            <i class="bi bi-pencil-square"></i>
                          </a>
                          
                          <a class="btn btn-sm btn-outline-danger" href="{{ route('question-delete', $item->id) }}">
                            <i class="bi bi-trash"></i>
                          </a> -->
                          <a class="btn btn-sm btn-outline-success" href="{{ route('question-view', $item->id) }}">
                            <i class="bi bi-eye-fill"></i>
                          </a>
                        </div>
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
