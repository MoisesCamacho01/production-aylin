<?php

$route['(:any)/reports/maps']['GET'] = 'ReportsController/index/$1';
$route['(:any)/reports/successAccess']['GET'] = 'ReportsController/successAccess/$1';
$route['(:any)/reports/activeAlarm']['GET'] = 'ReportsController/activeAlarm/$1';
$route['(:any)/reports/historyUseSystem']['GET'] = 'ReportsController/historyUseSystem/$1';
$route['(:any)/reports/passwordReset']['GET'] = 'ReportsController/passwordReset/$1';

// AJAX
//COUNTRY
$route['reports/states/all-state-country/(:any)']['GET'] = 'StatesController/allSectorForCountry/$1';
$route['reports/cities/all-alarm-state/(:any)']['GET'] = 'StatesController/allAlarmOfState/$1';

$route['reports/cities/all-city-state/(:any)']['GET'] = 'CitiesController/allCityForState/$1';
$route['reports/parish/all-parish-city/(:any)']['GET'] = 'ParishesController/allParishForCity/$1';

$route['reports/cities/all-alarm-city/(:any)']['GET'] = 'CitiesController/allAlarmOfCity/$1';
$route['reports/parish/all-alarm-parish/(:any)']['GET'] = 'ParishesController/allAlarmOfParish/$1';

$route['reports/sector/all-alarm-sector/(:any)']['GET'] = 'SectorsController/allAlarmOfSector/$1';

// ALL
$route['reports/sectors/all']['GET'] = 'SectorsController/all';
$route['reports/sectors/all-sectors-barrio/(:any)']['GET'] = 'SectorsController/allSectorDistrict/$1';
$route['reports/alarms/all-of-sector/(:any)']['GET'] = 'AlarmsController/allOfSector/$1';

$route['reports-sa/search']['POST'] = 'ReportsController/searchAccessCorrect';
$route['reports-aa/search']['POST'] = 'ReportsController/searchActiveAlarm';
$route['reports-hus/search']['POST'] = 'ReportsController/searchHistory';
$route['reports-pr/search']['POST'] = 'ReportsController/searchPasswordReset';
