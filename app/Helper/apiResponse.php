<?php

if (!function_exists('apiResponse')) {

    function apiResponse($status, $massage, $data = null)
    {
        $result = [
            'status' => $status,
            'massage' => $massage
        ];
        if ($data) {
            $result['data'] = $data;
        }
        return response()->json($result, $status);
    }

}
