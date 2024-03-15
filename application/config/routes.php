<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';

$route['translate_uri_dashes'] = FALSE;
$route['admin'] = 'admin/dashboard';
$route['superadmin'] = 'superadmin/dashboard';
$route['gyms'] = 'superadmin/gym/index';
$route['countries'] = 'superadmin/countries/index';
$route['currencies'] = 'superadmin/currencies/index';
$route['cities'] = 'superadmin/cities/index';
$route['members'] = 'admin/members/index';
$route['members/checksms'] = 'admin/members/checksms';
$route['members/updatereminderstatus'] = 'admin/members/updatereminderstatus';

$route['attendences']='admin/attendences/attendences';
$route['attendencelist']='admin/attendences/attendencelist';
$route['manual_attendednce']='admin/attendences/manual_attendednce';

$route['chart'] = 'admin/dashboard/chart';
$route['admin/registered'] = 'admin/dashboard/registeredmembers';
$route['admin/active'] = 'admin/dashboard/activemembers';
$route['admin/inactive'] = 'admin/dashboard/inactivemembers';
$route['admin/upcoming'] = 'admin/dashboard/upcomingfeee';
$route['admin/pastfees'] = 'admin/dashboard/pastfees';

$route['registered'] = 'admin/dashboard/registeredmembers';
$route['active'] = 'admin/dashboard/activemembers';
$route['inactive'] = 'admin/dashboard/inactivemembers';
$route['upcoming'] = 'admin/dashboard/upcomingfeee';
$route['pastfees'] = 'admin/dashboard/pastfees';
$route['paidfees'] = 'admin/dashboard/paidfees';
$route['present'] = 'admin/dashboard/present_today';
$route['pendingfees'] = 'admin/dashboard/pendingfees';

$route['admin/paidfees'] = 'admin/dashboard/paidfees';
$route['admin/pendingfees'] = 'admin/dashboard/pendingfees';

$route['admin/members/viewattendence/(:any)'] = 'admin/members/viewattendence/$1';

$route['users'] = 'admin/users/adminusers';
$route['settings'] = 'admin/settings';


$route['attendencecharts'] = 'admin/charts/attendencecharts';
$route['profitlosscharts'] = 'admin/charts/profitlosscharts';
$route['profitlosscharts2'] = 'admin/charts/profitlosscharts2';
$route['reports'] = 'admin/charts/reportscharts';
$route['feesreport'] = 'admin/charts/feesreport';
$route['calendar'] = 'admin/calendar/calendar';




$route['packages'] = 'admin/packages/index';
$route['expenses'] = 'admin/expenses/index';
$route['balancesheet'] = 'admin/profit_loss/balancesheet';
$route['sms'] = 'admin/sms';
//$route['auth2'] = 'auth2/index';


$route['404_override'] = '';
