@extends('admin.layouts.main')
@section('style')
@endsection
@section('content')

@section('content')
<div class="container">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">
                <i class="bi bi-trophy-fill me-2"></i> Merit List - {{ $exam->title }}
            </h4>
            <span class="badge bg-light text-dark">{{ $results->count() }} Candidates</span>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center">🏆 Rank</th>
                            <th>Candidate</th>
                            <th>Email</th>
                            <th class="text-center">Score</th>
                            <th class="text-center">⏱ Time Taken</th>
                            <th class="text-center">📅 Submitted At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($results as $result)
                            <tr>
                                <td class="text-center fw-bold">
                                    <span class="badge bg-{{ $loop->iteration == 1 ? 'warning text-dark' : ($loop->iteration == 2 ? 'secondary' : ($loop->iteration == 3 ? 'info' : 'dark')) }}">
                                        {{ $loop->iteration }}
                                    </span>
                                </td>
                                <td>
                                    <i class="bi bi-person-circle me-2 text-primary"></i> {{ $result->name }}
                                </td>
                                <td>{{ $result->email }}</td>
                                <td class="text-center">
                                    <span class="badge bg-success">{{ $result->score }}</span>
                                </td>
                                <td class="text-center">{{ $result->time_taken }} mins</td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($result->submitted_at)->format('d M Y, h:i A') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No results available</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Bootstrap Icons --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection
