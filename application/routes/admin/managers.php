<?php
$route['(:any)/managers']['GET'] = 'ManagersController/index/$1';
$route['managers/crear']['POST'] = 'ManagersController/create';
$route['managers/update']['POST'] = 'ManagersController/update';
$route['managers/delete']['POST'] = 'ManagersController/delete';
$route['managers/suspend']['POST'] = 'ManagersController/suspend';
$route['managers/active']['POST'] = 'ManagersController/active';
$route['managers/search']['POST'] = 'ManagersController/search';
$route['managers/(:any)']['GET'] = 'ManagersController/getRegister/$1';
