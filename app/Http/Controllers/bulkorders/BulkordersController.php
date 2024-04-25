<?php

namespace App\Http\Controllers\bulkorders;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\Bulkorder;
use Illuminate\Http\Request;
use Image;
use File;

class BulkordersController extends Controller
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
        $model = str_slug('bulkorders','-');
        if(auth()->user()->permissions()->where('name','=','view-'.$model)->first()!= null) {
            $keyword = $request->get('search');
            $perPage = 25;

            if (!empty($keyword)) {
                $bulkorders = Bulkorder::where('customer_name', 'LIKE', "%$keyword%")
                ->orWhere('customer_email', 'LIKE', "%$keyword%")
                ->orWhere('customer_phone', 'LIKE', "%$keyword%")
                ->orWhere('product_name', 'LIKE', "%$keyword%")
                ->orWhere('quatity', 'LIKE', "%$keyword%")
                ->orWhere('amont', 'LIKE', "%$keyword%")
                ->orWhere('transaction_id', 'LIKE', "%$keyword%")
                ->paginate($perPage);
            } else {
                $bulkorders = Bulkorder::paginate($perPage);
            }

            return view('bulkorders.bulkorders.index', compact('bulkorders'));
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
        $model = str_slug('bulkorders','-');
        if(auth()->user()->permissions()->where('name','=','add-'.$model)->first()!= null) {
            return view('bulkorders.bulkorders.create');
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
        $model = str_slug('bulkorders','-');
        if(auth()->user()->permissions()->where('name','=','add-'.$model)->first()!= null) {
            

            $bulkorders = new Bulkorder($request->all());

            if ($request->hasFile('image')) {

                $file = $request->file('image');
                
                //make sure yo have image folder inside your public
                $bulkorders_path = 'uploads/bulkorderss/';
                $fileName = $file->getClientOriginalName();
                $profileImage = date("Ymd").$fileName.".".$file->getClientOriginalExtension();

                Image::make($file)->save(public_path($bulkorders_path) . DIRECTORY_SEPARATOR. $profileImage);

                $bulkorders->image = $bulkorders_path.$profileImage;
            }
            
            $bulkorders->save();
            return redirect()->back()->with('message', 'Bulkorder added!');
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
        $model = str_slug('bulkorders','-');
        if(auth()->user()->permissions()->where('name','=','view-'.$model)->first()!= null) {
            $bulkorder = Bulkorder::findOrFail($id);
            return view('bulkorders.bulkorders.show', compact('bulkorder'));
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
        $model = str_slug('bulkorders','-');
        if(auth()->user()->permissions()->where('name','=','edit-'.$model)->first()!= null) {
            $bulkorder = Bulkorder::findOrFail($id);
            return view('bulkorders.bulkorders.edit', compact('bulkorder'));
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
        $model = str_slug('bulkorders','-');
        if(auth()->user()->permissions()->where('name','=','edit-'.$model)->first()!= null) {
            
            $requestData = $request->all();
            

        if ($request->hasFile('image')) {
            
            $bulkorders = Bulkorder::where('id', $id)->first();
            $image_path = public_path($bulkorders->image); 
            
            if(File::exists($image_path)) {
                File::delete($image_path);
            }

            $file = $request->file('image');
            $fileNameExt = $request->file('image')->getClientOriginalName();
            $fileNameForm = str_replace(' ', '_', $fileNameExt);
            $fileName = pathinfo($fileNameForm, PATHINFO_FILENAME);
            $fileExt = $request->file('image')->getClientOriginalExtension();
            $fileNameToStore = $fileName.'_'.time().'.'.$fileExt;
            $pathToStore = public_path('uploads/bulkorderss/');
            Image::make($file)->save($pathToStore . DIRECTORY_SEPARATOR. $fileNameToStore);

             $requestData['image'] = 'uploads/bulkorderss/'.$fileNameToStore;               
        }


            $bulkorder = Bulkorder::findOrFail($id);
            $bulkorder->update($requestData);
            return redirect()->back()->with('message', 'Bulkorder updated!');
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
        $model = str_slug('bulkorders','-');
        if(auth()->user()->permissions()->where('name','=','delete-'.$model)->first()!= null) {
            Bulkorder::destroy($id);
            return redirect()->back()->with('message', 'Bulkorder deleted!');
        }
        return response(view('403'), 403);

    }
}
