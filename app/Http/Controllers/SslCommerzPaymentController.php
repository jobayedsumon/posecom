<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Order;
use App\OrderDetails;
use App\Product;
use Illuminate\Http\Request;
use App\Library\SslCommerz\SslCommerzNotification;
use Illuminate\Support\Facades\DB;

class SslCommerzPaymentController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth:customer')->only([
            'exampleHostedCheckout', 'index',
        ]);
    }

    public function exampleEasyCheckout()
    {
        return view('exampleEasycheckout');
    }

    public function exampleHostedCheckout()
    {
        if (session()->has('shipping_cost') && session()->has('cart')) {
            return view('frontend.checkout');
        } else {
            $cart = session()->get('cart');
            return redirect('/cart')->with('msg', 'Please add products and choose shipping location');
        }

    }

    public function index(Request $request)
    {

        if (!session()->has('cart')) {
            return redirect('/');
        }

        $customer = auth('customer')->user();

        $total = session()->get('cart_total');
        $cart = session()->get('cart');
        $count = count($cart) ?? [];

        if ($count <= 0 || $total <= 0) {
            session()->put('payment_message', 'An error occurred while processing your order!');
            session()->forget(['cart', 'cart_total', 'couponCart', 'cart_items_count', 'cart_sub_total', 'cart_items_quantity']);
            return view('frontend.payment');
        }

        if ($request->payment_method != 'ssl' && $request->payment_method != 'cod') {
            session()->put('payment_message', 'An error occurred while processing your order!');
            session()->forget(['cart', 'cart_total', 'couponCart', 'cart_items_count', 'cart_sub_total', 'cart_items_quantity']);
            return view('frontend.payment');
        }

        $billing_address = $request->street . '+';
        $billing_address .= $request->city . '+';
        $billing_address .= $request->district . '+';
        $billing_address .= ucfirst($request->division);

        if ($request->shipping_address) {
            $request->validate([
               'shipping_street' => 'required',
               'shipping_city' => 'required',
               'shipping_district' => 'required',
               'shipping_division' => 'required',
            ]);
            $shipping_address = $request->shipping_street . '+';
            $shipping_address .= $request->shipping_city . '+';
            $shipping_address .= $request->shipping_district . '+';
            $shipping_address .= ucfirst($request->shipping_division);
        } else {
            $shipping_address = $billing_address;
        }

        $customer->update([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'billing_address' => $billing_address,
            'shipping_address' => $shipping_address,

        ]);

        $notes = $request->notes;



        # Here you have to receive all the order data to initate the payment.
        # Let's say, your oder transaction informations are saving in a table called "orders"
        # In "orders" table, order unique identity is "transaction_id". "status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

        $post_data = array();
        $post_data['total_amount'] = $total; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] =  $request->name ?? "";
        $post_data['cus_email'] =  $request->email ?? "";
        $post_data['cus_add1'] = $request->street ?? "";
        $post_data['cus_add2'] = $request->street ?? "";
        $post_data['cus_city'] =  $request->city ?? "";
        $post_data['cus_state'] = $request->city ?? "";
        $post_data['cus_postcode'] = $request->post ?? "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] =  $request->phone_number ?? "";;
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] =  $request->shipping_name ?? $request->name;
        $post_data['ship_add1'] =  $request->shipping_street ?? $request->street;
        $post_data['ship_add2'] = $request->shipping_street ?? $request->street;
        $post_data['ship_city'] = $request->shipping_city ?? $request->city;
        $post_data['ship_state'] = $request->shipping_city ?? $request->city;
        $post_data['ship_postcode'] = $request->shipping_post ?? $request->post;
        $post_data['ship_phone'] = $request->shipping_phone_number ?? $request->phone_number;
        $post_data['ship_email'] = $request->shipping_email?? $request->email;
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "AmarShop";
        $post_data['product_category'] = "AmarShop";
        $post_data['product_profile'] = "AmarShop";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

        #Before  going to initiate the payment order status need to insert or update as Pending.
        $update_product = DB::table('orders')
            ->where('transaction_id', $post_data['tran_id'])
            ->updateOrInsert([
                'name' => $post_data['ship_name'],
                'email' => $post_data['ship_email'],
                'phone' => $post_data['ship_phone'],
                'amount' => $post_data['total_amount'],
                'status' => 'Pending',
                'address' => $shipping_address,
                'transaction_id' => $post_data['tran_id'],
                'currency' => $post_data['currency'],
                'customer_id' => $customer->id,
                'notes' => $notes,
                'created_at' => now(),
            ]);

        $order = Order::where('transaction_id', $post_data['tran_id'])->first();

        for ($i = 0; $i < $count; $i++) {
            OrderDetails::create([
                'order_id' => $order->id,
                'product_id' => $cart[$i]['product_id'],
                'count' => $cart[$i]['count'],
                'color_id' => $cart[$i]['color_id'],
                'size_id' => $cart[$i]['size_id'],
            ]);

            $product = Product::find($cart[$i]['product_id']);

            $product->quantity -= $cart[$i]['count'];

            $product->save();
        }

        switch ($request->payment_method)
        {
            case 'cod':
                $order->update([
                   'type' => 'cod'
                ]);
                session()->put('payment_message', 'Order placed successfully!');
                session()->forget(['cart', 'cart_total', 'couponCart', 'cart_items_count', 'cart_sub_total', 'cart_items_quantity']);
                return view('frontend.payment');
                break;
            case 'ssl':
                $order->update([
                    'type' => 'ssl'
                ]);

                $sslc = new SslCommerzNotification();
                # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
                $payment_options = $sslc->makePayment($post_data, 'hosted');

                if (!is_array($payment_options)) {
                    print_r($payment_options);
                    $payment_options = array();
                }
                break;
            default:
                session()->put('payment_message', 'An error occurred while processing your order!');
                session()->forget(['cart', 'cart_total', 'couponCart', 'cart_items_count', 'cart_sub_total', 'cart_items_quantity']);
                return view('frontend.payment');
        }
    }

    public function payViaAjax(Request $request)
    {

        # Here you have to receive all the order data to initate the payment.
        # Lets your oder trnsaction informations are saving in a table called "orders"
        # In orders table order uniq identity is "transaction_id","status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

        $post_data = array();
        $post_data['total_amount'] = '10'; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = 'Customer Name';
        $post_data['cus_email'] = 'customer@mail.com';
        $post_data['cus_add1'] = 'Customer Address';
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = '8801XXXXXXXXX';
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "AmarShop";
        $post_data['product_category'] = "AmarShop";
        $post_data['product_profile'] = "AmarShop";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";


        #Before  going to initiate the payment order status need to update as Pending.
        $update_product = DB::table('orders')
            ->where('transaction_id', $post_data['tran_id'])
            ->updateOrInsert([
                'name' => $post_data['cus_name'],
                'email' => $post_data['cus_email'],
                'phone' => $post_data['cus_phone'],
                'amount' => $post_data['total_amount'],
                'status' => 'Pending',
                'address' => $post_data['cus_add1'],
                'transaction_id' => $post_data['tran_id'],
                'currency' => $post_data['currency']
            ]);

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'checkout', 'json');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }

    }

    public function success(Request $request)
    {

        session()->put('payment_message', 'Transaction is Successful');

        $tran_id = $request->input('tran_id');
        $amount = $request->input('amount');
        $currency = $request->input('currency');

        $sslc = new SslCommerzNotification();

        #Check order status in order tabel against the transaction id or order id.
        $order_detials = DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_detials->status == 'Pending') {
            $validation = $sslc->orderValidate($tran_id, $amount, $currency, $request->all());

            if ($validation == TRUE) {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel. Here you need to update order status
                in order table as Processing or Complete.
                Here you can also sent sms or email for successfull transaction to customer
                */
                $update_product = DB::table('orders')
                    ->where('transaction_id', $tran_id)
                    ->update(['status' => 'Processing']);

               $payment_message = session()->get('payment_message') . "\nTransaction is successfully Completed";
               session()->put('payment_message', $payment_message);

//                echo "<br >Transaction is successfully Completed";
            } else {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel and Transation validation failed.
                Here you need to update order status as Failed in order table.
                */
                $update_product = DB::table('orders')
                    ->where('transaction_id', $tran_id)
                    ->update(['status' => 'Failed']);

//                echo "validation Fail";
                session()->put('payment_message', 'Validation Fail');
            }
        } else if ($order_detials->status == 'Processing' || $order_detials->status == 'Complete') {
            /*
             That means through IPN Order status already updated. Now you can just show the customer that transaction is completed. No need to udate database.
             */

            $payment_message = session()->get('payment_message') . "\nTransaction is successfully Completed";
            session()->put('payment_message', $payment_message);

        } else {
            #That means something wrong happened. You can redirect customer to your product page.
//            echo "Invalid Transaction";
            session()->put('payment_message', 'Invalid Transaction');
        }

        return view('frontend.payment');


    }

    public function fail(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_detials = DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_detials->status == 'Pending') {
            $update_product = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 'Failed']);
            echo "Transaction is Falied";
        } else if ($order_detials->status == 'Processing' || $order_detials->status == 'Complete') {
            echo "Transaction is already Successful";
        } else {
            echo "Transaction is Invalid";
        }

    }

    public function cancel(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_detials = DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_detials->status == 'Pending') {
            $update_product = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 'Canceled']);
            echo "Transaction is Cancel";
        } else if ($order_detials->status == 'Processing' || $order_detials->status == 'Complete') {
            echo "Transaction is already Successful";
        } else {
            echo "Transaction is Invalid";
        }


    }

    public function ipn(Request $request)
    {
        #Received all the payement information from the gateway
        if ($request->input('tran_id')) #Check transation id is posted or not.
        {

            $tran_id = $request->input('tran_id');

            #Check order status in order tabel against the transaction id or order id.
            $order_details = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->select('transaction_id', 'status', 'currency', 'amount')->first();

            if ($order_details->status == 'Pending') {
                $sslc = new SslCommerzNotification();
                $validation = $sslc->orderValidate($tran_id, $order_details->amount, $order_details->currency, $request->all());
                if ($validation == TRUE) {
                    /*
                    That means IPN worked. Here you need to update order status
                    in order table as Processing or Complete.
                    Here you can also sent sms or email for successful transaction to customer
                    */
                    $update_product = DB::table('orders')
                        ->where('transaction_id', $tran_id)
                        ->update(['status' => 'Processing']);

                    echo "Transaction is successfully Completed";
                } else {
                    /*
                    That means IPN worked, but Transation validation failed.
                    Here you need to update order status as Failed in order table.
                    */
                    $update_product = DB::table('orders')
                        ->where('transaction_id', $tran_id)
                        ->update(['status' => 'Failed']);

                    echo "validation Fail";
                }

            } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {

                #That means Order status already updated. No need to udate database.

                echo "Transaction is already successfully Completed";
            } else {
                #That means something wrong happened. You can redirect customer to your product page.

                echo "Invalid Transaction";
            }
        } else {
            echo "Invalid Data";
        }
    }

}
