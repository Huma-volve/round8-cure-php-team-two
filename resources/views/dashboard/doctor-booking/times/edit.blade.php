@extends('layouts.admin.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Edit Time</h5>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('doctor.times.update', $time->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Date</label>
                    <input type="date" name="date" class="form-control" value="{{ $time->date }}" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">From</label>
                        <input type="time" name="start_time" class="form-control" value="{{ $time->start_time }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">To</label>
                        <input type="time" name="end_time" class="form-control" value="{{ $time->end_time }}" required>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('doctor.times.index') }}" class="btn btn-secondary">
                        Back
                    </a>
                    <button class="btn btn-primary">
                        Update Time
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection