<?php
$route['(:any)/permission/(:any)']['GET'] = 'PermissionController/index/$1/$2';
$route['permission/(:any)/menu']['POST'] = 'PermissionController/updateMenu/$1';
$route['permission/(:any)/submenu']['POST'] = 'PermissionController/updateSubMenu/$1';
$route['permission/(:any)/button']['POST'] = 'PermissionController/updateButton/$1';


