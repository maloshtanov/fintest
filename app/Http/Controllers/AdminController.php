<?php

namespace App\Http\Controllers;

use App\Services\UserService;

class AdminController extends Controller
{
    /**
     * @param UserService $service
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(UserService $service)
    {
        return view('admin')
            ->with('users', $service->getUsersWithLastTransfers());
    }
}
