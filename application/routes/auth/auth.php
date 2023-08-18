<?php

$route['login']['GET'] = 'AuthController/login';
$route['recuperar-password']['GET'] = 'AuthController/forgotPassword';

$route['singIn']['POST']= 'AuthController/startSession';
$route['singOut']['GET']= 'AuthController/closeSession';

$route['send-email']['POST'] = 'AuthController/sendEmailResetPassword';
$route['validate-code/(:any)']['GET'] = 'AuthController/ResetPassword/$1';
$route['reset-password']['POST'] = 'AuthController/updatePassword';

