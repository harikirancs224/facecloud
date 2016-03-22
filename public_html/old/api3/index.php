<?php
header('Access-Control-Allow-Origin: *');
//header('Content-Type: application/javascript');
header('Content-Type:'.$_SERVER["CONTENT_TYPE"]);

 
// --- Step 1: Initialize variables and functions
 
/**
 * Deliver HTTP Response
 * @param string $format The desired HTTP response content type: [json, html, xml]
 * @param string $api_response The desired HTTP response data
 * @return void
 **/
function deliver_response($format, $api_response){
 
    // Define HTTP responses
    $http_response_code = array(
        200 => 'OK',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        403 => 'Forbidden',
        404 => 'Not Found'
    );
 
    // Set HTTP Response
    //header('HTTP/1.1 '.$api_response['status'].' '.$http_response_code[ $api_response['status'] ]);

    // Process different content types
   
 
        // Set HTTP Response Content Type
        //header('Content-Type: application/json; charset=utf-8');
 //header('Content-Type: application/json');
        // Format data into a JSON response
        $json_response = json_encode($api_response);
 
        // Deliver formatted data
        echo $json_response;
 
    
 
    // End script process
    exit;
 
}
 
// Define whether an HTTPS connection is required
$HTTPS_required = FALSE;
 
// Define whether user authentication is required
$authentication_required = FALSE;
 
// Define API response codes and their related HTTP response
$api_response_code = array(
    0 => array('HTTP Response' => 400, 'Message' => 'Unknown Error'),
    1 => array('HTTP Response' => 200, 'Message' => 'Success'),
    2 => array('HTTP Response' => 403, 'Message' => 'HTTPS Required'),
    3 => array('HTTP Response' => 401, 'Message' => 'Authentication Required'),
    4 => array('HTTP Response' => 401, 'Message' => 'Authentication Failed'),
    5 => array('HTTP Response' => 404, 'Message' => 'Invalid Request'),
    6 => array('HTTP Response' => 400, 'Message' => 'Invalid Response Format')
);
 
// Set default HTTP response of 'ok'
$response['code'] = 0;
$response['status'] = 404;
$response['data'] = NULL;
 

 
// --- Step 3: Process Request
 
// Method A: Say Hello to the API
/*if( strcasecmp($_GET['method'],'hello') == 0){*/
//$post=$_POST['customer'];
$rq=$_SERVER['REQUEST_METHOD'];
    $response['code'] = 1;
    $response['request']=$rq;
    $response['status'] = $api_response_code[ $response['code'] ]['HTTP Response'];
    $response['data'] = 'Hello World';
//}
 
// --- Step 4: Deliver Response
 
// Return Response to browser
deliver_response($_GET['format'], $response); 