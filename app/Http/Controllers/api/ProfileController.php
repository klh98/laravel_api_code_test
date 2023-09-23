<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;

class ProfileController extends Controller
{
    public function profile()
    {
        $user= auth()->guard()->user();

        return ResponseHelper::success(new ProfileResource($user));
    }

}
