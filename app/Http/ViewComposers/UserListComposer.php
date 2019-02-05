<?php

namespace App\Http\ViewComposers;

use App\Services\UserService;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Auth\Factory as Auth;

class UserListComposer
{
    /**
     * @var Auth
     */
    protected $authUser;

    /**
     * @var UserService
     */
    private $service;

    /**
     * Create a new timer composer.
     * @param Auth $auth
     * @param UserService $service
     * @return void
     */
    public function __construct(Auth $auth, UserService $service)
    {
        $this->auth = $auth;
        $this->service = $service;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('users', $this->service->getUnAuthUsers(
            $this->auth->user()
        ));
    }
}
