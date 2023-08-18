<?php
$route['(:any)/states']['GET'] = 'StatesController/index/$1';
$route['states/crear']['POST'] = 'StatesController/create';
$route['states/update']['POST'] = 'StatesController/update';
$route['states/delete']['POST'] = 'StatesController/delete';
$route['states/suspend']['POST'] = 'StatesController/suspend';
$route['states/active']['POST'] = 'StatesController/active';
$route['states/search']['POST'] = 'StatesController/search';
$route['states/(:any)']['GET'] = 'StatesController/getRegister/$1';

// draw state
$route['drawState/(:any)']['GET'] = 'StatesController/getDrawMap/$1';
$route['drawState']['POST'] = 'StatesController/drawMap';
