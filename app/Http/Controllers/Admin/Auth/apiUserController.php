<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class apiUserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return response()->json($user);
    }
}
