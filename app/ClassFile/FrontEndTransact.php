<?php

namespace App\Classfile;

use Illuminate\Http\Request;




class FrontEndTransact
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
}
