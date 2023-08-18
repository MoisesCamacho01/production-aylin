<?php

$route['profile/(:any)']['GET'] = 'ProfilesController/getRegister/$1';
$route['profile-update/(:any)']['POST'] = 'ProfilesController/updateProfile/$1';
