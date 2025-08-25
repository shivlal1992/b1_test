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
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Edit Role - {{ $role->name }}</h5>
                    <form method="POST" action="{{ route('roles.update', $role->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label">Role Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $role->name }}" required>
                        </div>
                       
                        <button type="submit" class="btn btn-primary mt-3">Update Role</button>
                        <a href="{{ route('roles.index') }}" class="btn btn-secondary mt-3">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
      </div>
    </section>
@endsection
@section('script')
@endsection
