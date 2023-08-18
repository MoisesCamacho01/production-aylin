<?php
$route['(:any)/institutions']['GET'] = 'InstitutionsController/index/$1';
$route['institutions/crear']['POST'] = 'InstitutionsController/create';
$route['institutions/update']['POST'] = 'InstitutionsController/update';
$route['institutions/delete']['POST'] = 'InstitutionsController/delete';
$route['institutions/suspend']['POST'] = 'InstitutionsController/suspend';
$route['institutions/active']['POST'] = 'InstitutionsController/active';
$route['institutions/search']['POST'] = 'InstitutionsController/search';
$route['institutions/(:any)']['GET'] = 'InstitutionsController/getRegister/$1';
