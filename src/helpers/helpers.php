<?php

if (!function_exists('after_login')) {
    function after_login($user, $request = null)
    {
        // logger("User logged in", ['user_id' => $user->id]);
    }
}

if (!function_exists('after_logout')) {
    function after_logout($user, $request = null)
    {
        // logger("User logged out", ['user_id' => $user->id]);
    }
}

if (!function_exists('after_register')) {
    function after_register($user, $request = null)
    {
        // logger("User registered", ['user_id' => $user->id]);
    }
}
