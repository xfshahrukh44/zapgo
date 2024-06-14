<?php

namespace App\Http\Controllers;
use Hash;
use Illuminate\Http\Request;
use App\inquiry;
use App\newsletter;
use App\Program;
use App\imagetable;
use App\Banner;
use App\Product;
use App\Attributes;
use App\AttributeValue;
use App\ProductAttribute;
use DB;
use View;
use Image;
use File;
use App\orders_products;
use App\orders;
use App\Category;
use App\Models\GetQuote;
use App\Models\Bulkorder;
use App\Models\Location;
use Auth;
use Session;
use App\Http\Traits\HelperTrait;



class LoggedInController extends Controller
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

		// $this->middleware('guest');
        $this->middleware('auth');
        $logo = imagetable::
                     select('img_path')
                     ->where('table_name','=','logo')
                     ->first();
             
		$favicon = imagetable::
                     select('img_path')
                     ->where('table_name','=','favicon')
                     ->first();	 

        View()->share('logo',$logo);
		View()->share('favicon',$favicon);
        //View()->share('config',$config);
    }

	
	public function orders()
    {
		if(Auth::user()->role == 3){
			$productIds = Product::where('user_id', Auth::user()->id)->pluck('id');
			$orders = DB::table('orders')
				->join('orders_products', 'orders.id', '=', 'orders_products.orders_id')
				->whereIn('orders_products.order_products_product_id', $productIds)
				->orderBy('orders.id', 'desc')
				->select('orders.*')
				->get();
		}else{
			$orders = orders::where('orders.user_id', Auth::user()->id)
					->orderBy('orders.id', 'desc')
					->get();
		}

		return view('account.orders',['ORDERS'=>$orders]); 
		
	}

	public function quotes()
    {	
		if(Auth::user()->role == 3){
			$productIds = Product::where('user_id', Auth::user()->id)->pluck('id');
			$quote = DB::table('get_quotes')
				->join('quote_prod_info', 'get_quotes.id', '=', 'quote_prod_info.qoute_id')
				->whereIn('quote_prod_info.product', $productIds)
				->orderBy('get_quotes.id', 'desc')
				->select('get_quotes.*')
				->get();
		}else{
			$quote = GetQuote::where('user_id', Auth::user()->id)
				->orderBy('id', 'desc')
				->get();
		}
		return view('account.quote',['quote'=>$quote]); 
		
	}

	public function view_quotes($id)
    {
		$quote = GetQuote::with('quote_products')->find($id);
		$bulkOrders = Bulkorder::where('qoute_id', $id)->first();
		return view('account.view_quote',['quote'=>$quote, 'bulkOrders' => $bulkOrders]); 
		
	}


	public function view_payment($id)
    {
		$quote = GetQuote::with('quote_products')->find($id);
		return view('account.view_payments',['quote'=>$quote]); 
	}
	

	public function account()
    {

		$orders = orders::where('orders.user_id', Auth::user()->id)
				->orderBy('orders.id', 'desc')
				->get();
		return view('account.index',['ORDERS'=>$orders]); 
		
	}

	public function view_product(Request $request)
	{
		$query = Product::where('user_id', Auth::user()->id);

		if ($request->has('search')) {
			$searchTerm = $request->search;
			$query->where(function($q) use ($searchTerm) {
				$q->where('product_title', 'like', '%' . $searchTerm . '%')
				->orWhere('price', 'like', '%' . $searchTerm . '%')
				->orWhereHas('categorys', function($q) use ($searchTerm) {
					$q->where('name', 'like', '%' . $searchTerm . '%');
				});
			});
		}

		$products = $query->orderBy('id', 'asc')->paginate(10);
		return view('account.view_products', ['products' => $products]);
	}


	public function add_product(Request $request)
	{
		$att = Attributes::all();
		$attval = AttributeValue::all();
		$items = Category::pluck('name', 'id');
		$location = Location::pluck('name','id');
		return view('account.add_products', compact('items', 'att','attval','location'));
	}


	public function store_product(Request $request)
    {
		$this->validate($request, [
			'product_title' => 'required',
			'description' => 'required',
			'price' => 'required',
			'image' => 'required',
			'item_id' => 'required',
			'location_id' => 'required'
		]);

		$product = new product;

		$product->product_title = $request->input('product_title');
		$product->price = $request->input('price');
		$product->description = $request->input('description');
		$product->category = $request->input('item_id');
		$product->location_id = $request->input('location_id');
		$product->delivery_charges = $request->input('delivery_charges');
		$product->stock_inventory = $request->input('stock_inventory');
		$product->user_id = Auth::user()->id;
		$file = $request->file('image');

		//make sure you have an image folder inside your public directory
		$filename = time() . '_' . $file->getClientOriginalName();
		$path = $file->move(public_path('uploads/products'), $filename);

		// Assuming $product is an instance of the Product model
		$product->image = 'uploads/products/' . $filename;
		$product->save();

		if ($request->hasFile('images')) {
			$photos=request()->file('images');
			foreach ($request->file('images') as $photo) {
				$filename = time() . '_' . $photo->getClientOriginalName();
				$path = $photo->move(public_path('uploads/products'), $filename);

				DB::table('product_imagess')->insert([

					['image' => 'uploads/products/' . $filename, 'product_id' => $product->id]

				]);

			}

		}
		$attval = $request->attribute;

		for($i = 0; $i < count($attval); $i++)
		{
			$product_attributes = new ProductAttribute;
			$product_attributes->attribute_id = $attval[$i]['attribute_id'];
			$product_attributes->value = $attval[$i]['value'];
			$product_attributes->price = $attval[$i]['v-price'];
			$product_attributes->qty = $attval[$i]['qty'];
			$product_attributes->product_id = $product->id;

			$product_attributes->save();
		}

		return redirect('view-product')->with('message', 'Product added!');
    }

	public function edit_product($id)
	{
		$att = Attributes::all();
		$product = Product::findOrFail($id);
		$items = Category::pluck('name', 'id');
		$location = Location::pluck('name','id');
		$product_images = DB::table('product_imagess')
						->where('product_id', $id)
						->get();
		return view('account.edit_products', compact('product','items','product_images','att','location'));
	}

	public function update_product(Request $request, $id)
    {
		$this->validate($request, [
			'product_title' => 'required',
			'description' => 'required',
			'item_id' => 'required'
		]);

        $requestData['product_title'] = $request->input('product_title');
        $requestData['description'] = $request->input('description');
		$requestData['sku'] = $request->input('sku');
		$requestData['price'] = $request->input('price');
		$requestData['category'] = $request->input('item_id');
        $requestData['location_id'] = $request->input('location_id');
        $requestData['delivery_charges'] = $request->input('delivery_charges');
        $requestData['stock_inventory'] = $request->input('stock_inventory');

        if ($request->hasFile('image')) {

			$product = product::where('id', $id)->first();
			$image_path = public_path($product->image);

			if(File::exists($image_path)) {

				File::delete($image_path);
			}

            $image = $request->file('image');
			$filename = time() . '_' . $image->getClientOriginalName();
			$image->move(public_path('uploads/products'), $filename);

			$requestData['image'] = 'uploads/products/' . $filename;
        }

		if ($request->hasFile('images')) {
			$photos=request()->file('images');
			foreach ($request->file('images') as $photo) {
				$filename = time() . '_' . $photo->getClientOriginalName();
				$path = $photo->move(public_path('uploads/products'), $filename);
				$product = product::where('id', $id)->first();

				DB::table('product_imagess')->insert([

					['image' => 'uploads/products/' . $filename, 'product_id' => $product->id]

				]);

			}

		}

        product::where('id', $id)
                ->update($requestData);


		$attval = $request->attribute;
		$product_attribute_id = $request->product_attribute;
		$oldatt = $request->attribute_id;
		$oldval = $request->value;
		$oldprice = $request->v_price;
		$oldqty = $request->qty;

		for($j = 0; $j < count($product_attribute_id); $j++){
			$product_attribute = ProductAttribute::find($product_attribute_id[$j]);
			// dd($product_attribute);
			$product_attribute->price = $oldprice[$j];
			$product_attribute->qty = $oldqty[$j];
			$product_attribute->save();
		}

		for($i = 0; $i < count($attval); $i++)
		{
			$product_attributes = new ProductAttribute;
			$product_attributes->attribute_id = $attval[$i]['attribute_id'];
			$product_attributes->value = $attval[$i]['value'];
			$product_attributes->price = $attval[$i]['v-price'];
			$product_attributes->qty = $attval[$i]['qty'];
			$product_attributes->product_id = $id;
			$product_attributes->save();
		}


		return redirect('view-product')->with('message', 'Product updated!');

    }

	public function delete_product_image(Request $request)
	{
		$image = DB::table('product_imagess')->where('id', $request->image_id)->first();

		if ($image) {
			if (file_exists(public_path($image->image))) {
				unlink(public_path($image->image));
			}
			DB::table('product_imagess')->where('id', $request->image_id)->delete();

			return response()->json(['success' => true, 'message' => 'Image deleted successfully.', 'status' => 1]);
		}

		return response()->json(['error' => true, 'message' => 'Image not found.', 'status' => 0]);
	}

	public function delete_product($id)
	{
		Product::destroy($id);
        return redirect('view-product')->with('flash_message', 'Product deleted!');
	}




		public function update_profile(Request $request) {
		
		$user = DB::table('profiles')->where('id', Auth::user()->id)->first();
		
		$validateArr = array();
		$messageArr = array();
		$insertArr = array();
		$validateArr = [ 

			'uname' => 'required',
			'email' => array(),
			
		 ];
		 
		 if($user->email != $_POST['email']) {
			$validateArr['email'] = 'required|unique:users,email,NULL,id';
		 }

		if(trim($_POST['password']) != "") {
		
			$validateArr['password'] = 'required|min:6|confirmed'; 
            $validateArr['password_confirmation'] = 'required|min:6'; 
		}
		
		$this->validate($request,$validateArr,$messageArr);
		
		$insertArr['name'] = $_POST['uname'];	
		$insertArr['email'] = $_POST['email'];
	
		if(trim($_POST['password']) != "") {
				$insertArr['password'] = Hash::make($_POST['password']);
		}
			
		DB::table('users')
		->where('id', Auth::user()->id)
		->update(
					$insertArr
				);
					
					
		Session::flash('message', 'Your Profile Settings has been changed'); 
		Session::flash('alert-class', 'alert-success'); 
		return back();			
		
	}


	public function uploadPicture(Request $request) {	

		$user = DB::table('profiles')->where('id', Auth::user()->id)->first();
	
        if ($file = $request->file('pic')) {
            $extension = $file->extension()?: 'jpg|png';
            $destinationPath = public_path() . '/storage/uploads/users/';
            $safeName = str_random(10) . '.' . $extension;
            $file->move($destinationPath, $safeName);
            //delete old pic if exists
            if (File::exists($destinationPath . $user->pic)) {
                File::delete($destinationPath . $user->pic);
            }
            //save new file path into db
            $profile->pic = $safeName;
        }

			$insertArr['pic'] = $safeName;

			DB::table('profiles')
			->where('id', Auth::user()->id)
			->update(
						$insertArr
					);

		Session::flash('message', 'Your Profile has been changed'); 
		Session::flash('alert-class', 'alert-success'); 
		return back();			

	}

    public function updateAccount(Request $request) {
		$user = DB::table('users')->where('id', Auth::user()->id)->first();
		
		// Gather input fields except _token
		$insertArr = [
			'name' => $request->input('uname'),
			'last_name' => $request->input('last_name'),
			'email' => $request->input('email'),
			'phone' => $request->input('phone'),
			'company_name' => $request->input('company_name'),
			'address' => $request->input('address'),
			'state' => $request->input('state'),
			'city' => $request->input('city'),
			'zip' => $request->input('zip'),
			'license_state' => $request->input('license_state'),
			'license_no' => $request->input('license_no'),
			'age' => $request->input('age')
		];
	
		$password = $request->input('password');
		$confirmpass = $request->input('password_confirmation');
	
		// Check if passwords match and update if they are set
		if($password == $confirmpass) {
			if(trim($password) != "") {
				$insertArr['password'] = Hash::make($password);
			}
	
			DB::table('users')
				->where('id', Auth::user()->id)
				->update($insertArr);
	
			Session::flash('message', 'Your account settings have been changed');
			Session::flash('alert-class', 'alert-success');
			return back();
		} else {
			Session::flash('flash_message', 'Passwords do not match');
			Session::flash('alert-class', 'alert-danger');
			return back();
		}
	}
	


	public function accountDetail()
    {
		$orders = orders::where('orders.user_id', Auth::user()->id)
						->orderBy('orders.id', 'desc')
						->get();
		
		return view('account.account',['ORDERS'=>$orders]); 
		
	}
	
	public function invoice($id)
    {
		$order_id = $id;
		$order = orders::where('id',$order_id)->first();
		$order_products = orders_products::where('orders_id',$order_id)->get();
		
		return view('account.invoice')->with('title','Invoice #'.$order_id)->with(compact('order','order_products'))->with('order_id',$order_id);; 
	}


	public function friends()
    {
		return view('account.friends'); 
		
	}

	public function upload()
    {
		return view('account.upload'); 
		
	}

	public function password()
    {
		return view('account.password'); 
		
	}

	public function get_attribute(request $request )
    {
		$value = $request->value;

		$attributes = AttributeValue::where('attribute_id' , $value)->get();

		if($attributes){
			return response()->json(['message'=> $attributes, 'status' => true]);
		}else{
			return response()->json(['message'=>'Error Occurred', 'status' => false]);
		}
    }

	public function deleteProVariant(request $request )
    {
		$id = $request->id;
		$product_variant = DB::table('product_attributes')
							->where('id', $id)
							->delete();

		if($product_variant){
			return response()->json(['message'=> "Update", 'status' => true]);
		}else{
			return response()->json(['message'=>'Error Occurred', 'status' => false]);
		}

    }
	
}	
	
