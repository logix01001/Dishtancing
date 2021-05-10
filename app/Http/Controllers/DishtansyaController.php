<?php

namespace App\Http\Controllers;

use App\Classfile\Api;
use Illuminate\Http\Request;
use App\Classfile\FrontEndTransact;
use App\Classfile\Login;
use App\Classfile\Order;
use App\Classfile\Registration;

class DishtansyaController extends Controller
{
    //

    public function registration(Request $request)
    {
        $registration = new Registration($request);
        return $this->doApi($registration);
    }


    public function login(Request $request)
    {
        $login = new Login($request);
        return $this->doApi($login);
    }

    public function order(Request $request)
    {
        $order = new Order($request);
        return $this->doApi($order);
    }





    /**
     * @param Api $transact - Transaction API
     */
    private function doApi(Api $transact)
    {
        return $transact->processApi();
    }
}
