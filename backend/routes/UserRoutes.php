<?php

Flight::route('GET /users', function () {
    $users = Flight::get('user_service')->get_all_users();
    Flight::json($users);
});
