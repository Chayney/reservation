<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Contracts\Auth\StatefulGuard;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class RegisterResponse implements RegisterResponseContract
{
    protected $guard;

    public function __construct(StatefulGuard $guard)
    {
        $this->guard = $guard;
    }

    public function toResponse($request)
    {
        $this->guard->logout();

        return $request->wantsJson()
            ? new JsonResponse('', 201)
            : redirect('thanks');
    }
    
}