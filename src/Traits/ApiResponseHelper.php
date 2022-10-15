<?php declare(strict_types=1);
/**
 * Created by mister bk! GmbH.
 * User: Dominik Feilbach
 * Date: 13.10.22
 * Time: 23:23
 */

namespace Domeo\TenancyModulesLaravel\Traits;


use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ApiResponseHelper
{

    private function apiResponse(array $data, int $code = 200): JsonResponse
    {
        return response()->json($data, $code);
    }

    public function respondError(?string $message = null, ?string $key = 'error'): JsonResponse
    {
        return $this->apiResponse([$key => $message ?? 'Error'], Response::HTTP_BAD_REQUEST);
    }

    public function responseNotFound($message, ?string $key = 'error')
    {
        return $this->apiResponse([$key => $message], Response::HTTP_NOT_FOUND);
    }

    public function responseWithSuccess($data): JsonResponse
    {
        return $this->apiResponse($data);
    }
    public function respondUnAuthenticated(?string $message = null, ?string $key = 'error'): JsonResponse
    {
        return $this->apiResponse(
            ['key' => $message ?? 'Unauthenticated'],
            Response::HTTP_UNAUTHORIZED
        );
    }

    public function respondForbidden(?string $message = null, ?string $key = 'error'): JsonResponse
    {
        return $this->apiResponse(
            [$key => $message ?? 'Forbidden'],
            Response::HTTP_FORBIDDEN
        );
    }

    public function respondCreated($data = null): JsonResponse
    {
        return $this->apiResponse($data, Response::HTTP_CREATED);
    }

    public function respondFailedValidation($message, ?string $key = 'error'): JsonResponse {
        return $this->apiResponse([$key => $message],
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }

    public function respondNoContent($data = null): JsonResponse
    {
        return $this->apiResponse($data, Response::HTTP_NO_CONTENT);
    }

}
