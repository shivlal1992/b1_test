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
              <h5 class="card-title">New Exam
              <button onclick="history.back()" class="btn btn-sm btn-secondary" style="float:right;" >Go Back</button>
              </h5>

              <!-- General Form Elements -->
              <form class="row g-3 mt-2" method="POST" action="{{route('exam-create')}}" enctype="multipart/form-data">
                @csrf()
                <div class="col-6">
                  <label for="yourUsername" class="form-label">Title</label>
                  <div class="input-group has-validation">
                  <input type="text" name="title" class="form-control" value="B1 Test" required>
                  </div>
                </div>

                <div class="col-6">
                  <label for="yourUsername" class="form-label">Date</label>
                  <div class="input-group has-validation">
                  <input type="date" name="date" class="form-control" value="" required>
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
