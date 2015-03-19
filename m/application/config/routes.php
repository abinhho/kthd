<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = "frontend";
$route['scaffolding_trigger'] = "";

$route['404_override'] = '';
$route['admin'] = 'backend';
$route['admin/(:any)'] = 'backend/$1';
$route['(:num)/(:any)/(:any)-(:num).html'] = 'frontend/index/$1/$4'; 
$route['(:num)/(:any).html'] = 'frontend/index/$1';

$route['user'] = 'frontend/index/user/show_item';
$route['user/(:num)'] = 'frontend/index/user/info/$1';
$route['user/edit/(:num)'] = 'frontend/index/user/edit/$1';
$route['user/ajax_(:any)'] = 'user/ajax_$1';
$route['user/(:any)'] = 'frontend/index/user/$1';

$route['spage/(:any)-(:num).html'] = 'frontend/index/spage/view_item/$2';

$route['tags'] = 'frontend/index/tags/show_all_items';
$route['tags/ajax_(:any)'] = 'tags/ajax_$1';
$route['tags/catagory/(:num)'] = 'frontend/index/tags/show_item/$1';
//$route['tags/(:any)'] = 'frontend/index/questions/show_item';

$route['feedback'] = 'frontend/index/feedback/send_feedback';
$route['orders/(:any)'] = 'frontend/index/orders/$1';

$route['cards/(:any)'] = 'frontend/index/cards/$1';

$route['search-products'] = 'frontend/index/products/search';

$route['search'] = 'frontend/index/questions/search';
$route['questions'] = 'frontend/index/questions/show_item/65';
$route['questions/save-answer'] = 'questions/save_answer';
$route['questions/ajax_(:any)'] = 'questions/ajax_$1';
$route['questions/([-a-z0-9]+)'] = 'frontend/index/questions/show_item/$1';
//$route['questions/(:num)'] = 'frontend/index/questions/show_item/$1';
$route['questions/(:num)/([-a-z0-9]+)-(:num).html'] = 'frontend/index/questions/view_item/$3';

$route['questions/ask'] = 'frontend/index/questions/ask';
$route['questions/ask/(:any)'] = 'frontend/index/questions/ask/$1';
$route['questions/del/(:num)'] = 'frontend/index/questions/del/$1';

$route['questions/unanswers'] = 'frontend/index/questions/unanswers';
$route['questions/edit-answer/(:any)'] = 'frontend/index/questions/edit_answer/$1';
$route['questions/del-answer/(:any)'] = 'questions/del_answer/$1';
$route['tags/([-a-z0-9]+)/([-a-z0-9]+)'] = 'frontend/index/questions/show_item_by_tag/$2';

$route['ajax-cart/(:any)'] = 'cart/$1';
$route['cart/(:any)'] = 'frontend/index/cart/$1';

$route['page-not-found.html'] = 'frontend/index/_404/index';
//$route['(:any)'] = 'frontend';


/* End of file routes.php */
/* Location: ./application/config/routes.php */