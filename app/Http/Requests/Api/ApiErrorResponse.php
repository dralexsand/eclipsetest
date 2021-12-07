<?php

declare(strict_types=1);


namespace App\Http\Requests\Api;

class ApiErrorResponse
{
    public static function getResponse($data): array
    {
        return [
            'status' => 'error',
            'message' => $data['message'] ?? '',
            'status_code' => $data['status_code'] ?? 200,
        ];
    }
}
