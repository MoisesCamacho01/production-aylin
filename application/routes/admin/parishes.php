<?php
$route['(:any)/parishes/(:any)']['GET'] = 'ParishesController/index/$1/$2';
$route['parishes/crear']['POST'] = 'ParishesController/create';
$route['parishes/update']['POST'] = 'ParishesController/update';
$route['parishes/delete']['POST'] = 'ParishesController/delete';
$route['parishes/suspend']['POST'] = 'ParishesController/suspend';
$route['parishes/active']['POST'] = 'ParishesController/active';
$route['parishes/(:any)/search']['POST'] = 'ParishesController/search/$1';
$route['parishes/(:any)/(:any)']['GET'] = 'ParishesController/getRegister/$1/$2';

$route['parishes-search/(:any)']['GET'] = 'ParishesController/parishesSearch/$1';

// draw state
$route['drawParish/(:any)']['GET'] = 'ParishesController/getDrawMap/$1';
$route['drawParish']['POST'] = 'parishesController/drawMap';
