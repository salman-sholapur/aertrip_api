<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if (!function_exists('apiOkResponse'))
{
    function apiOkResponse($data){
    	$ci =& get_instance();
        return $ci->response($data, REST_Controller::HTTP_OK);
    }
}

if (!function_exists('apiBadRequest'))
{
    function apiBadRequest($message){
    	$ci =& get_instance();
        return $ci->response($message, REST_Controller::HTTP_BAD_REQUEST);
    }
}

if (!function_exists('apiSuccessResponse'))
{
    function apiSuccessResponse($message){
    	$ci =& get_instance();
        return $ci->response(['status' => TRUE, 'message' => $message], REST_Controller::HTTP_OK);
    }
}

if (!function_exists('apiNotFoundResponse'))
{
    function apiNotFoundResponse($message){
    	$ci =& get_instance();
        return $ci->response(['status' => FALSE, 'message' => $message ], REST_Controller::HTTP_NOT_FOUND);
    }
}