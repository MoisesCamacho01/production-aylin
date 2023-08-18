<?php
$route['(:any)/usuarios']['GET'] = 'UsersController/index/$1';
$route['usuarios/crear']['POST'] = 'UsersController/create';
$route['usuarios/update']['POST'] = 'UsersController/update';
$route['usuarios/delete']['POST'] = 'UsersController/delete';
$route['usuarios/suspend']['POST'] = 'UsersController/suspend';
$route['usuarios/active']['POST'] = 'UsersController/active';
$route['usuarios/search']['POST'] = 'UsersController/search';
$route['usuarios/(:any)']['GET'] = 'UsersController/getRegister/$1';

