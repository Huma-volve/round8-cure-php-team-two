<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('doctor.dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('doctor.dashboard')" :active="request()->routeIs('doctor.dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('doctor.appointments')" :active="request()->routeIs('admin.doctor.index')">
                        {{ __('My appointments') }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('doctor.profile')" :active="request()->routeIs('admin.doctor.index')">
                        {{ __('My profile') }}
                    </x-nav-link>
                </div>
            </div>
            <a class="nav-link position-relative" href="javascript:void(0)" id="drop2" aria-expanded="false">
                <i class="ti ti-bell-ringing"></i>
                <div class="notification bg-primary rounded-circle" id="notify-dot"></div>
            </a>

            <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">

                <div class="d-flex align-items-center justify-content-between py-3 px-7">
                    <h5 class="mb-0 fs-5 fw-semibold">Notifications</h5>
                    <span class="badge text-bg-primary rounded-4 px-3 py-1 lh-sm" id="notify-count">
                        0
                    </span>
                </div>

                <div class="message-body" data-simplebar id="notifications-list">
                    <!-- notifications will be injected here -->
                </div>

                <div class="py-6 px-7 mb-1">
                    <a href="/notifications" class="btn btn-outline-primary w-100">
                        See All Notifications
                    </a>
                </div>
            </div>


            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
<script src="https://js.pusher.com/8.0/pusher.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script> <!-- Laravel Echo -->

<script>
let loaded = false;
let notificationsList = document.getElementById('notifications-list');
let notifyCount = document.getElementById('notify-count');

// تحميل الإشعارات عند المرور على Dropdown
document.getElementById('drop2').addEventListener('mouseenter', function () {
    if (loaded) return;
    loaded = true;

    fetch("{{ route('doctor.notifications.index') }}")
        .then(res => res.json())
        .then(response => renderNotifications(response.data, response.count));
});

// دالة لعرض الإشعارات
function renderNotifications(notifications, count) {
    notifyCount.innerText = count;
    notificationsList.innerHTML = '';

    if (notifications.length === 0) {
        notificationsList.innerHTML = `<div class="text-center py-4 text-muted">No notifications</div>`;
        return;
    }

    notifications.forEach(notification => {
        notificationsList.innerHTML += `
          <div class="py-6 px-7 d-flex align-items-center dropdown-item ${notification.read_at ? 'text-muted' : 'text-dark'}">
            <span class="me-3">
              <i class="ti ti-info-circle text-primary fs-6"></i>
            </span>
            <div class="w-100">
              <h6 class="mb-1 fw-semibold lh-base">
                ${notification.data.title ?? 'Notification'}
              </h6>
              <span class="fs-2 d-block text-body-secondary">
                ${notification.data.message ?? ''}
              </span>
            </div>
          </div>
        `;
    });
}

// Laravel Echo + Pusher لتحديث الإشعارات في الوقت الحقيقي
Echo.private(`App.Models.User.${{{ auth()->id() }}}`)
    .notification((notification) => {
        let currentCount = parseInt(notifyCount.innerText);
        renderNotifications([notification, ...Array.from(notificationsList.children).map(item => ({
            id: item.dataset.id,
            data: {
                title: item.querySelector('h6').innerText,
                message: item.querySelector('span').innerText
            },
            read_at: null
        }))], currentCount + 1);
    });
</script>

