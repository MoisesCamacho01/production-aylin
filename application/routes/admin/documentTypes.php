<?php
$route['(:any)/documentTypes']['GET'] = 'DocumentTypesController/index/$1';
$route['documentTypes/crear']['POST'] = 'DocumentTypesController/create';
$route['documentTypes/update']['POST'] = 'DocumentTypesController/update';
$route['documentTypes/delete']['POST'] = 'DocumentTypesController/delete';
$route['documentTypes/suspend']['POST'] = 'DocumentTypesController/suspend';
$route['documentTypes/active']['POST'] = 'DocumentTypesController/active';
$route['documentTypes/search']['POST'] = 'DocumentTypesController/search';
$route['documentTypes/(:any)']['GET'] = 'DocumentTypesController/getRegister/$1';
