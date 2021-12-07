<?php

declare(strict_types=1);


namespace App\Http\Requests\Api;

class ApiSuccessResponse
{
    public static function getResponse($data): array
    {
        return [
            'status' => 'success',
            'message' => $data['message'] ?? '',
            'data' => $data['data'] ?? [],
            'status_code' => $data['status_code'] ?? 200,
        ];
    }
}
