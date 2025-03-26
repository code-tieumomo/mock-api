<?php

namespace App\Http\Middleware;

use App\Models\MockApi;
use App\Models\MockRequest;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CaptureMockApiRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $providerId = $request->route('providerId');
        $user = User::where('provider_id', $providerId)->first();
        $userId = $user->id;

        $prefix = $request->route('prefix');
        $mockApi = MockApi::where('user_id', $userId)
            ->where('prefix', '/' . $prefix)
            ->first();

        $mockRequest = MockRequest::create([
            'mock_api_id' => $mockApi->id,
            'method' => $request->method(),
            'endpoint' => $request->fullUrl(),
            'request_data' => json_encode(array_merge($request->all(), [
                'headers' => $request->headers->all(),
                'ip' => $request->ip(),
            ])),
            'response_data' => json_encode([]),
            'status' => 0,
        ]);

        $response = $next($request);

        $mockRequest->update([
            'response_data' => json_encode([
                'status' => $response->status(),
                'headers' => $response->headers->all(),
                'content' => $response->getContent(),
            ]),
            'status' => 1,
        ]);

        return $response;
    }
}
