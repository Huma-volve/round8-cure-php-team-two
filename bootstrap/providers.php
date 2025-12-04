<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\TelescopeServiceProvider::class,
    App\Modules\Home\Providers\HomeServiceProvider::class,
    App\Modules\Favorites\Providers\FavoriteServiceProvider::class,
    App\Modules\Search\Providers\SearchServiceProvider::class,
    App\Modules\Stripe\Providers\StripeServiceProvider::class,
    App\Modules\Booking\Providers\BookingServiceProvider::class,
];
