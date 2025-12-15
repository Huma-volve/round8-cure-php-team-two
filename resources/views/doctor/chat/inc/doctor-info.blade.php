<div class="px-4 pt-9 pb-6">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div class="d-flex align-items-center">
            <div class="position-relative">
                <img src="{{ auth('doctor')->user()->image() }}" alt="user1" width="54" height="54"
                    class="rounded-circle" />
            </div>
            <div class="ms-3">
                <h6 class="fw-semibold mb-2">{{ auth('doctor')->user()->name }}</h6>
                <p class="mb-0 fs-2">{{ auth('doctor')->user()->email }}</p>
            </div>
        </div>

    </div>
    @include('doctor.chat.inc.search')
</div>
