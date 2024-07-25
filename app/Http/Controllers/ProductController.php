<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\inquiry;

use App\newsletter;
use App\Program;
use App\imagetable;
use SoapClient;
use App\Product;
use App\Category;
use App\Banner;
use App\ProductAttribute;
use DB;
use View;
use Session;
use App\Http\Traits\HelperTrait;
use App\orders;
use App\orders_products;
use Illuminate\Contracts\Session\Session as SessionSession;

class ProductController extends Controller
{
	use HelperTrait;
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	// use Helper;

	public function __construct()
	{
		//$this->middleware('auth');
		$logo = imagetable::select('img_path')
			->where('table_name', '=', 'logo')
			->first();

		$favicon = imagetable::select('img_path')
			->where('table_name', '=', 'favicon')
			->first();

		View()->share('logo', $logo);
		View()->share('favicon', $favicon);
		//View()->share('config',$config);
	}

	public function index()
	{
		$products = new Product;
		if (isset($_GET['q']) && $_GET['q'] != '') {

			$keyword = $_GET['q'];

			$products = $products->where(function ($query)  use ($keyword) {
				$query->where('product_title', 'like', $keyword);
			});
		}
		$products = $products->orderBy('id', 'asc')->get();
		return view('products', ['products' => $products]);
	}

	public function productDetail($id)
	{

		$product = new Product;
		$product_detail = $product->where('id', $id)->first();
		$products = DB::table('products')->get()->take(10);
		return view('product_detail', ['product_detail' => $product_detail, 'products' => $products]);
	}

	public function categoryDetail($id)
	{

		$category = new Category;

		$category = DB::table('products')->where('category', '=', $id)->get()->toArray();
		return view('shop.category_detail', ['category' => $category]);
	}


	public function cart()
	{
// dd(Session::get('cart'));
		$page = DB::table('pages')->where('id', 2)->first();
		$cartCount = COUNT(Session::get('cart'));
		$language = Session::get('language');
		$product_detail = DB::table('products')->first();
		if (Session::get('cart') && count(Session::get('cart')) > 0) {

			return view('shop.cart', ['cart' => Session::get('cart'), 'language' => $language, 'product_detail' => $product_detail, 'page' => $page]);
		} else {
			Session::flash('flash_message', 'No Product found');
			Session::flash('alert-class', 'alert-success');
			return redirect('/');
		}
	}

	public function saveCart(Request $request)
    {
        $var_item = $_POST['variation'];
        $result = array();

        $product_detail = DB::table('products')->where('id', $_POST['product_id'])->first();
        $id = isset($_POST['product_id']) ? $_POST['product_id'] : '';
        $qty = isset($_POST['qty']) ? intval($_POST['qty']) : 1;

        $cart = array();
        if (Session::has('cart')) {
            $cart = Session::get('cart');
        }

        $price = $product_detail->price;
//        dump($cart);
//        dd($request->all());

//        $item_already_in_cart = false;
//        $existing_item_index = null;
//        $new_cart = $cart;
//        foreach ($new_cart as $key => $item) {
//            if ($item['id'] == $request->product_id) {
//                $item_already_in_cart = true;
//                $existing_item_index = $key;
//                break;
//            }
//        }

//        if($item_already_in_cart && !is_null($existing_item_index)) {
//            $unit_price = floatval($new_cart[$existing_item_index]['price']) / floatval($new_cart[$existing_item_index]['qty']);
//            $new_cart[$existing_item_index]['qty'] = $qty;
//            $new_cart[$existing_item_index]['price'] = $qty * $unit_price;
//
//            // Update the cart session
//            Session::put('cart', $cart);
//
//            // Set flash message
//            Session::flash('flash_message', 'Product Added to Cart');
//            Session::flash('alert-class', 'alert-success');
//
//            return back()->with('message', 'Product Added to Cart!');
//        } else {
            if ($id != "" && intval($qty) > 0) {
                // Check if the product already exists in the cart
                $existingItem = collect($cart)->where('id', $id)->first();

                if ($existingItem) {
                    // Generate a unique cart ID for the new item
                    $cartId = $id;
                } else {
                    $cartId = $id;
//                    $cartId = $id . '_' . uniqid();
                }

                $productFirstrow = Product::where('id', $id)->first();

                // Add the new item to the cart
                $quantity = $existingItem ? strval(intval($cart[$cartId]['qty']) + $qty) : $qty;

                $cart[$cartId]['id'] = $id;
                $cart[$cartId]['name'] = $productFirstrow->product_title;
                $cart[$cartId]['delivery_charges'] = $productFirstrow->delivery_charges;
                $cart[$cartId]['qty'] = $quantity;
                $cart[$cartId]['price'] = $productFirstrow->price;
                $cart[$cartId]['env_fee'] = $productFirstrow->env_fee ?? '';
                $cart[$cartId]['date_range'] = $request->daterange_start . ' ' . $request->daterange_end;

                // Update the cart session
                Session::put('cart', $cart);

                // Set flash message
                Session::flash('flash_message', 'Product Added to Cart');
                Session::flash('alert-class', 'alert-success');

                return back()->with('message', 'Product Added to Cart!');
            } else {
                Session::flash('flash_message', 'Sorry! You cannot proceed with 0 quantity');
                Session::flash('alert-class', 'alert-success');
                return back();
            }
//        }

    }
	public function updateCart(Request $request)
	{
		$cart = Session::get('cart');

        // dd($cart);
		$pro_id = $_POST['product_id'];
		// dd($_POST['row']);
        $qty = $_POST['qty'];
		$count = 0;
// 		if (sizeof($_POST['row']) >= 1) {
// 			foreach ($cart as $key => $value) {
// 				foreach ($value as $key_item => $value_item) {

//                     $key_final = (int)$value_item;
//                     if($key == $key_final){

//                         $productFirstrow = Product::where('id', $key_final)->first();
//                         // dump($productFirstrow);
//                         $cart[$pro_id]['id'] = $productFirstrow->id;
//                         $cart[$pro_id]['name'] = $productFirstrow->product_title;
//                         $cart[$pro_id]['price'] = $productFirstrow->price;
//                         $cart[$pro_id]['qty'] = (int)($_POST['row'][$count]);


//                     }
//                     Session::put('cart', $cart);
// 				}
// 				$count = $count + 1;
// 			}
// 		}
        if ($request->daterange_start && $request->daterange_end) {
            Session::forget('daterange');
            $date_range = '['.$request->daterange_start.', '.$request->daterange_end.']';
            Session::put('daterange', $date_range);
        }




		 $productFirstrow = Product::where('id', $pro_id)->first();
		 $cart[$pro_id]['id'] = $pro_id;
		 $cart[$pro_id]['name'] = $productFirstrow->product_title;
		 $cart[$pro_id]['delivery_charges'] = $productFirstrow->delivery_charges;
		 $cart[$pro_id]['price'] = $productFirstrow->price;
		 $cart[$pro_id]['qty'] = $qty;
        $cart[$pro_id]['date_range'] = $request->daterange_start . ' ' . $request->daterange_end;


		// $variation_total = 0;
		// foreach ($cart[$pro_id]['variation'] as $key => $value) {
		// 	$variation_total += $value['attribute_price'];
		// }

		// $cart[$pro_id]['variation_price'] = $variation_total * $qty;


		Session::put('cart', $cart);
		Session::put('subs', $request->subs ?? 0);
        // dd(Session::get('cart'));
		Session::flash('message', 'Your Cart Updated Successfully');
		Session::flash('alert-class', 'alert-success');
		return view('shop.checkout');
	}


    public function removeCart($cartId)
    {
        if ($cartId) {
            $cart = session()->get('cart', []);

            if (array_key_exists($cartId, $cart)) {
                unset($cart[$cartId]);
                session()->put('cart', $cart);

                // Remove 'daterange' session variable
                session()->forget('daterange');

                // Set flash message
                session()->flash('flash_message', 'Product item removed successfully');
                session()->flash('alert-class', 'alert-success');

                return back()->with('message', 'Product item removed successfully!');
            }
        }

        // If $cartId is empty or item not found in the cart
        session()->flash('flash_message', 'Failed to remove product item');
        session()->flash('alert-class', 'alert-danger');
        return back()->with('error', 'Failed to remove product item');
    }

	public function shop(Request $request)
	{
		$page = DB::table('pages')->where('id', 2)->first();
        $search = $request->input('search');

    // Use a like query to search for products with titles containing the search term
    $products = Product::where('product_title', 'like', '%' . $search . '%')->get();

		// $shops = DB::table('products')
		// 	->join('categories', 'products.category', '=', 'categories.id')
		// 	->select('products.*', 'categories.name as category_title')
		// 	->get();


		return view('shop.shop', compact('page','products'));
	}

	public function shopDetail($id)
	{

		$product = new Product;
		$product_detail = $product->where('id', $id)->first();
		$att_model = ProductAttribute::groupBy('attribute_id')->where('product_id', $id)->get();
		$att_id = DB::table('product_attributes')->where('product_id', $id)->get();
		$shops = DB::table('products')
			->join('categories', 'products.category', '=', 'categories.id')
			->select('products.*', 'categories.name as category_title')->take(3)->get();
            $productimages = DB::table('product_imagess')->where('product_id',$id)->get();



		return view('shop.detail', compact('page','product_detail','productimages', 'shops', 'att_id', 'att_model'));
	}


	public function invoice($id)
	{

		$order_id = $id;
		$order = orders::where('id', $order_id)->first();
		$order_products = orders_products::where('orders_id', $order_id)->get();

		return view('account.invoice')->with('title', 'Invoice #' . $order_id)->with(compact('order', 'order_products'))->with('order_id', $order_id);;
	}

	public function checkout()
	{

		// dd(Session::get('cart1'));

		if (Session::get('cart') && count(Session::get('cart')) > 0) {
			$countries = DB::table('countries')
				->get();
            dd(Session::get('cart'));
			return view('checkout', ['cart' => Session::get('cart'), 'countries' => $countries]);
		} else {
			Session::flash('flash_message', 'No Product found');
			Session::flash('alert-class', 'alert-success');
			return redirect('/');
		}
	}


	public function language()
	{
		$languages = $_POST['id'];

		Session::put('language', $languages);

		Session::put('is_select_dropdown', 1);
		// Session::put('language',$languages);
		// $test = Session::get('language');

		// Session::put('test',$test);

		//return redirect('shop-detail/1', ['test'=>$test]);
	}

	public function shipping(Request $request)
	{

		$PostalCode = $request->country; // Zipcode you are shipping To

		define("ENV", "demo"); // demo OR live

		if (ENV == 'demo') {
			$client = new SoapClient("https://staging.postaplus.net/APIService/PostaWebClient.svc?wsdl");
			$Password =  '123456';
			$ShipperAccount =  'DXB51487';
			$UserName =  'DXB51487';
			$CodeStation =  'DXB';
		} else {
			$client = new SoapClient("https://etrack.postaplus.net/APIService/PostaWebClient.svc?singleWsdl");
			$Password =  '';
			$ShipperAccount =  '';
			$UserName =  '';
			$CodeStation =  '';
		}

		$params = array(
			'ShipmentCostCalculation' => array(
				'CI' => array(
					'Password' => $Password,
					'ShipperAccount' => $ShipperAccount,
					'UserName' => $UserName,
					'CodeStation' => $CodeStation,
				),
				"OriginCountryCode" => 'AE',
				"DestinationCountryCode" => $PostalCode,
				"RateSheetType" => 'DOC',
				"Width" => 1,
				"Height" => 1,
				"Length" => 1,
				"ScaleWeight" => 1,
			),
		);


		try {

			$d = $client->__SoapCall("ShipmentCostCalculation", $params);
			$d = json_decode(json_encode($d), true);

			if (isset($d['ShipmentCostCalculationResult']['Message']) and ($d['ShipmentCostCalculationResult']['Message'] == 'SUCCESS')) {
				$status = true;
				$rate = $d['ShipmentCostCalculationResult']['Amount'];
			} else {
				$status = false;
				$messgae = $d['ShipmentCostCalculationResult']['Message'];
			}
		} catch (SoapFault $exception) {
			$status = false;
			$messgae = "Error Found Please try Again";
		}

		//if($status):
		//	echo $rate;
		//else:
		//	echo $messgae;
		//endif;

		//}
		//$cart = Session::get('cart');



		if ($status) {

			$cart = Session::get('cart');
			$cart['shipping'] = $rate;
			//$cart['shipping_address'] = $_POST['shipping_address'];
			Session::put('cart', $cart);

			// return view('shop.cart', ['rate'=> $rate, 'cart'=> $cart]);
			return redirect('/cart');
		} else {
			Session::flash('flash_message', 'Error');
			Session::flash('alert-class', 'alert-success');
			return view('shop.cart', ['messgae' => $messgae]);
		}
		return view('shop.cart', ['messgae' => $messgae, 'cart' => $cart]);
	}


    public function direct_checkout(Request $request)
	{

        $date_range = Session::put('date_range', $languages);

        dd(Session::get('cart'));




	}
}
