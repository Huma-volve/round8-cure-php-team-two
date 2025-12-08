<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/pusher-test', function () {

//     try {
//         $pusher = new \Pusher\Pusher(
//             env('PUSHER_APP_KEY'),
//             env('PUSHER_APP_SECRET'),
//             env('PUSHER_APP_ID'),
//             [
//                 'cluster' => env('PUSHER_APP_CLUSTER'),
//                 'useTLS' => true
//             ]
//         );

//         $response = $pusher->trigger('test-channel', 'test-event', ['message' => 'Hello']);

//         return [
//             'status' => $response ? 'success' : 'failed',
//             'response' => $response
//         ];

//     } catch (\Exception $e) {
//         return [
//             'status' => 'error',
//             'error' => $e->getMessage()
//         ];
//     }
// });


