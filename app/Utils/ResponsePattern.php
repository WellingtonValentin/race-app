<?php

namespace App\Utils;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

class ResponsePattern
{
    /**
     * @param $errorMessage
     * @param int $statusCode
     * @return ResponseFactory|Response
     */
    public static function errorResponse($errorMessage, $statusCode = Response::HTTP_BAD_REQUEST)
    {
        return response(
            self::getErrorFormat($errorMessage),
            $statusCode
        );
    }

    /**
     * @param $errorMessage
     * @return array
     */
    private static function getErrorFormat($errorMessage): array
    {
        if (is_string($errorMessage))
            return ['error' => $errorMessage];

        return [
            'error' => [
                'data' => $errorMessage
            ]
        ];
    }
}
