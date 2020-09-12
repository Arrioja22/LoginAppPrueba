<?php

namespace App\Http\Controllers;

use Config;

if (!function_exists('Build_response')) {

    /**
     * Build a Json response using the standard template
     *
     * @param integer $code             HTTP status code
     * @param string  $message          Status message
     * @param array   $data             Data payload
     * @param boolean $skip_translation Use message without translation
     *
     * @return \Illuminate\Http\Response Formatted response
     */
     function Build_response($code, $message, $data = [], $skip_translation = false)
     {
         return response()->json([
             Config::get('constants.response.CODE') => $code,
             Config::get('constants.response.MESSAGE') =>
                 $skip_translation ? $message : 'Algo ocurrió mal',
             Config::get('constants.response.DATA') => $data
         ], $code);
     }
 }
 
 
 if (!function_exists('SuccessResponse')) {
 
    /**
     * Return a standard success response (code 200, success message and data).
     *
     * @param Collection $data Collection of data
     * @param String $message Response message
     *
     * @return \Illuminate\Http\Response Formatted response
     */
     function SuccessResponse($data, $message = null)
     
     {
         if ($message == null) {
             $message = Config::get('constants.response.SUCCESS');
         }
         return response()->json([
             Config::get('constants.response.CODE') => Config::get('constants.code.HTTP_OK'),
             Config::get('constants.response.MESSAGE') => $message,
             Config::get('constants.response.DATA') => $data
         ], Config::get('constants.code.HTTP_OK'));
     }
 }
 
 if (!function_exists('BadResponse')) {
 
    /**
     * Return a standard bad response (code 400, error message wihout data).
     *
     * @param String $message Response message
     *
     * @return \Illuminate\Http\Response Formatted response
     */
     function BadResponse($message)
     {
         return response()->json([
             Config::get('constants.response.CODE') => Config::get('constants.code.HTTP_BAD_REQUEST'),
             Config::get('constants.response.MESSAGE') => $message,
             Config::get('constants.response.DATA') => []
         ], Config::get('constants.code.HTTP_BAD_REQUEST'));
     }
 
 }
 
 if (!function_exists('UnprocessableEntity')) {
  
     /**
      * Return a standard bad response (code 422, error message with data).
      *
      * @param Collection $message
      *
      * @return \Illuminate\Http\Response Formatted response
          */
     function UnprocessableEntity($message, $errors, $data = null)
     {
         $response = [
             Config::get('constants.response.CODE') => Config::get('constants.code.HTTP_UNPROCESSABLE_ENTITY'),
             Config::get('constants.response.MESSAGE') => $message,
             Config::get('constants.response.ERRORS') =>$errors,
         ];
 
         if (!is_null($data)) {
             $response[Config::get('constants.response.DATA')] = $data;
         }
 
         return response()->json($response, Config::get('constants.code.HTTP_UNPROCESSABLE_ENTITY'));
     }
 }