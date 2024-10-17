<?php

// ============================================
//      This is the Guest Middleware Class
// ============================================
//  You can use this middleware class to
//  enforce guest access on unprotected routes.
//  You can also use this to hide other routes
//  from singed in users (e.g register routes).
//  
//  We can see that handle() function is the
//  function that handles the redirection, as
//  well as the conditions for the redirection.
//  Please use the same function across all
//  Middleware classes.

namespace Core\Middleware;

use Core\Authenticator;

class Guest
{

    protected array $role_routes = [
        2 => '/custodian',
        1 => '/coordinator',
    ];

    public function handle()
    {
        if (isset($_SESSION['user'])) {
            $role = $_SESSION['user']['role'];
            if (!isset($this->role_routes[$role])) {
                (new Authenticator)->logout();
                redirect('/');
            }

            redirect($this->role_routes[$role]);
        }
    }
}
