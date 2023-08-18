<?php
$route['(:any)/userTypes']['GET'] = 'UserTypesController/index/$1';
$route['userTypes/crear']['POST'] = 'UserTypesController/create';
$route['userTypes/update']['POST'] = 'UserTypesController/update';
$route['userTypes/delete']['POST'] = 'UserTypesController/delete';
$route['userTypes/suspend']['POST'] = 'UserTypesController/suspend';
$route['userTypes/active']['POST'] = 'UserTypesController/active';
$route['userTypes/search']['POST'] = 'UserTypesController/search';
$route['userTypes/(:any)']['GET'] = 'UserTypesController/getRegister/$1';
