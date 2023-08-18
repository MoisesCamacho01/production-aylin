<?php
$route['(:any)/sectors/(:any)']['GET'] = 'SectorsController/index/$1/$2';
$route['sectors/crear']['POST'] = 'SectorsController/create';
$route['sectors/update']['POST'] = 'SectorsController/update';
$route['sectors/delete']['POST'] = 'SectorsController/delete';
$route['sectors/suspend']['POST'] = 'SectorsController/suspend';
$route['sectors/active']['POST'] = 'SectorsController/active';
$route['sectors/(:any)/search']['POST'] = 'SectorsController/search/$1';
$route['sectors/(:any)/(:any)']['GET'] = 'SectorsController/getRegister/$1/$2';

// sector
$route['sectors-view/(:any)']['GET'] = 'SectorsController/sectorsView/$1';

// draw sector
$route['drawSector/(:any)']['GET'] = 'SectorsController/getDrawMapSector/$1';
$route['drawSector']['POST'] = 'SectorsController/drawMapSector';
