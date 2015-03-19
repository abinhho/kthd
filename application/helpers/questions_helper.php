<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('in_array_to_active'))
{
    function in_array_to_active($str, $lists, $active = 'active')
    {
        if(empty($str)) return '';
        if(!is_array($lists))
        $lists = preg_split('/,/', $lists);
        return (in_array($str, $lists)) ? $active : '';
    }
}
if ( ! function_exists('encode_me'))
{
    function encode_me($str)
    {
        $CI = & get_instance();
        $CI->load->library('encrypt');
        return str_replace('=','-',base64_encode($CI->encrypt->encode($str)));
    }
}

if ( ! function_exists('decode_me'))
{
    function decode_me($str)
    {  
        if(strlen($str) <= 10 || is_numeric($str)) return $str;
        $CI = & get_instance();
        $CI->load->library('encrypt'); 
        return $CI->encrypt->decode(base64_decode(str_replace('-','=',$str)));
        
    }
}

