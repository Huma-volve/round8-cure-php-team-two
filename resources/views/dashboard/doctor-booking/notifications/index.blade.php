@extends('layouts.admin.app')

@section('content')
    <div class="container">
        <h4 class="mb-4">All Notifications</h4>
        <div class="d-flex justify-content-between align-items-center mb-4">
            @if (session('success') || session('error'))
                <div id="flash-alert"
                    class="alert alert-{{ session('success') ? 'success' : 'danger' }} alert-dismissible fade show"
                    role="alert">

                    {{ session('success') ?? session('error') }}

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>

                <script>
                    setTimeout(() => {
                        const alert = document.getElementById('flash-alert');
                        if (alert) alert.classList.remove('show');
                    }, 3000);
                </script>
            @endif


            <div class="d-flex gap-2">
                <!-- Mark All As Read -->
                <form action="{{ route('doctor.notifications.markAllAsRead') }}" method="POST">
                    @csrf
                    <button class="btn btn-sm btn-outline-success">
                        Mark all as read
                    </button>
                </form>

                <!-- Delete All -->
                <form action="{{ route('doctor.notifications.destroyAll') }}" method="POST"
                    onsubmit="return confirm('Are you sure?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger">
                        Delete all
                    </button>
                </form>
            </div>
        </div>
        @forelse ($notifications as $notification)
            <div class="card mb-2 {{ $notification->read_at ? '' : 'border-primary' }}">
                <div class="card-body">
                    <h6 class="mb-1">
                        {{ $notification->data['title'] ?? 'Notification' }}
                    </h6>

                    <p class="mb-1 text-muted">
                        {{ $notification->data['message'] ?? '' }}
                    </p>

                    <small class="text-muted">
                        {{ $notification->created_at->diffForHumans() }}
                    </small>
                </div>
                <div class="d-flex gap-2">
                    <!-- Mark as Read -->
                    @if (!$notification->read_at)
                        <form action="{{ route('doctor.notifications.markAsRead', $notification->id) }}" method="POST">
                            @csrf
                            <button class="btn btn-sm btn-outline-primary">
                                Mark read
                            </button>
                        </form>
                    @endif

                    <!-- Delete -->
                    <form action="{{ route('doctor.notifications.destroy', $notification->id) }}" method="POST"
                        onsubmit="return confirm('Delete this notification?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="alert alert-info text-center">
                No notifications found
            </div>
        @endforelse

        <div class="mt-3">
           {{ $notifications->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
