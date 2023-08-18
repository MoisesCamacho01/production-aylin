<?php
$route['(:any)/cities']['GET'] = 'CitiesController/index/$1';
$route['cities/crear']['POST'] = 'CitiesController/create';
$route['cities/update']['POST'] = 'CitiesController/update';
$route['cities/delete']['POST'] = 'CitiesController/delete';
$route['cities/suspend']['POST'] = 'CitiesController/suspend';
$route['cities/active']['POST'] = 'CitiesController/active';
$route['cities/search']['POST'] = 'CitiesController/search';
$route['cities/(:any)']['GET'] = 'CitiesController/getRegister/$1';

$route['cities-search/(:any)']['GET'] = 'CitiesController/citiesSearch/$1';

// draw state
$route['drawCity/(:any)']['GET'] = 'CitiesController/getDrawMap/$1';
$route['drawCity']['POST'] = 'CitiesController/drawMap';

