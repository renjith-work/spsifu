<?php

namespace App\Http\Controllers\Admin\Product\Brand;

use App\Models\Product\Brand;
use App\Models\Status;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Str;
use Auth;
use Validator;
use Session;
Use Image;
Use Storage;
Use Purifier;
use File;


class BrandController extends Controller
{
    public function __construct() {
        $this->middleware(['auth', 'brand']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::orderBy('id', 'asc')->paginate(15);
        return view('admin.product.brand.index')->with('brands', $brands);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $statuses = Status::all();
        return view('admin.product.brand.create')->with('statuses', $statuses);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
         $validator = Validator::make($request->all(), [
            'name' => 'required|min:2|max:255|unique:brands,name',
            'description' => 'required',
            'image' =>   'required|image|mimes:jpeg,png,jpg,gif,svg|max:2000',
        ]);

        if ($validator->passes()) {
            $brand = new Brand;
            $brand->name = $request->name;
            $brand->slug = Str::slug($request->name, '-'); 
            $brand->description = strip_tags(htmlspecialchars_decode($request->description));
            $brand->status_id = $request->status;

            if ($request-> hasFile('image')) //Check if the file exists
            {
                $image = $request->file('image'); //Grab and store the file on to $image
                $filename = Str::slug(pathinfo($request->image->getClientOriginalName(), PATHINFO_FILENAME), '-').'-'.time(). '.'. $image->getClientOriginalExtension(); //Create a new filename
                $location = public_path('images/product/brands/'. $filename);
                Image::make($image)->resize(400, 400)->save($location); //Use intervention to create an image model and store the file with the resize.
                $brand->image= $filename; //store the filename in to the database.
            }

            $brand->save();
            Session::flash('success', 'The data was successfully inserted.');
            return redirect()->back();

        }else{
            return redirect()->back()->withInput()->withErrors($validator);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brand = Brand::find($id);
        $statuses = Status::all();
        return view('admin.product.brand.edit')->with('statuses', $statuses)->with('brand', $brand);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
         $validator = Validator::make($request->all(), [
            'name' => "required|min:2|max:255|unique:brands,name,$id",
            'description' => 'required',
            'image' =>   'image|mimes:jpeg,png,jpg,gif,svg|max:2000',
        ]);

        if ($validator->passes()) {
            $brand = Brand::find($id);
            $brand->name = $request->name;
            $brand->slug = Str::slug($request->name, '-'); 
            $brand->description = strip_tags(htmlspecialchars_decode($request->description));
            $brand->status_id = $request->status;

            if ($request-> hasFile('image')) //Check if the file exists
            {
                $image = $request->file('image'); //Grab and store the file on to $image
                $filename = Str::slug(pathinfo($request->image->getClientOriginalName(), PATHINFO_FILENAME), '-').'-'.time(). '.'. $image->getClientOriginalExtension(); //Create a new filename
                $location = public_path('images/product/brands/'. $filename);
                Image::make($image)->resize(400, 400)->save($location); //Use intervention to create an image model and store the file with the resize.
                
                $oldFilename = $brand->image;
                $brand->image= $filename; //store the filename in to the database.
                Storage::delete('product/brands' .'/'. $oldFilename);
            }

            $brand->save();
            Session::flash('success', 'The data was successfully inserted.');
            return redirect()->back();

        }else{
            return redirect()->back()->withInput()->withErrors($validator);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function delete($id)
    {
        $brand = Brand::find($id);
        Storage::delete('product/brands/'. $brand->image);
        $brand->delete(); 
        Session::flash('success', 'The entry was successfully deleted.');
        return redirect()->back(); 
    }
}
