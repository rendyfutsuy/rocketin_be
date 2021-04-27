<?php

namespace Modules\Media\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class ProviderException extends \Exception
{
    /**
     * Report the exception.
     *
     * @return void
     */
    public function report()
    {
        //
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function render()
    {
        return response()->json([
            'error_code' => $this->getCode(),
            'message' => $this->getMessage(),
        ], Response::HTTP_NOT_ACCEPTABLE);
    }
}
