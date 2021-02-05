<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Shipping;
use App\Order;
use App\Cart;
use Cookie;
use Stripe;
use App\Attributes;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderShipped;
//Paypal
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;

class PaymentController extends Controller
{
    private $_api_context;
    public function __construct()
    {
        $this->middleware('auth');

        /** PayPal api context **/
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
            $paypal_conf['client_id'],
            $paypal_conf['secret'])
        );
        $this->_api_context->setConfig($paypal_conf['settings']);
    }
    
   
    function payment(Request $request){

        // $order = Order::where('shipping_id', 9)->get();
        // Mail::to(Auth::user()->email)->send(new OrderShipped($order));
        
        if($request->payment == 'card'){

        $shipping = new Shipping;
        $shipping->user_id = Auth::id();
        $shipping->first_name = $request->first_name;
        $shipping->last_name = $request->last_name;
        $shipping->email = $request->email;
        $shipping->phone = $request->phone;
        $shipping->city_id = $request->city_id;
        $shipping->company = $request->company;
        $shipping->address = $request->address;
        $shipping->zipcode = $request->zipcode;
        $shipping->coupon_code = $request->coupon_code;
        $shipping->save();


        $cookie = Cookie::get('cookie_id');
        $carts = Cart::where('cookie_id', $cookie)->get();

        foreach($carts as $cart){

            $order = new Order;
            $order->shipping_id = $shipping->id;
            $order->product_id = $cart->product_id;
            $order->product_unit_price = $cart->product->price;
            $order->quantity = $cart->quantity;
            $order->save();
            $attr = Attributes::where('product_id', $cart->product_id)->where('color_id', $cart->color_id)->where('size_id', $cart->size_id);
            if($attr->exists()){
                $attr->decrement('quantity', $cart->quantity);
            };
            // $cart->decrement('quantity',$cart->quantity);
            $cart->delete();
        }

            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

            Stripe\Charge::create ([
    
                "amount" => 100 * 100,

                "currency" => "usd",

                "source" => $request->stripeToken,

                "description" => "Test payment from ES WEB DEV 2001" 
    
            ]);

            $Payment_Update = Shipping::findOrFail($shipping->id);
            $Payment_Update->payment_status = 1;
            $Payment_Update->save();
            return "Payment Successfully";
        }
        elseif($request->payment == 'paypal'){

            // return "OK";
            $payer = new Payer();
            $payer->setPaymentMethod('paypal');

            $item_1 = new Item();

            $item_1->setName('Product 1')
                ->setCurrency('USD')
                ->setQuantity(1)
                ->setPrice($request->get('amount'));

            $item_list = new ItemList();
            $item_list->setItems(array($item_1));

            $amount = new Amount();
            $amount->setCurrency('USD')
                ->setTotal($request->get('amount'));

            $transaction = new Transaction();
            $transaction->setAmount($amount)
                ->setItemList($item_list)
                ->setDescription('Enter Your transaction description');

            $redirect_urls = new RedirectUrls();
            $redirect_urls->setReturnUrl(URL::route('status'))
                ->setCancelUrl(URL::route('status'));

            $payment = new Payment();
            $payment->setIntent('Sale')
                ->setPayer($payer)
                ->setRedirectUrls($redirect_urls)
                ->setTransactions(array($transaction));            
            try {
                $payment->create($this->_api_context);
            } catch (\PayPal\Exception\PPConnectionException $ex) {
                if (\Config::get('app.debug')) {
                    \Session::put('error','Connection timeout');
                    return Redirect::route('paywithpaypal');                
                } else {
                    \Session::put('error','Some error occur, sorry for inconvenient');
                    return Redirect::route('paywithpaypal');                
                }
            }

            foreach($payment->getLinks() as $link) {
                if($link->getRel() == 'approval_url') {
                    $redirect_url = $link->getHref();
                    break;
                }
            }
            
            Session::put('paypal_payment_id', $payment->getId());

            if(isset($redirect_url)) {            
                return Redirect::away($redirect_url);
            }

            \Session::put('error','Unknown error occurred');
            return Redirect::route('paywithpaypal');
        
        }
        elseif($request->payment == 'bank'){
            return "Bank";
        }
        elseif($request->payment == 'Cash'){
            return "Cash";
        }
        else{
            return "Payment Select Koro";
        }
    }

    public function getPaymentStatus(Request $request)
    {        
        $payment_id = Session::get('paypal_payment_id');

        Session::forget('paypal_payment_id');
        if (empty($request->input('PayerID')) || empty($request->input('token'))) {
            \Session::put('error','Payment failed');
            return Redirect::route('paywithpaypal');
        }
        $payment = Payment::get($payment_id, $this->_api_context);        
        $execution = new PaymentExecution();
        $execution->setPayerId($request->input('PayerID'));        
        $result = $payment->execute($execution, $this->_api_context);
        
        if ($result->getState() == 'approved') {         
            \Session::put('success','Payment success !!');
            return Redirect::route('paywithpaypal');
        }

        \Session::put('error','Payment failed !!');
		return Redirect::route('paywithpaypal');
    }
}
