<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// default controller for this module
//$route['admin'] = 'home';
$route['read/(:any)'] = 'posts/read/$1';
$route['blog'] = 'posts/index';
$route['blog/(:num)'] = 'posts/index/$1';