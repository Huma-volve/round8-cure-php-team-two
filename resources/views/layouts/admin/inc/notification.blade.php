<li class="nav-item dropdown" id="drop2">
    <a class="nav-link position-relative" href="#" data-bs-toggle="dropdown">
        <i class="ti ti-bell-ringing fs-5"></i>
        <a href="{{ route('doctor.notifications.all') }}" class="position-relative d-inline-block">
    <i class="ti ti-bell-ringing fs-5"></i>
    <span id="notify-count" class="badge bg-danger position-absolute top-0 end-0 translate-middle rounded-pill">
        0
    </span>
</a>

    </a>

    <div class="dropdown-menu dropdown-menu-end p-0" style="width:360px">
        <div class="d-flex justify-content-between align-items-center px-3 py-2 border-bottom">
            <h6 class="mb-0 fw-semibold">Notifications</h6>
        </div>
        <div id="notifications-list" class="list-group list-group-flush" style="max-height:350px;overflow:auto">
            <div class="text-center py-4 text-muted">Loading...</div>
        </div>
        <div class="p-2 border-top">
            <a href="{{ route('doctor.notifications.all') }}" class="btn btn-outline-primary w-100 btn-sm">
                See all notifications
            </a>
        </div>
    </div>

   
</li>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const notifyCount = document.getElementById('notify-count');
    const notificationsList = document.getElementById('notifications-list');
    const drop2 = document.getElementById('drop2');
    let loaded = false;

    function loadNotifications() {
        if (!notificationsList) return;

        fetch("{{ route('doctor.notifications.unread') }}", {
            headers: { 'Accept': 'application/json' }
        })
        .then(res => res.json()) // ✅ مهم جداً
        .then(res => {
            notifyCount.innerText = res.count ?? 0;
            renderDropdown(res.data ?? []);
        })
        .catch(() => {
            notificationsList.innerHTML =
                `<div class="text-center py-3 text-danger">Failed to load</div>`;
        });
    }

    function renderDropdown(notifications) {
        notificationsList.innerHTML = '';
        if (!notifications.length) {
            notificationsList.innerHTML =
                `<div class="text-center py-3 text-muted">No notifications</div>`;
            return;
        }
        notifications.forEach(n => {
            notificationsList.insertAdjacentHTML('beforeend', `
                <a href="#"
                   class="list-group-item list-group-item-action ${n.read_at ? '' : 'fw-semibold'}">
                    <div class="small text-muted">${n.created_at}</div>
                    <div>${n.data?.title ?? 'Notification'}</div>
                    <small class="text-muted">${n.data?.message ?? ''}</small>
                </a>
            `);
        });
    }

    // تحميل الإشعارات عند تحميل الصفحة
    loadNotifications();

    // تحميل الإشعارات عند hover أو فتح الـ dropdown
    if (drop2) {
        drop2.addEventListener('mouseenter', function() {
            if (!loaded) {
                loaded = true;
                loadNotifications();
            }
        });
        drop2.addEventListener('shown.bs.dropdown', function() {
            if (!loaded) {
                loaded = true;
                loadNotifications();
            }
        });
    }

    // الوقت الحقيقي باستخدام Laravel Echo
    if (typeof Echo !== 'undefined') {
        Echo.private(`App.Models.Doctor.{{ auth()->guard('doctor')->id() }}`)
            .notification((notification) => {
                notifyCount.innerText = parseInt(notifyCount.innerText || 0) + 1;
                if (notificationsList) {
                    notificationsList.insertAdjacentHTML('afterbegin', `
                        <a href="#"
                           class="list-group-item list-group-item-action fw-semibold">
                            <div class="small text-muted">Just now</div>
                            <div>${notification.data?.title ?? 'Notification'}</div>
                            <small class="text-muted">${notification.data?.message ?? ''}</small>
                        </a>
                    `);
                }
            });
    }
});
</script>
@endpush
