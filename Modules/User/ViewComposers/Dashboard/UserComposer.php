<?php

namespace Modules\User\ViewComposers\Dashboard;


use Cache;
use Illuminate\View\View;
use Modules\User\Repositories\Dashboard\UserRepository;

class UserComposer
{
    public $users = [];

    public function __construct(UserRepository $user)
    {
        $this->users =  $user->getAllActive();
    
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('users', $this->users);
    }
}
