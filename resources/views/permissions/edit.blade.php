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

              <h5 class="card-title">Permission Edit
              </h5>

                

                <form method="POST" action="{{ route('permissions.update', $permission->id) }}">

                @csrf

                @method('PUT')



                <div class="mb-3">

                    <label for="name" class="form-label">Permission Name</label>

                    <input type="text" name="name" class="form-control" value="{{ $permission->name }}" required>

                </div>



                <button type="submit" class="btn btn-primary">Update Permission</button>

                <a href="{{ route('permissions.index') }}" class="btn btn-secondary">Cancel</a>

                </form>
            </div>
          </div>
        </div>
      </div>
    </section>

@endsection
@section('script')
@endsection
