<?php

namespace App\Classfile;

use Exception;
use App\Models\User;
use App\Classfile\Api;
use App\Classfile\ResponseStatus;
use Illuminate\Support\Facades\DB;
use App\Classfile\FrontEndTransact;
use App\Models\Product;
use Facade\FlareClient\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\ThrottlesLogins;

/**
 * Order a specific product
 * As a registered user
 *
 * 1.Once an order has been successfully placed,
 * deduct the given quantity on the available stock on the specified product
 */
class Order extends FrontEndTransact implements Api
{

    use ThrottlesLogins;

    protected $maxAttempts = 5;
    protected $decayMinutes = 5;

    public function processApi()
    {
        $validated = $this->request->validate([
            'product_id' => 'required',
            'quantity' => 'required',
        ]);

        if($validated){

            $qty = $this->request->quantity;
            $product = Product::find($this->request->product_id);

            if($product){
                if( $qty > $product->qty)
                    return ResponseStatus::failed(["message"=> "Failed to order this product due to unavailability of the stock"]);
                else
                {
                    try
                    {
                        DB::beginTransaction();

                        $product->qty = ($product->qty - $qty);
                        $product->update();

                        DB::commit();

                        return ResponseStatus::success(["message"=> "You have successfully ordered this product"],201);
                    }catch(Exception $e)
                    {
                        DB::rollback();
                        return ResponseStatus::failed(["message"=> $e->getMessage()]);
                    }
                }
            }else{
                return ResponseStatus::failed(["message"=> "Product not exist."]);
            }
        }
    }
}
