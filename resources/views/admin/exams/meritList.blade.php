
@extends('admin.layouts.main')
@section('style')
@endsection
@section('content')

@section('content')
<div class="container">
    <h3 class="mb-4">🏆 Merit List - {{ $exam->title }}</h3>

    <div class="card shadow-lg">
        <div class="card-body">
            <table class="table table-hover table-striped text-center align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Rank</th>
                        <th>Candidate</th>
                        <th>Email</th>
                        <th>Score</th>
                        <th>Time Taken (mins)</th>
                        <th>Submitted At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($results as $result)
                        <tr>
                            <td><span class="badge bg-primary fs-6">{{ $result->rank }}</span></td>
                            <td>{{ $result->name }}</td>
                            <td>{{ $result->email }}</td>
                            <td><strong class="text-success">{{ $result->score }}</strong></td>
                            <td>{{ $result->time_taken }}</td>
                            <td>{{ \Carbon\Carbon::parse($result->submitted_at)->format('d M Y, h:i A') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-muted">No results available</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
