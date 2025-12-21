@extends('layouts.admin.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>My Available Times</h4>
        <a href="{{ route('doctor.times.create') }}" class="btn btn-primary">
            + Add Time
        </a>
    </div>

    @if($times->isEmpty())
        <div class="alert alert-warning">
            No times added yet.
        </div>
    @else
        <table class="table table-striped text-center">
            <thead class="table-dark">
                <tr>
                    <th>Date</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($times as $time)
                    <tr>
                        <td>{{ $time->date }}</td>
                        <td>{{ $time->start_time }}</td>
                        <td>{{ $time->end_time }}</td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">

                                {{-- Edit Button --}}
                                <a href="{{ route('doctor.times.edit', $time->id) }}" class="btn btn-primary btn-sm">
                                    Edit
                                </a>

                                {{-- Delete Button --}}
                                <form method="POST" action="{{ route('doctor.times.destroy', $time->id) }}"
                                    onsubmit="return confirm('Delete this time?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">
                                        Delete
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    @endif
@endsection