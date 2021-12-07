<?php

declare(strict_types=1);


namespace App\Http\Requests\Api;

use Illuminate\Http\Request;


class ApiRequest
{
    public static function articleRequestUpdate(Request $request)
    {
        $data = [];
        $request_data = [];

        if ($request->get('title')) {
            $request_data['title'] = $request->get('title');
        }

        if ($request->get('content')) {
            $request_data['content'] = $request->get('content');
        }

        if ($request->get('tags')) {
            if (is_array($request->get('tags'))) {
                $request_data['tags'] = $request->get('tags');

                if (!$request->get('method') || $request->get('method') === '') {
                    $res_data = [
                        'message' => 'Parameter method is required',
                        'status_code' => 422
                    ];
                    $data = ApiErrorResponse::getResponse($res_data);
                } else {
                    if (!in_array($request->get('method'), ['add', 'update'])) {
                        $res_data = [
                            'message' => 'Parameter method is required',
                            'status_code' => 422
                        ];
                        $data = ApiErrorResponse::getResponse($res_data);
                    } else {
                        $request_data['method'] = $request->get('method');
                        $res_data = [
                            'message' => 'successfully set parameters',
                            'data' => $request_data
                        ];
                        $data = ApiSuccessResponse::getResponse($res_data);
                    }
                }
            } else {
                $res_data = [
                    'message' => 'Parameter tag must be array',
                    'status_code' => 422
                ];
                $data = ApiErrorResponse::getResponse($res_data);
            }
        }

        return $data;
    }

    private static function responseValidationData($data)
    {
        $status = $data['status'] ?? 200;
    }


}
