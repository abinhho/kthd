<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('active_menu_item'))
{
    function active_menu($item)
    {
		$CI = & get_instance();
        $items = $CI->config->item('active_menu');
		if(empty($items)) return '';
		$items = preg_split('/,/', $items);
		return (in_array($item, $items)) ? "active" : "";
    }
}


