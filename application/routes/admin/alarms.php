<?php
$route['(:any)/alarms/(:any)']['GET'] = 'AlarmsController/index/$1/$2';
$route['alarms/crear']['POST'] = 'AlarmsController/create';
$route['alarms/update']['POST'] = 'AlarmsController/update';
$route['alarms/delete']['POST'] = 'AlarmsController/delete';
$route['alarms/suspend']['POST'] = 'AlarmsController/suspend';
$route['alarms/active']['POST'] = 'AlarmsController/active';
$route['alarms/(:any)/search']['POST'] = 'AlarmsController/search/$1';
$route['alarms/(:any)/(:any)']['GET'] = 'AlarmsController/getRegister/$1/$2';

// draw sector

$route['drawAlarm/(:any)']['GET'] = 'AlarmsController/getDrawMapAlarm/$1';
$route['drawAlarm']['POST'] = 'AlarmsController/drawMapAlarm';
