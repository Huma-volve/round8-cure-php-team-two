<?php

if (!function_exists('apiResponse')) {

    /**
     * @param bool $status حالة العملية (true/false)
     * @param string $message رسالة للـ response
     * @param mixed|null $data البيانات المرجعة
     * @param int $httpCode كود الـ HTTP (default: 200)
     */
    function apiResponse(bool $status, string $message, $data = null, int $httpCode = 200)
    {
        $result = [
            'status' => $status,
            'message' => $message
        ];

        if ($data !== null) {
            $result['data'] = $data;
        }

        return response()->json($result, $httpCode);
    }
}
