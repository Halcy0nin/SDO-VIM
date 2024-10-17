<?php

// ========================================
//    This is the Auth Class
// ========================================
//  You can use the attempt() function to
//  login a registered user and the logout()
//  function to sign out the user and delete
//  their session.

namespace Core;

class Authenticator
{
    public function attempt($user_name, $password)
    {
        $user = App::resolve(Database::class)->query('select * from users where user_name = :user_name', [
            'user_name' => $user_name
        ])->find();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $this->login([
                    'user_id' => $user['user_id'],
                    'user_name' => $user['user_name'],
                    'role' => $user['role'],
                    'school_id' => $user['school_id'],
                ]);

                return true;
            }
        }

        return false;
    }

    public function login($user)
    {
        $_SESSION['user'] = [
            'user_id' => $user['user_id'],
            'user_name' => $user['user_name'],
            'role' => $user['role'],
            'school_id' => $user['school_id'],
        ];

        session_regenerate_id(true);
    }

    public function logout()
    {
        Session::destroy();
    }
}
