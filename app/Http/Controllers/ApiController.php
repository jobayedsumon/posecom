<?php

namespace App\Http\Controllers;

use App\AmarCare;
use App\Brand;
use App\Category;
use App\Coupon;
use App\Customer;
use App\Deal;
use App\FeaturedProduct;
use App\Library\SslCommerz\SslCommerzNotification;
use App\Order;
use App\OrderDetails;
use App\Product;
use App\Sale;
use App\Size;
use App\Slider;
use App\SubCategory;
use App\Tag;
use App\Wishlist;
use Carbon\Carbon;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\JWTAuth;

class ApiController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:customer-api')->only([
            'wishlist', 'my_account', 'update_account', 'update_address', 'logout',
            'add_wishlist', 'remove_wishlist', 'cash_on_delivery', 'online_payment',
            'rate_product'
        ]);
    }


    public function products()
    {
        return Product::with(['category', 'sale', 'specifications', 'colors', 'sizes', 'tags', 'comments']);
    }
    //
    public function sliders()
    {
        $sliders = Slider::latest()->get();

        if ($sliders) {
            return response()->json($sliders, 200);
        } else {
            return response()->json('Sliders not found!', 404);
        }


    }

    public function shops()
    {
        $shops = Category::with('sub_categories')->get();

        if ($shops) {
            return response()->json($shops, 200);
        } else {
            return response()->json('Shops not found!', 404);
        }


    }

    public function new_arrivals()
    {

        $newProducts = $this->products()->whereDate('created_at', Carbon::now()->subDays(7))->get();

        if ($newProducts->count() <= 0) {
            $newProducts = $this->products()->latest()->limit(20)->get();
        }

        foreach($newProducts as $p){
            $p->description = strip_tags($p->description);
            $p->short_description = strip_tags($p->short_description);
        }

        if ($newProducts) {
            return response()->json($newProducts, 200);
        } else {
            return response()->json('New products not found!', 404);
        }


    }

    public function sub_shop_products($id)
    {
        $products = $this->products()->where('sub_category_id', $id)
            ->with(['category', 'sale', 'specifications', 'colors', 'sizes', 'tags', 'comments'])
            ->get();

        foreach($products as $p){
            $p->description = strip_tags($p->description);
            $p->short_description = strip_tags($p->short_description);
        }

        if ($products) {
            return response()->json($products, 200);
        } else {
            return response()->json('Products not found!', 404);
        }

    }

    public function featured_products()
    {
        $featuredCatIds = FeaturedProduct::all()->pluck('category_id')->unique();
        $featuredProdIds = FeaturedProduct::all()->pluck('product_id');
        $featuredCategories = Category::whereIn('id', $featuredCatIds)->get();
        $featuredProducts = $this->products()->whereIn('id', $featuredProdIds);

        $data = [];

        foreach ($featuredCategories as $i => $fc) {
            $data[$i]['categoryName'] = $fc->name;
            $data[$i]['Products'] = $fc->products()->whereIn('id', $featuredProdIds)
                ->with(['category', 'sale', 'specifications', 'colors', 'sizes', 'tags', 'comments'])
                ->get();
        }

        foreach ($data as $d) {
            foreach ($d['Products'] as $p) {
                $p->description = strip_tags($p->description);
                $p->short_description = strip_tags($p->short_description);
            }
        }

        if ($data) {
            return response()->json($data, 200);
        } else {
            return response()->json('Featured products not found!', 404);
        }

    }

    public function search_products($query)
    {

        $products = $this->products()->where('name', 'LIKE', '%'.$query.'%')->get();

        foreach($products as $p){
            $p->description = strip_tags($p->description);
            $p->short_description = strip_tags($p->short_description);
        }

        if ($products) {
            return response()->json($products, 200);
        } else {
            return response()->json('Search products not found!', 404);
        }
    }

    public function tag_search($tagName)
    {
        $tag = Tag::where('name', $tagName)->first();

        $products = $tag->products()->with(['category', 'sale', 'specifications', 'colors', 'sizes', 'tags', 'comments'])->get();

        foreach($products as $p){
            $p->description = strip_tags($p->description);
            $p->short_description = strip_tags($p->short_description);
        }

        if ($products) {
            return response()->json($products, 200);
        } else {
            return response()->json('Tag products not found!', 404);
        }

    }

    public function wishlist()
    {
        $customer = auth('customer-api')->user();

        $prodIds = $customer->wishlist()->pluck('product_id');
        $wishIds = $customer->wishlist()->pluck('id');

        $wishlist = $this->products()->whereIn('id', $prodIds)->get();

        foreach($wishlist as $i => $p) {
            $p->description = strip_tags($p->description);
            $p->short_description = strip_tags($p->short_description);
            $p->wish_id = $wishIds[$i];
        }

        if ($wishlist) {
            return response()->json($wishlist, 200);
        } else {
            return response()->json('Wishlist products not found!', 404);
        }

    }

    public function amarcare()
    {
        $vlogs = Category::with('vlogs')->get();

        foreach ($vlogs as $vlog) {
            foreach ($vlog->vlogs as $v) {
                $v->description = strip_tags($v->description);
            }
        }

        if ($vlogs) {
            return response()->json($vlogs, 200);
        } else {
            return response()->json('Vlogs not found!', 404);
        }


    }

    public function filter_product(Request $request)
    {
        $brand = $request->brand_id;
        $size = $request->size_id;

        $minPrice = $request->min_amount;
        $maxPrice = $request->max_amount;

        $data = $this->products()->whereBetween('price', [$minPrice, $maxPrice]);

        if ($brand != -1) {
            $prodIds = Brand::find($brand)->products()->pluck('id');
            $data->whereIn('id', $prodIds);
        }

        if ($size != -1) {
            $prodIds = Size::find($size)->products()->pluck('id');
            $data->whereIn('id', $prodIds);
        }

        $data = $data->get();

        foreach($data as $p){
            $p->description = strip_tags($p->description);
            $p->short_description = strip_tags($p->short_description);
        }

        if ($data) {
            return response()->json($data, 200);
        } else {
            return response()->json('Filter products not found!', 404);
        }

    }

    public function sale_products()
    {
        $saleProdIds = Sale::latest()->where('expire', '>', now())->pluck('product_id');

        $saleProducts = $this->products()->whereIn('id', $saleProdIds)->get();

        foreach($saleProducts as $p){
            $p->description = strip_tags($p->description);
            $p->short_description = strip_tags($p->short_description);
        }

        if ($saleProducts) {
            return response()->json($saleProducts, 200);
        } else {
            return response()->json('Sale products not found!', 404);
        }
    }

    public function deal_products()
    {
        $dealProdIds = Deal::latest()->where('expire', '>', now())->pluck('product_id');

        $dealProducts = $this->products()->whereIn('id', $dealProdIds)->get();

        foreach($dealProducts as $p){
            $p->description = strip_tags($p->description);
            $p->short_description = strip_tags($p->short_description);
        }

        if ($dealProducts) {
            return response()->json($dealProducts, 200);
        } else {
            return response()->json('Deal products not found!', 404);
        }
    }

    public function my_account(Request $request)
    {
        $customer = auth('customer-api')->user();


        foreach($customer->orders as $order){
            $order->notes = strip_tags($order->notes);
        }

        if ($customer) {
            return response()->json($customer, 200);
        } else {
            return response()->json('Customer not found!', 404);
        }

    }

    public function filter_attributes()
    {
        $brands = Brand::all();
        $sizes = Size::all();
        $tags = Tag::all();

        return response()->json([
            'brands' => $brands,
            'sizes' => $sizes,
            'tags' => $tags
        ], 200);
    }

    public function random_products()
    {
        $products = $this->products()->limit(6)->get();

        foreach($products as $p){
            $p->description = strip_tags($p->description);
            $p->short_description = strip_tags($p->short_description);
        }

        if ($products) {
            return response()->json($products, 200);
        } else {
            return response()->json('Random products not found!', 404);
        }

    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => 'Login failed'], 404);
        }

        try {
            if (! $token = auth('customer-api')->attempt($request->all())) {
                return response()->json(['msg' => 'Credentials not found!'], 404);
            }
        } catch (JWTException $e) {
            return response()->json(['msg' => 'Token creation failed!'], 404);
        }

        return response()->json([
            'customer' => \auth('customer-api')->user(),
            'token' => $token,
            'expire' => auth('customer-api')->factory()->getTTL() * 60
        ], 200);
    }

    public function social_login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'email|required',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => 'Login failed'], 404);
        }

        $name = $request->input('name');
        $email = $request->input('email');

        // check if they're an existing user
        $existingCustomer = Customer::where('email', $email)->first();

        if($existingCustomer){
            // log them in
            $token = auth('customer-api')->login($existingCustomer, true);
        } else {
            // create a new user
            $newCustomer = Customer::create([
               'name' => $name,
               'email' => $email,
               'password' => bcrypt('amarshop'),
               'phone_number' => '',
               'birthdate' => null,
               'remember_token' => null,
               'shipping_address' => null,
               'billing_address' => null,
               'total_purchase_amount' => null,
               'total_purchase_count' => null,
               'receive_offer' => null,
               'newsletter' => null,
            ]);

            $token = auth('customer-api')->login($newCustomer, true);
        }

        if (!$token) {
            return response()->json(['msg' => 'Credentials not found!'], 404);
        }

        return response()->json([
            'customer' => \auth('customer-api')->user(),
            'token' => $token,
            'expire' => auth('customer-api')->factory()->getTTL() * 60
        ], 200);

    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'email|required|unique:customers',
            'password' => 'required|confirmed|min:6',
            'name' => 'required',
            'phone_number' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => 'Registration failed'], 404);
        }

        $data = $request->validate([
            'email' => 'email|required|unique:customers',
            'password' => 'required|confirmed|min:6',
            'name' => 'required',
            'phone_number' => 'required',
        ]);

        $customer = Customer::create([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'name' => $data['name'],
            'phone_number' => $data['phone_number'],
        ]);

        if ($customer) {
            return response()->json(['msg' => 'Registration successful'], 200);
        } else {
            return response()->json('Registration failed', 404);
        }

    }

    public function logout()
    {
        auth('customer-api')->logout();

        return response()->json(['msg' => 'Logged out successfully'], 200);
    }

    public function update_account(Request $request)
    {

        $customer = auth('customer-api')->user();

        $validator = Validator::make($request->all(), [
            'email' => 'unique:customers,email,'.$customer->id,
            'password' => 'required|min:6',
            'name' => 'required',
            'phone_number' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => 'Update failed'], 404);
        }

        $receive_offer = $request->receive_offer ? true : false;
        $newsletter = $request->newsletter ? true : false;

        $response = $customer->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => bcrypt($request->password),
            'birthdate' => $request->birthdate,
            'receive_offer' => $receive_offer,
            'newsletter' => $newsletter,

        ]);

        if ($response) {
            return response()->json([
                'customer' => $customer,
                'msg'=>'Account updated successfully'
            ], 200);
        } else {
            return response()->json('Update failed', 404);
        }


    }

    public function update_address(Request $request)
    {

        $customer = auth('customer-api')->user();

        $billing_address = $request->street . '+';
        $billing_address .= $request->city . '+';
        $billing_address .= $request->district . '+';
        $billing_address .= ucfirst($request->division);

        $customer->update([
            'billing_address' => $billing_address,
        ]);

        if ($customer) {
            return response()->json([
                'customer' => $customer,
                'msg'=>'Account updated successfully'
            ], 200);
        } else {
            return response()->json('Update failed', 404);
        }
    }

    public function add_wishlist(Request $request)
    {
        $customer = auth('customer-api')->user();

        $wishlist = Wishlist::firstOrCreate([
            'customer_id' => $customer->id,
            'product_id' => $request->productId
        ]);

        $wishlistCount = Wishlist::all()->count();

        if ($wishlist) {
            return response()->json([
                'msg' => 'Product added to wishlist',
                'wishlistCount' => $wishlistCount
            ], 200);
        } else {
            return response()->json('Add to wishlist failed', 404);
        }

    }

    public function remove_wishlist(Request $request)
    {
        $wishId = $request->wish_id;
        $wishlist = Wishlist::findOrFail($wishId);
        $response = $wishlist->delete();

        $wishlistCount = Wishlist::all()->count();

        if ($response) {
            return response()->json([
                'msg' => 'Product removed from wishlist',
                'wishlistCount' => $wishlistCount
            ], 200);
        } else {
            return response()->json('Remove from wishlist failed', 404);
        }

    }


    public function cash_on_delivery(Request $request)
    {

        $customer = auth('customer-api')->user();


         $cart = json_decode($request->cart);

         $count = count($cart);

         $total = $request->total;



        if (!$cart) {
            return response()->json([
                'msg' => 'Please add products and choose shipping location'
            ], 404);
        }

        if ($count <= 0 || $total <= 0) {
            return response()->json([
                'msg' => 'An error occurred while processing your order!'
            ], 404);
        }

        if ($request->payment_method != 'cod') {
            return response()->json([
                'msg' => 'An error occurred while processing your order!'
            ], 404);
        }

        $billing_address = $request->street . '+';
        $billing_address .= $request->city . '+';
        $billing_address .= $request->district . '+';
        $billing_address .= ucfirst($request->division);



        if ($request->shipping_address == 'true') {
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
                'product_id' => $cart[$i]->product_id,
                'count' => $cart[$i]->count,
                'color_id' => $cart[$i]->color_id,
                'size_id' => $cart[$i]->size_id,
            ]);

            $product = Product::find($cart[$i]->product_id);

            $product->quantity -= $cart[$i]->count;

            $product->save();
        }

        switch ($request->payment_method)
        {
            case 'cod':
                $order->update([
                    'type' => 'cod'
                ]);

                return response()->json([
                    'msg' => 'Order placed successfully!'
                ], 200);

                break;

            default:

                return response()->json([
                    'msg' => 'An error occurred while processing your order!'
                ], 404);

        }
    }


    public function online_payment(Request $request)
    {

        $customer = auth('customer-api')->user();


        $cart = json_decode($request->cart);

        $count = count($cart);

        $total = $request->total;

        if (!$cart) {
            return response()->json([
                'msg' => 'Please add products and choose shipping location'
            ], 404);
        }

        if ($count <= 0 || $total <= 0) {
            return response()->json([
                'msg' => 'An error occurred while processing your order!'
            ], 404);
        }

        if ($request->payment_method != 'ssl') {
            return response()->json([
                'msg' => 'An error occurred while processing your order!'
            ], 404);
        }

        $billing_address = $request->street . '+';
        $billing_address .= $request->city . '+';
        $billing_address .= $request->district . '+';
        $billing_address .= ucfirst($request->division);



        if ($request->shipping_address == 'true') {
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
        $post_data['total_amount'] = $request->total; # You cant not pay less than 10
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
        $post_data['ship_name'] =  $request->shipping_name ?? $post_data['cus_name'];
        $post_data['ship_add1'] =  $request->shipping_street ?? $post_data['cus_add1'];
        $post_data['ship_add2'] = $request->shipping_street ?? $post_data['cus_add1'];
        $post_data['ship_city'] = $request->shipping_city ?? $post_data['cus_add2'];
        $post_data['ship_state'] = $request->shipping_city ?? $post_data['cus_city'];
        $post_data['ship_postcode'] = $request->shipping_post ?? $post_data['cus_postcode'];
        $post_data['ship_phone'] = $request->shipping_phone_number ?? $post_data['cus_phone'];
        $post_data['ship_email'] = $request->shipping_email?? $post_data['cus_email'];
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
                'product_id' => $cart[$i]->product_id,
                'count' => $cart[$i]->count,
                'color_id' => $cart[$i]->color_id,
                'size_id' => $cart[$i]->size_id,
            ]);

            $product = Product::find($cart[$i]->product_id);

            $product->quantity -= $cart[$i]->count;

            $product->save();
        }


        switch ($request->payment_method)
        {
            case 'ssl':
                $order->update([
                    'type' => 'ssl'
                ]);

                $sslc = new SslCommerzNotification();

                $payment_options = $sslc->makePayment($post_data);

                if (!is_array($payment_options)) {
                    print_r($payment_options);
                    $payment_options = array();
                }

                break;

            default:

                return response()->json([
                    'msg' => 'An error occurred while processing your order!'
                ], 404);

        }
    }

    public function similar_products($shopId)
    {
        $related_products = $this->products()->where('category_id', $shopId)->limit(20)->get();

        foreach ($related_products as $p) {
            $p->description = strip_tags($p->description);
            $p->short_description = strip_tags($p->short_description);
        }

        if ($related_products) {
            return response()->json($related_products, 200);
        } else {
            return response()->json([
                'msg' => 'No related products found!'
            ], 404);
        }
    }

    public function rate_product(Request $request)
    {

        $product = Product::findOrFail($request->product_id);
        $star = $request->star;
        $comment = $request->comment;
        $customer = auth('customer-api')->user();

        $customer->comment($product, $comment, $star);

        $comments = $product->comments;

        return response()->json([
            'comments' => $comments,
        ], 200);

    }

    public function coupon(Request $request)
    {
        $coupon = Coupon::where('code', $request->coupon)->first();

        if (!$coupon) {
            return response()->json([
                'msg' => 'Invalid Coupon',
            ], 404);
        }
        else {
            if ($coupon->expire <= Carbon::now()) {
                return response()->json([
                    'msg' => 'Coupon Expired!',
                ], 404);
            } else {
                $validCoupon = [
                    'code' => $coupon->code,
                    'value' => $coupon->value,
                ];

                return response()->json([
                    'validCoupon' => $validCoupon,
                ], 200);

            }
        }
    }

}
