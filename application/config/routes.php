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

// Solar system
$route['api/solar/list'] = 'api/solarsystem';
$route['api/solar/add']  = 'api/solarsystem/add_solar';
$route['api/solar/edit'] = 'api/solarsystem/add_solar';
$route['api/solar/remove'] = 'api/solarsystem/remove_solar';

// Solar planets
$route['api/planet/list'] = 'api/solarplanets';
$route['api/planet/add']  = 'api/solarplanets/add_planet';
$route['api/planet/edit'] = 'api/solarplanets/add_planet';
$route['api/planet/remove'] = 'api/solarplanets/remove_planet';

//Search
$route['api/solar/findsun'] = 'api/solarsystem/find_solarsun';
$route['api/solar/findplanets'] = 'api/solarsystem/find_solarplanets';
$route['api/solar/findorbitsun'] = 'api/solarsystem/find_solar_orbitsun';
$route['api/solar/findbyname'] = 'api/solarsystem/find_solarplanetsun_byname';
$route['api/solar/findbysize'] = 'api/solarsystem/find_solarplanetsun_bysize';

//Optional Task Distance Calculation
$route['api/solar/findDistance'] = 'api/solarsystem/find_distance_solar';

$route['default_controller'] = 'welcome';
$route['404_override'] = 'welcome';
$route['translate_uri_dashes'] = FALSE;
