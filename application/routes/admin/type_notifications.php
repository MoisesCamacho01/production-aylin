<?php

$route['(:any)/type-not']['GET'] = 'TypeNotificationsController/index/$1';
$route['type-not/crear']['POST'] = 'TypeNotificationsController/create';
$route['type-not/update']['POST'] = 'TypeNotificationsController/update';
$route['type-not/delete']['POST'] = 'TypeNotificationsController/delete';
$route['type-not/suspend']['POST'] = 'TypeNotificationsController/suspend';
$route['type-not/active']['POST'] = 'TypeNotificationsController/active';
$route['type-not/search']['POST'] = 'TypeNotificationsController/search';
$route['type-not/(:any)']['GET'] = 'TypeNotificationsController/getRegister/$1';
