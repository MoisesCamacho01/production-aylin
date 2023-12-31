<?php
$route['pdf-users/(:any)']['GET'] = 'UsersController/pdf/$1';
$route['pdf-userTypes']['GET'] = 'UserTypesController/pdf';
$route['pdf-documentTypes']['GET'] = 'DocumentTypesController/pdf';
$route['pdf-countries']['GET'] = 'CountriesController/pdf';
$route['pdf-states']['GET'] = 'StatesController/pdf';
$route['pdf-cities']['GET'] = 'CitiesController/pdf';
$route['pdf-parishes/(:any)']['GET'] = 'ParishesController/pdf/$1';
$route['pdf-districts/(:any)']['GET'] = 'DistricsController/pdf/$1';
$route['pdf-sectors/(:any)']['GET'] = 'SectorsController/pdf/$1';
$route['pdf-institutions']['GET'] = 'InstitutionsController/pdf';
$route['pdf-branches']['GET'] = 'BranchesController/pdf';
$route['pdf-managers']['GET'] = 'ManagersController/pdf';
$route['pdf-typeNot']['GET'] = 'TypeNotificationsController/pdf';
$route['pdf-alarms/(:any)']['GET'] = 'AlarmsController/pdf/$1';

$route['pdf-success-access']['GET'] = 'ReportsController/pdfAccessCorrect';
$route['pdf-password-reset']['GET'] = 'ReportsController/pdfPasswordReset';
$route['pdf-active-alarm']['GET'] = 'ReportsController/pdfActiveAlarm';
$route['pdf-history']['GET'] = 'ReportsController/pdfHistory';

