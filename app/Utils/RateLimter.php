<?php

namespace App\Utils;

use Illuminate\Support\Facades\RateLimiter;

class RateLimter
{
    protected static function checkRateLimit($request, $max)
    {

        if(RateLimiter::tooManyAttempts($request, $max))
        {
            $time = RateLimiter::availableIn($request);
            return apiResponse(429,'Too Many Attempts. Please try again in '.$time.' seconds.');
        }

        RateLimiter::increment($request);
        $remaining = RateLimiter::remaining($request, $max);

        return apiResponse(401 , 'Too Many Attempts.',['remaining' => $remaining]);
        
    }

}