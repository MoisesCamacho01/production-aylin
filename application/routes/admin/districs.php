<?php
// $route['(:any)/districs/(:any)']['GET'] = 'DistricsController/index/$1/$2';
// $route['districs/crear']['POST'] = 'DistricsController/create';
// $route['districs/update']['POST'] = 'DistricsController/update';
// $route['districs/delete']['POST'] = 'DistricsController/delete';
// $route['districs/suspend']['POST'] = 'DistricsController/suspend';
// $route['districs/active']['POST'] = 'DistricsController/active';
// $route['districs/(:any)/search']['POST'] = 'DistricsController/search/$1';
// $route['districs/(:any)/(:any)']['GET'] = 'DistricsController/getRegister/$1/$2';


$route['(:any)/districs/(:any)']['GET'] = 'SectorsController/index/$1/$2';
$route['districs/crear']['POST'] = 'SectorsController/create';
$route['districs/update']['POST'] = 'SectorsController/update';
$route['districs/delete']['POST'] = 'SectorsController/delete';
$route['districs/suspend']['POST'] = 'SectorsController/suspend';
$route['districs/active']['POST'] = 'SectorsController/active';
$route['districs/(:any)/search']['POST'] = 'SectorsController/search/$1';
$route['districs/(:any)/(:any)']['GET'] = 'SectorsController/getRegister/$1/$2';


$route['districs-view/(:any)']['GET'] = 'DistricsController/districsView/$1';
$route['districs-search/(:any)']['GET'] = 'DistricsController/districsSearch/$1';
