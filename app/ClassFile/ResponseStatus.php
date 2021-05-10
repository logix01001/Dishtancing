<?php

namespace App\Classfile;


class ResponseStatus
{

    /**
     * @param array $data - Contents
     * @param integer $statuscode - status code
     * @param array $headers - header content
     */


    public static function success($data,$statuscode = 200,$headers = [])
    {
        return  response()->json($data,$statuscode, $headers);
    }


    /**
     * @param array $data - Contents
     * @param integer $statuscode - status code
     * @param array $headers - header content
     */
    public static function failed($data,$statuscode = 400,$headers = [])
    {
        return  response()->json($data,$statuscode, $headers);
    }
}
