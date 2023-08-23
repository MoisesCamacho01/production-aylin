<?php
$route['dashboard']['GET'] = 'DashboardController/index';
$route['kpi8/(:any)']['GET'] = 'DashboardController/kpi8/$1';
