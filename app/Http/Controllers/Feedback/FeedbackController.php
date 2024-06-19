<?php

namespace App\Http\Controllers\Feedback;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Image;
use File;

class FeedbackController extends Controller
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
        $model = str_slug('feedback','-');
        if(auth()->user()->permissions()->where('name','=','view-'.$model)->first()!= null) {
            $keyword = $request->get('search');
            $perPage = 25;

            if (!empty($keyword)) {
                $feedback = Feedback::where('message', 'LIKE', "%$keyword%")
                ->orWhere('type', 'LIKE', "%$keyword%")
                ->paginate($perPage);
            } else {
                $feedback = Feedback::paginate($perPage);
            }
            
            return view('feedback.feedback.index', compact('feedback'));
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
        $model = str_slug('feedback','-');
        if(auth()->user()->permissions()->where('name','=','add-'.$model)->first()!= null) {
            return view('feedback.feedback.create');
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
        $model = str_slug('feedback','-');
        if(auth()->user()->permissions()->where('name','=','add-'.$model)->first()!= null) {
            

            $feedback = new Feedback($request->all());

            if ($request->hasFile('image')) {

                $file = $request->file('image');
                
                //make sure yo have image folder inside your public
                $feedback_path = 'uploads/feedbacks/';
                $fileName = $file->getClientOriginalName();
                $profileImage = date("Ymd").$fileName.".".$file->getClientOriginalExtension();

                Image::make($file)->save(public_path($feedback_path) . DIRECTORY_SEPARATOR. $profileImage);

                $feedback->image = $feedback_path.$profileImage;
            }
            
            $feedback->save();
            return redirect()->back()->with('message', 'Feedback added!');
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
        $model = str_slug('feedback','-');
        if(auth()->user()->permissions()->where('name','=','view-'.$model)->first()!= null) {
            $feedback = Feedback::findOrFail($id);
            return view('feedback.feedback.show', compact('feedback'));
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
        $model = str_slug('feedback','-');
        if(auth()->user()->permissions()->where('name','=','edit-'.$model)->first()!= null) {
            $feedback = Feedback::findOrFail($id);
            return view('feedback.feedback.edit', compact('feedback'));
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
        $model = str_slug('feedback','-');
        if(auth()->user()->permissions()->where('name','=','edit-'.$model)->first()!= null) {
            
            $requestData = $request->all();
            

        if ($request->hasFile('image')) {
            
            $feedback = Feedback::where('id', $id)->first();
            $image_path = public_path($feedback->image); 
            
            if(File::exists($image_path)) {
                File::delete($image_path);
            }

            $file = $request->file('image');
            $fileNameExt = $request->file('image')->getClientOriginalName();
            $fileNameForm = str_replace(' ', '_', $fileNameExt);
            $fileName = pathinfo($fileNameForm, PATHINFO_FILENAME);
            $fileExt = $request->file('image')->getClientOriginalExtension();
            $fileNameToStore = $fileName.'_'.time().'.'.$fileExt;
            $pathToStore = public_path('uploads/feedbacks/');
            Image::make($file)->save($pathToStore . DIRECTORY_SEPARATOR. $fileNameToStore);

             $requestData['image'] = 'uploads/feedbacks/'.$fileNameToStore;               
        }


            $feedback = Feedback::findOrFail($id);
            $feedback->update($requestData);
            return redirect()->back()->with('message', 'Feedback updated!');
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
        $model = str_slug('feedback','-');
        if(auth()->user()->permissions()->where('name','=','delete-'.$model)->first()!= null) {
            Feedback::destroy($id);
            return redirect()->back()->with('message', 'Feedback deleted!');
        }
        return response(view('403'), 403);

    }
}
