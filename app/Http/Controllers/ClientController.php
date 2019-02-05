<?php

namespace App\Http\Controllers;

use App\Http\Requests\EnrollRequest;
use App\Services\TransferService;
use App\Services\UserService;
use App\User;

class ClientController extends Controller
{
    /**
     * @param UserService $service
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(UserService $service)
    {
        return view('home')
            ->with('flow', $service->getAccountFlow(
                auth()->user()
            ));
    }

    /**
     * @param TransferService $service
     * @param EnrollRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function enroll(TransferService $service, EnrollRequest $request)
    {
        $wasEnroll = $service->enroll(auth()->user(), $request);

        return back()
            ->with('status', $wasEnroll ? 'success' : 'fail')
            ->with('amount', $request->amount);
    }
}
