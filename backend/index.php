<?php
echo __DIR__;

require_once __DIR__ . '/../vendor/autoload.php';

Flight::set('flight.base_url', '/JasenkoZlatarević/backend');

// Service + route
require_once __DIR__ . '/services/UserService.php';
Flight::register('user_service', 'UserService');

require_once __DIR__ . '/routes/UserRoutes.php';

Flight::start();
