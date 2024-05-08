<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\GetQuote;
use Illuminate\Http\Request;
use Image;
use File;

class GetQuoteController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */

    public function index(Request $request)
    {
        $model = str_slug('getquote','-');
        if(auth()->user()->permissions()->where('name','=','view-'.$model)->first()!= null) {
            $keyword = $request->get('search');
            $perPage = 25;

            if (!empty($keyword)) {
                $getquote = GetQuote::where('first_name', 'LIKE', "%$keyword%")
                ->orWhere('last_name', 'LIKE', "%$keyword%")
                ->orWhere('email', 'LIKE', "%$keyword%")
                ->orWhere('phone', 'LIKE', "%$keyword%")
                ->orWhere('company', 'LIKE', "%$keyword%")
                ->orWhere('address', 'LIKE', "%$keyword%")
                ->orWhere('city', 'LIKE', "%$keyword%")
                ->orWhere('state', 'LIKE', "%$keyword%")
                ->orWhere('product', 'LIKE', "%$keyword%")
                ->orWhere('quantity', 'LIKE', "%$keyword%")
                ->orWhere('message', 'LIKE', "%$keyword%")
                ->paginate($perPage);
            } else {
                $getquote = GetQuote::paginate($perPage);
            }

            return view('admin.get-quote.index', compact('getquote'));
        }
        return response(view('403'), 403);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    // public function create()
    // {
    //     $model = str_slug('getquote','-');
    //     if(auth()->user()->permissions()->where('name','=','add-'.$model)->first()!= null) {
    //         return view('Admin.get-quote.create');
    //     }
    //     return response(view('403'), 403);

    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        // dd($request->all());
            $this->validate($request, [
			'first_name' => 'required',
			'last_name' => 'required',
			'email' => 'required',
			'phone' => 'required'
		]);

        GetQuote::create($request->all());



            // $getquote->save();
            return redirect()->back()->with('message', 'Quote added!');

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
        $model = str_slug('getquote','-');
        if(auth()->user()->permissions()->where('name','=','view-'.$model)->first()!= null) {
            $getquote = GetQuote::with('quote_products')->findOrFail($id);
            // return $getquote;
            return view('admin.get-quote.show', compact('getquote'));
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
    // public function edit($id)
    // {
    //     $model = str_slug('getquote','-');
    //     if(auth()->user()->permissions()->where('name','=','edit-'.$model)->first()!= null) {
    //         $getquote = GetQuote::findOrFail($id);
    //         return view('Admin.get-quote.edit', compact('getquote'));
    //     }
    //     return response(view('403'), 403);
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    // public function update(Request $request, $id)
    // {
    //     $model = str_slug('getquote','-');
    //     if(auth()->user()->permissions()->where('name','=','edit-'.$model)->first()!= null) {
    //         $this->validate($request, [
	// 		'first_name' => 'required',
	// 		'last_name' => 'required',
	// 		'email' => 'required',
	// 		'phone' => 'required'
	// 	]);
    //         $requestData = $request->all();


    //     if ($request->hasFile('image')) {

    //         $getquote = GetQuote::where('id', $id)->first();
    //         $image_path = public_path($getquote->image);

    //         if(File::exists($image_path)) {
    //             File::delete($image_path);
    //         }

    //         $file = $request->file('image');
    //         $fileNameExt = $request->file('image')->getClientOriginalName();
    //         $fileNameForm = str_replace(' ', '_', $fileNameExt);
    //         $fileName = pathinfo($fileNameForm, PATHINFO_FILENAME);
    //         $fileExt = $request->file('image')->getClientOriginalExtension();
    //         $fileNameToStore = $fileName.'_'.time().'.'.$fileExt;
    //         $pathToStore = public_path('uploads/getquotes/');
    //         Image::make($file)->save($pathToStore . DIRECTORY_SEPARATOR. $fileNameToStore);

    //          $requestData['image'] = 'uploads/getquotes/'.$fileNameToStore;
    //     }


    //         $getquote = GetQuote::findOrFail($id);
    //         $getquote->update($requestData);
    //         return redirect()->back()->with('message', 'GetQuote updated!');
    //     }
    //     return response(view('403'), 403);

    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $model = str_slug('getquote','-');
        if(auth()->user()->permissions()->where('name','=','delete-'.$model)->first()!= null) {
            GetQuote::destroy($id);
            return redirect()->back()->with('message', 'Get Quote deleted!');
        }
        return response(view('403'), 403);

    }

    public function bulk_status(Request $request) 
    {
        $data = GetQuote::find($request->quote_id);

        if(!$data){
            return response()->json(['error' => true, 'message' => 'Status updated failed']);
        }

        if($request->response == 'approved'){
            $data->bulk_status = 1;
        }else{
            $data->bulk_status = 0;
        }
        $data->total_amount = $request->amount;
        $data->save();

        return response()->json(['success' => true, 'message' => 'Status updated success', 'status' => $request->response]);
    }

    public function discount(Request $request)
    {
        $data = GetQuote::find($request->quote_id);

        if(!$data){
            return response()->json(['error' => true, 'message' => 'Discount updated failed']);
        }

        $data->discount =  $request->amount;
        $data->total_amount =  $request->subtotal - $request->amount;
        $data->save();

        return response()->json(['success' => true, 'message' => 'Discount updated success']);
    }
}
