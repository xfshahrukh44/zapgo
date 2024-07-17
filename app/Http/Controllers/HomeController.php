<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\inquiry;
use App\schedule;
use App\newsletter;
use App\post;
use App\Banner;
use App\Category;
use App\Product;
use App\imagetable;
use DB;
use Mail;use View;
use Session;
use App\Http\Helpers\UserSystemInfoHelper;
use App\Http\Traits\HelperTrait;
use Auth;
use App\Profile;
use App\Page;
use Image;
use App\Section;
use App\Testimonial;
use App\ProductAttribute;
use App\Models\Location;
use App\Models\GetQuote;
use App\Models\QuoteProdInfo;
use App\Models\Feedback;
use Stripe;
use App\Models\Bulkorder;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

       $page = DB::table('pages')->where('id', 1)->first();
       $section = Section::where('page_id', 1)->get();
       $banner = Banner::all();
       $testimonial = Testimonial::all();
       $randomproducts = Product::inRandomOrder()->take(4)->get();

       if(isset($_GET['search']))
{

    $location_id = $_GET['search'];
	$get_product = Product::where('location_id',$location_id)->get();

}
else
{
    $get_product = Product::all();
}
       $location = Location::all();

       return view('welcome', compact('page','section','banner','testimonial','get_product','location','randomproducts'));
    }


    public function quoteStore(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'phone' => 'required',
		]);

        $req = $request->all();

        $start_date = Carbon::createFromFormat('m-d-Y', $request->start_date);
        $end_date = Carbon::createFromFormat('m-d-Y', $request->end_date);
        $req['number_of_days'] = $end_date->diffInDays($start_date);
        $req['start_date'] = $request->start_date;
        $req['end_date'] = $request->end_date;
        $req['user_id'] = Auth::user()->id;
        $req['bulk_amount'] = $request->bulk_amount;

        $quote = GetQuote::create($req);

        $products = $request->input('product');
        $prices = $request->input('price');
        $quantities = $request->input('quantity');
        $item_price = $request->input('item_price');

        if(is_array($products)){
            foreach($products as $key => $productId){
                $data = new QuoteProdInfo();
                $data->qoute_id = $quote->id;
                $data->product = $productId;
                $data->quantity = $quantities[$key];
                $data->price = $prices[$key];
                $data->item_price = $item_price[$key];
                $data->save();
            }
        }



            // $getquote->save();
            return redirect()->back()->with('message', 'Quote added!');

    }


    public function getQuoteOrder(Request $request){
        // dd($request->all());
        $total = $request->order_total;
        try {
            try {
                Stripe\Stripe::setApiKey( config('services.stripe.secretkey'));

                $customer = \Stripe\Customer::create(array(
                    'email' => $request->email,
                    'name' => $request->first_name,
                    'phone' => $request->phone_no,
                    'description' => "Quote Order Created From Website",
                    'source'  => $request->stripeToken,
                ));
            // dd($customer);
            } catch (Exception $e) {
                return redirect()->back()->with('stripe_error', $e->getMessage());
            }
            // dd($total * 100);
            try {
                $charge = \Stripe\Charge::create(array(
                    'customer' => $customer->id,
                    'amount'   => $total * 100,
                    'currency' => 'USD',
                    'description' => "Quote Order Created From Website",
                    'metadata' => array("name" => $request->first_name, "email" => $request->email),
                ));


            } catch (Exception $e) {
                // dd('Error');
                return redirect()->back()->with('stripe_error', $e->getMessage());
            }
        } catch (Exception $e) {
            // dd('Success ');
            return redirect()->back()->with('stripe_error', $e->getMessage());
        }
        
        $chargeJson = $charge->jsonSerialize();
			// Check whether the charge is successful
			if ($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1) {

				$transactionID = $chargeJson['balance_transaction'];
				$payment_status = $chargeJson['status'];
                // dd($payment_status);
                $product = Product::find($request->product_id);
                $getOrderQuote = GetQuote::find($request->order_id);
                $getOrderQuote->status = 1;
                $getOrderQuote->save();
                // dd($getOrderQuote);
                $bulkOrders = new Bulkorder();
                $bulkOrders->customer_name = $request->first_name;
                $bulkOrders->customer_email = $request->email;
                $bulkOrders->customer_phone = $request->phone_no;
                $bulkOrders->product_name = $product->product_title;
                $bulkOrders->quantity = $request->quantity;
                $bulkOrders->amount = $total;
                $bulkOrders->transaction_id = $transactionID;
                $bulkOrders->quote_prod_ids = $request->quote_prod_ids;
                $bulkOrders->status = $payment_status;
                $bulkOrders->save();

                return redirect()->back()->with('message', 'Order Completed');
			}
    }

    public function about()
    {
        $page = Page::find(2);
        $section = Section::where('page_id',2)->get();
        return view('about',compact('page','section'));
    }

    public function contact()
    {
        $page = Page::find(4);
        return view('contact',compact('page'));
    }

    public function category()
    {
        $page = Page::find(6);
        $category = Category::orderBy('name', 'asc')->get();
        $mainproduct = Product::orderBy('product_title', 'asc')->get();
        
        // dd($mainproduct);
        
        return view('categories',compact('page','category','mainproduct'));
    }

    public function product_category($id)
    {
        $page = Page::find(7);
        $categories = Category::orderBy('name', 'asc')->get();
        $category = Category::find($id);


        return view('product_category',compact('page','categories','category','att_model','att_id'));
    }

    public function privacy_policy(){
        $page = DB::table('pages')->where('id', 8)->first();
        return view('privacy-policy', compact('page'));
    }

    public function terms(){
        $page = DB::table('pages')->where('id', 9)->first();
        return view('terms', compact('page'));
    }

    public function rental_agreement(){
        $page = DB::table('pages')->where('id', 10)->first();
        return view('rental-agreement', compact('page'));
    }

    public function get_a_qoute()
    {
        // $page = Page::find(4);
        if (!Auth::check()) {
            return redirect()->route('signin');
        }
        return view('get_a_qoute');
    }






    public function careerSubmit(Request $request)
    {


        inquiry::create($request->all());


        return response()->json(['message'=>'Thank you for contacting us. We will get back to you asap', 'status' => true]);
        return back();
    }

    public function feedbackSubmit(Request $request)
    {


        Feedback::create($request->all());


        return response()->json(['message'=>'Thank you for your feedback.', 'status' => true]);
        return back();
    }

    public function newsletterSubmit(Request $request){

        $is_email = newsletter::where('newsletter_email',$request->newsletter_email)->count();
        if($is_email == 0) {
            $inquiry = new newsletter;
            $inquiry->newsletter_email = $request->newsletter_email;
            $inquiry->save();
            return response()->json(['message'=>'Thank you for contacting us. We will get back to you asap', 'status' => true]);

        }else{
            return response()->json(['message'=>'Email already exists', 'status' => false]);
        }

    }

    public function updateContent(Request $request){
        $id = $request->input('id');
        $keyword = $request->input('keyword');
        $htmlContent = $request->input('htmlContent');
        if($keyword == 'page'){
            $update = DB::table('pages')
                        ->where('id', $id)
                        ->update(array('content' => $htmlContent));

            if($update){
                return response()->json(['message'=>'Content Updated Successfully', 'status' => true]);
            }else{
                return response()->json(['message'=>'Error Occurred', 'status' => false]);
            }
        }else if($keyword == 'section'){
            $update = DB::table('section')
                        ->where('id', $id)
                        ->update(array('value' => $htmlContent));
            if($update){
                return response()->json(['message'=>'Content Updated Successfully', 'status' => true]);
            }else{
                return response()->json(['message'=>'Error Occurred', 'status' => false]);
            }
        }
    }
    
    public function stkPush(Request $request){
        Log::info('STK Push endpoint hit');
        Log::info($request->all());
        return [
            'ResultCode' => 0,
            'ResultDesc' => 'Accept Service',
            'ThirdPartyTransID' => rand(3000, 10000)
        ];
    }

    // public function store(Request $request)
    // {
    //     $products = $request->input('product');
    //     $quantities = $request->input('quantity');
    //     $prices = $request->input('price');

    //     foreach ($products as $index => $productId) {
    //         // Insert product into the database
    //         Product::create([
    //             'product_id' => $productId,
    //             'quantity' => $quantities[$index],
    //             'price' => $prices[$index]
    //         ]);
    //     }

    //     return redirect()->back()->with('success', 'Products inserted successfully');
    // }

}
