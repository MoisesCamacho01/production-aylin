<?php
$route['(:any)/branches/(:any)']['GET'] = 'BranchesController/index/$1/$2';
$route['branches/crear']['POST'] = 'BranchesController/create';
$route['branches/update']['POST'] = 'BranchesController/update';
$route['branches/delete']['POST'] = 'BranchesController/delete';
$route['branches/suspend']['POST'] = 'BranchesController/suspend';
$route['branches/active']['POST'] = 'BranchesController/active';
$route['branches/(:any)/search']['POST'] = 'BranchesController/search/$1';
$route['branches/(:any)/(:any)']['GET'] = 'BranchesController/getRegister/$1/$2';
