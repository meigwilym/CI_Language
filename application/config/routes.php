<?php

$route['(\w{2})/(.*)'] = '$2';

$route['(\w{2})'] = $route['default_controller']; 