<?php
$route['excel-users']['GET'] = 'UsersController/excel';
$route['excel-userTypes']['GET'] = 'UserTypesController/excel';
$route['excel-documentTypes']['GET'] = 'DocumentTypesController/excel';
$route['excel-countries']['GET'] = 'CountriesController/excel';
$route['excel-states']['GET'] = 'StatesController/excel';
$route['excel-cities']['GET'] = 'CitiesController/excel';
$route['excel-parishes/(:any)']['GET'] = 'ParishesController/excel/$1';
$route['excel-districts/(:any)']['GET'] = 'DistricsController/excel/$1';
$route['excel-sectors']['GET'] = 'SectorsController/excel';
$route['excel-institutions']['GET'] = 'InstitutionsController/excel';
$route['excel-branches']['GET'] = 'BranchesController/excel';
$route['excel-Managers']['GET'] = 'ManagersController/excel';
$route['excel-typeNot']['GET'] = 'TypeNotificationsController/excel';

$route['excel-password-reset']['GET'] = 'ReportsController/excelPasswordReset';
$route['excel-active-alarm']['GET'] = 'ReportsController/excelActiveAlarm';
$route['excel-success-access']['GET'] = 'ReportsController/excelAccessCorrect';
$route['excel-history']['GET'] = 'ReportsController/excelHistory';
