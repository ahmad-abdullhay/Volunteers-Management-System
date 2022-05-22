<?php

namespace App\Http\Controllers;


use App\Common\SharedMessage;
use App\Http\Requests\MainRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    /**
     * Handle manager messages.
     * @param SharedMessage $message
     * @return JsonResponse
     */
    protected function handleSharedMessage(SharedMessage $message): JsonResponse
    {
        // Check on message status.
        if ($message->status){
            // Return success response.
            return $this->success(
                $message->message,
                $message->data,
                $message->statusCode ?? JsonResponse::HTTP_OK
            );
        }
        // Handle error of this message.
        return $this->error(
            [$message->message],
            $message->statusCode ?? JsonResponse::HTTP_BAD_REQUEST
        );
    }

    /**
     * Send any success response
     *
     * @param string $message
     * @param array|object $data
     * @param integer $statusCode
     * @return JsonResponse
     */
    public function success(string $message, $data, int $statusCode = 200): JsonResponse
    {
        return $this->coreResponse($message, $data, $statusCode, [],  true);
    }

    /**
     * Send any error response
     *
     * @param array $messages
     * @param integer $statusCode
     * @return JsonResponse
     */
    public function error(array $messages, int $statusCode = 500): JsonResponse
    {
        return $this->coreResponse("", null, $statusCode , $messages, false);
    }

    /**
     * Core of response
     *
     * @param string $message
     * @param mixed $data
     * @param integer $statusCode
     * @param boolean $isSuccess
     * @param array $errors
     * @return JsonResponse
     */
    public function coreResponse(string $message, $data, int $statusCode, array $errors, bool $isSuccess = true): JsonResponse
    {
        // Check the params
        if (!$message && !$errors) return response()->json(['message' => 'Message is required'], 500);

        // Send the response
        if ($isSuccess)
            return response()->json([
                'message' => $message,
                'status' => true,
                'data' => $data,
                'status_code' => $statusCode
            ]);

        return response()->json([
            'message' => $message,
            'status' => false,
            'data' => null,
            'errors' => $errors,
            'status_code' => $statusCode
        ]);
    }
}
