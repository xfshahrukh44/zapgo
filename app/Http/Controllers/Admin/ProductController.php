<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Category;
use App\orders;
use App\orders_products;
use App\Product;
use App\imagetable;
use App\Attributes;
use App\AttributeValue;
use App\ProductAttribute;
use Illuminate\Http\Request;
use Image;
use File;
use DB;
use Session;
use App\Models\Location;

class ProductController extends Controller
{

    public function __construct()
    {
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

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */

    public function index(Request $request)
    {

        $model = str_slug('product','-');
        if(auth()->user()->permissions()->where('name','=','view-'.$model)->first()!= null) {
            $keyword = $request->get('search');
            $perPage = 25;

            if (!empty($keyword)) {
                $product = Product::where('products.product_title', 'LIKE', "%$keyword%")
				->leftjoin('categories', 'products.category', '=', 'categories.id')
                ->orWhere('products.description', 'LIKE', "%$keyword%")
                ->paginate($perPage);
            } else {
                $product = Product::paginate($perPage);
            }

            return view('admin.product.index', compact('product'));
        }
        return response(view('403'), 403);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {

        $model = str_slug('product','-');
        if(auth()->user()->permissions()->where('name','=','add-'.$model)->first()!= null) {

            $att = Attributes::all();
            $attval = AttributeValue::all();

			// $items = Category::all(['id', 'name']);
			$items = Category::pluck('name', 'id');
            $location = Location::pluck('name','id');

            return view('admin.product.create', compact('items', 'att','attval','location'));
        }
        return response(view('403'), 403);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {

	    //echo "<pre>";
	    //print_r($_FILES);
	    //return;

		//dd($_FILES);
        $model = str_slug('product','-');
        if(auth()->user()->permissions()->where('name','=','add-'.$model)->first()!= null) {
            $this->validate($request, [
			'product_title' => 'required',
			'description' => 'required',
			'price' => 'required',
			'image' => 'required',
			'item_id' => 'required',
            'location_id' => 'required'
		]);

		    //echo implode(",",$_POST['language']);
		    //return;
			$product = new product;

            $product->product_title = $request->input('product_title');
			$product->price = $request->input('price');
            $product->description = $request->input('description');
            $product->short_desc = $request->input('short_desc');
			$product->category = $request->input('item_id');
            $product->location_id = $request->input('location_id');
            $product->delivery_charges = $request->input('delivery_charges') ?? 0;
            $product->stock_inventory = $request->input('stock_inventory');
            $product->env_fee = $request->input('env_fee');
            // $file = $request->file('image');

            //make sure yo have image folder inside your public
            // $destination_path = 'uploads/products/';
            // $profileImage = date("Ymdhis").".".$file->getClientOriginalExtension();

            // Image::make($file)->save(public_path($destination_path) . DIRECTORY_SEPARATOR. $profileImage);

            // $product->image = $destination_path.$profileImage;

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filePath = date("Ymdhis").".".$file->getClientOriginalExtension();
                $file->move(public_path('uploads/products/'), $filePath);
                $product->image = 'uploads/products/' . $filePath;
            }

            $product->save();


            if(! is_null(request('images'))) {

                $photos=request()->file('images');
                foreach ($photos as $photo) {
                    $photoPath = date("Ymdhis").".".$photo->getClientOriginalExtension();
                    $photo->move(public_path('uploads/products/'), $photoPath);
                    $destination_path = 'uploads/products/' . $photoPath;

                    DB::table('product_imagess')->insert([

                        ['image' => $destination_path, 'product_id' => $product->id]

                    ]);

                }

            }
             //$photos->save();
            //$requestData = $request->all();
            //Product::create($requestData);

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





            return redirect('admin/product')->with('message', 'Product added!');
        }
        return response(view('403'), 403);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $model = str_slug('product','-');
        if(auth()->user()->permissions()->where('name','=','view-'.$model)->first()!= null) {
            $product = Product::findOrFail($id);
            return view('admin.product.show', compact('product'));
        }
        return response(view('403'), 403);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {



        $model = str_slug('product','-');
        if(auth()->user()->permissions()->where('name','=','edit-'.$model)->first()!= null) {

            $att = Attributes::all();
            $product = Product::findOrFail($id);

			$items = Category::pluck('name', 'id');
            $location = Location::pluck('name','id');

			$product_images = DB::table('product_imagess')
                          ->where('product_id', $id)
                          ->get();



            return view('admin.product.edit', compact('product','items','product_images','att','location'));
        }
        return response(view('403'), 403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $model = str_slug('product','-');
        if(auth()->user()->permissions()->where('name','=','edit-'.$model)->first()!= null) {
            $this->validate($request, [
			'product_title' => 'required',
			'description' => 'required',
			'item_id' => 'required'
		]);
        // dd($request->all());
        $requestData['product_title'] = $request->input('product_title');
        $requestData['description'] = $request->input('description');
        $requestData['short_desc'] = $request->input('short_desc');
		$requestData['sku'] = $request->input('sku');
		$requestData['price'] = $request->input('price');
		$requestData['category'] = $request->input('item_id');
        $requestData['location_id'] = $request->input('location_id');
        $requestData['delivery_charges'] = $request->input('delivery_charges');
        $requestData['stock_inventory'] = $request->input('stock_inventory');
        $requestData['env_fee'] = $request->input('env_fee');

        // dump($request->input());
        // die();
    /*Insert your data*/

    // Detail::insert( [
        // 'images'=>  implode("|",$images),
    // ]);

        if ($request->hasFile('image')) {

			$product = product::where('id', $id)->first();
			$image_path = public_path($product->image);

			if(File::exists($image_path)) {

				File::delete($image_path);
			}

            $file = $request->file('image');
            $filePath = date("Ymdhis").".".$file->getClientOriginalExtension();
            $file->move(public_path('uploads/products/'), $filePath);
            $requestData['image'] = 'uploads/products/' . $filePath;
        }

            if(! is_null(request('images'))) {

                $photos=request()->file('images');
                foreach ($photos as $photo) {
                    $photoPath = date("Ymdhis").".".$photo->getClientOriginalExtension();
                    $photo->move(public_path('uploads/products/'), $photoPath);
                    $destination_path = 'uploads/products/' . $photoPath;

                    DB::table('product_imagess')->insert([

                        ['image' => $destination_path, 'product_id' => $product->id]

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
            // dump(count($product_attribute_id));
            // dd($oldqty);
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

         /*
        if(! is_null(request('images'))) {


                DB::table('product_imagess')->where('product_id', '=', $id)->delete();

                $photos=request()->file('images');



                foreach ($photos as $photo) {
                    $destinationPath = 'uploads/products/';

                    $fileName = uniqid() . "_" . $file->getClientOriginalName();
                    $file->move(storage_path($destinationPath), $fileName);


                    DB::table('product_imagess')->insert([

                        ['image' => $destinationPath.$filename, 'product_id' => $product->id]

                    ]);

                }

        }
        */


             return redirect('admin/product')->with('message', 'Product updated!');
        }
        return response(view('403'), 403);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $model = str_slug('product','-');
        if(auth()->user()->permissions()->where('name','=','delete-'.$model)->first()!= null) {
            Product::destroy($id);

            return redirect('admin/product')->with('flash_message', 'Product deleted!');
        }
        return response(view('403'), 403);

    }
	public function orderList() {

		$orders = orders::
				    select('orders.*')
				   ->get();

		return view('admin.ecommerce.order-list', compact('orders'));
	}

	public function orderListDetail($id) {

		$order_id = $id;
		$order = orders::where('id',$order_id)->first();
		$order_products = orders_products::where('orders_id',$order_id)->get();

        $orderProduct = orders_products::where('orders_id', $order_id)
            ->join('users', 'orders_products.user_id', '=', 'users.id')
            ->select('orders_products.*', 'users.email', 'users.phone')
            ->first();

		return view('admin.ecommerce.order-page')->with('title','Invoice #'.$order_id)->with(compact('order','order_products','orderProduct'))->with('order_id',$order_id);

		// return view('admin.ecommerce.order-page');
	}

	public function updatestatuscompleted($id) {

		$order_id = $id;
		$order = DB::table('orders')
              ->where('id', $id)
              ->update(['order_status' => 'Completed']);


		Session::flash('message', 'Order Status Updated Successfully');
						Session::flash('alert-class', 'alert-success');
						return back();

	}
	public function updatestatusPending($id) {

		$order_id = $id;
		$order = DB::table('orders')
              ->where('id', $id)
              ->update(['order_status' => 'Pending']);


		Session::flash('message', 'Order Status Updated Successfully');
						Session::flash('alert-class', 'alert-success');
						return back();

	}

}
