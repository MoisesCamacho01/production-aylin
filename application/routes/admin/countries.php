<?php
$route['(:any)/countries']['GET'] = 'CountriesController/index/$1';
$route['countries/crear']['POST'] = 'CountriesController/create';
$route['countries/update']['POST'] = 'CountriesController/update';
$route['countries/delete']['POST'] = 'CountriesController/delete';
$route['countries/suspend']['POST'] = 'CountriesController/suspend';
$route['countries/active']['POST'] = 'CountriesController/active';
$route['countries/search']['POST'] = 'CountriesController/search';
$route['countries/(:any)']['GET'] = 'CountriesController/getRegister/$1';
