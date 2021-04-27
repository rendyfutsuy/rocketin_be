<?php

namespace App\Http\Controllers\CustomAuth;

trait AuthResponses
{
    /**
     * Return response message.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function getResponses(array $data, int $httpCode = 200)
    {
        return response()->json($data, $httpCode);
    }

    /**
     * Return response message.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function responseMessage(string $status, string $message, int $code)
    {
        return $this->getResponses([
            'status' => $status,
            'message' => $message,
        ], $code);
    }

    /**
     * Return response with token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseWithToken(string $status, string $message, string $token, int $code)
    {
        return $this->getResponses([
            'user_id' => auth('api')->id(),
            'status' => $status,
            'message' => $message,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL()
        ], $code);
    }
}
