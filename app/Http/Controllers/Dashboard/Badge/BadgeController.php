<?php

namespace App\Http\Controllers\Dashboard\Badge;

use App\Common\SharedMessage;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\CrudController;
use App\Http\Requests\Badge\AddBadgeUserRequest;
use App\Http\Requests\EventRequest;
use App\Services\BadgeService;
use App\Services\EventService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BadgeController extends BaseController
{
    private BadgeService $service;

    /**
     * Create a new instance form branch repository.
     * @constructor
     * @param BadgeService $service
//     * @param AddBadgeUserRequest $request
     */
    public function __construct(BadgeService $service)
    {
        $this->service = $service;

    }

    public function addBadgeUser(AddBadgeUserRequest $payload){
        return $this->handleSharedMessage($this->service->addBadgeToUser($payload->post()));
    }

    public function index(Request $request)
    {
        $filters = $request->query();

        return $this->handleSharedMessage(
            $this->service->index(
                ['*'],
                [],
                $request->per_page ?? 10,
                $request->sort_keys ?? ['id'],
                $request->sort_dir ?? ['desc'],
                $filters,
                $request->search ?? null
            )
        );
    }

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
    public function success(string $message, $data, int $statusCode = 200): JsonResponse
    {
        return $this->coreResponse($message, $data, $statusCode, [],  true);
    }
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
    public function error(array $messages, int $statusCode = 500): JsonResponse
    {
        return $this->coreResponse("", null, $statusCode , $messages, false);
    }
}
