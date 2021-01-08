<?php

namespace App\Http\Controllers\Admin\Product\Design;

use App\Models\Product\Design\ProductDesign;
use App\Models\Product\Design\ProductDesignPrice;
use App\Models\Product\Design\ProductDesignImage;
use App\Models\Product\Design\ProductDesignVideo;
use App\Models\Product\Tax\TaxClass;
use App\Models\Product\ProductAttribute;
use App\Models\Product\ProductAttributeSet;
use App\Models\Product\Design\ProductDesignAttributeValueSave;
use App\Models\Product\Design\ProductDesignWeight;
use App\Models\Product\Inventory\InventoryUnit;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Str;
use Auth;
use Validator;
use Session;
use Image;
use Storage;
use Purifier;
use File;

class ShirtController extends Controller
{
    public function __construct() {
        $this->middleware(['auth', 'productDesignShirt']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $designs = ProductDesign::where('product_attribute_set_id', 1)->orderBy('id', 'asc')->paginate(15);
        return view('admin.product.design.shirt.index')->with('designs', $designs);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $attributeSets = ProductAttributeSet::orderBy('id', 'asc')->get();
        $taxClasses = TaxClass::orderBy('id', 'asc')->get();
        $weightUnits = InventoryUnit::where('type_id', 2)->get();
        return view('admin.product.design.shirt.create')->with('attributeSets', $attributeSets)->with('taxClasses', $taxClasses)->with('weightUnits', $weightUnits);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|min:5|max:255|unique:product_designs,name',
                'attributeSet' => 'required',
                'weight' => 'required',
                'weightUnit' => 'required',
                'description' => 'required',
                'summary' => 'required',
                'price' => 'required',
                'startDate' => 'required_with:splPrice',
                'endDate' => 'required_with:splPrice',
                'taxClass' => 'required_if:taxable,==,1',
                'document' => 'mimes:pdf|max:10000',
                'p_image' =>   'required|mimes:jpeg,png,jpg,gif,svg|max:2000',
                's_image' =>   'required|mimes:jpeg,png,jpg,gif,svg|max:2000',
                'album*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2000',
                'pageTitle' => 'required',
                'metatag' => 'required',
                'metadescp' => 'required',
            ],
            [
                'taxClass.required_if' => 'Please select a tax class if the product is taxable.',
                'p_image.max' => 'Max image upload size is 2 MB.',
                's_image.max' => 'Max image upload size is 2 MB.',
                'p_image.image' => 'Primary Image - Please select an image file as primary image.',
                's_image.image' => 'Secondary Image - Please select an image file as secondary image.',
                'album.max' => 'Max image upload size is 2 MB.',
            ]
        );

        if ($validator->passes()) {
            $design = new ProductDesign;
            $design->name = $request->name;
            $design->slug = Str::slug($request->name, '-');
            $design->product_attribute_set_id = $request->attributeSet;
            $design->description = $request->description;
            $design->summary = $request->summary;
            $design->featured = $request->featured;
            $design->menu = $request->menu;
            $design->pageTitle = $request->pageTitle;
            $design->metatag = $request->metatag;
            $design->metadescp = $request->metadescp;
            $design->status = $request->status;
            $design->save();

            $this->attributeSave($request, $design->id);
            $this->priceSave($request, $design->id);
            $this->videoSave($request, $design->id);
            $this->imageSave($request, $design->id);
            $this->weightSave($request, $design->id);

            // return response()->json($request->all());
            Session::flash('success', 'The data was successfully inserted.');
            return redirect()->back();
        } else {
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
        $attributeSets = ProductAttributeSet::orderBy('id', 'asc')->get();
        $taxClasses = TaxClass::orderBy('id', 'asc')->get();
        $design = ProductDesign::find($id);
        $weightUnits = InventoryUnit::where('type_id', 2)->get();
        return view('admin.product.design.shirt.edit')->with('design', $design)->with('attributeSets', $attributeSets)->with('taxClasses', $taxClasses)->with('weightUnits', $weightUnits);
    }

    // Checkit if the thing actually works.
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => "required|min:5|max:255|unique:product_designs,name, $id",
                'attributeSet' => 'required',
                'weight' => 'required',
                'weightUnit' => 'required',
                'description' => 'required',
                'summary' => 'required',
                'price' => 'required',
                'startDate' => 'required_with:splPrice',
                'endDate' => 'required_with:splPrice',
                'taxClass' => 'required_if:taxable,==,1',
                'document' => 'mimes:pdf|max:10000',
                'p_image' =>   'mimes:jpeg,png,jpg,gif,svg|max:2000',
                's_image' =>    'mimes:jpeg,png,jpg,gif,svg|max:2000',
                'album*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2000',
                'pageTitle' => 'required',
                'metatag' => 'required',
                'metadescp' => 'required',
            ],
            [
                'taxClass.required_if' => 'Please select a tax class if the product is taxable.',
                'p_image.max' => 'Max image upload size is 2 MB.',
                's_image.max' => 'Max image upload size is 2 MB.',
                'p_image.image' => 'Primary Image - Please select an image file as primary image.',
                's_image.image' => 'Secondary Image - Please select an image file as secondary image.',
                'album.max' => 'Max image upload size is 2 MB.',
            ]
        );

        if ($validator->passes()) {
            $design = ProductDesign::find($id);
            $design->name = $request->name;
            $design->slug = Str::slug($request->name, '-');
            $design->product_attribute_set_id = $request->attributeSet;
            $design->description = $request->description;
            $design->summary = $request->summary;
            $design->featured = $request->featured;
            $design->menu = $request->menu;
            $design->pageTitle = $request->pageTitle;
            $design->metatag = $request->metatag;
            $design->metadescp = $request->metadescp;
            $design->status = $request->status;
            $design->save();

            $this->attributeSaveEdit($request, $design->id);
            $this->priceSaveEdit($request, $design->id, $design->price->id);
            $this->videoSaveEdit($request, $design->id);
            $this->imageSaveEdit($request, $design->id);
            $this->weightSaveEdit($request, $design->id, $design->weight->id);

            // return response()->json($request->all());
            Session::flash('success', 'The data was successfully updated.');
            return redirect()->back();
        } else {
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
        $design = ProductDesign::find($id);
        ProductDesignPrice::where('product_design_id', $design->id)->delete();
        ProductDesignVideo::where('product_design_id', $design->id)->delete();

        $images = ProductDesignImage::where('product_design_id', $design->id)->get();
        foreach ($images as $image) {
            Storage::delete('product/design/' . $image->name);
            $image->delete();
        }

        ProductDesignAttributeValueSave::where('product_design_id', $design->id)->delete();
        $design->delete();

        Session::flash('success', 'The data was successfully deleted.');
        return redirect()->back();
    }

    public function imageDel($id)
    {
        $image = ProductDesignImage::find($id);
        Storage::delete('product/design/' . $image->name);
        $image->delete();
        return redirect(url()->previous());
    }

    public function videoDel($id)
    {
        $video = ProductDesignVideo::find($id);
        $video->delete();
        return redirect(url()->previous());
    }

    private function attributeSave($input, $design_id)
    {
        $productAttribute_array = array();
        $data = $input->all();
        $attributes = ProductAttribute::where('product_attribute_set_id', $data['attributeSet'])->get();
        foreach ($attributes as $attribute) {
            if (array_key_exists($attribute->code, $data)) {
                $productAttribute_array[] = array(

                    'product_design_id' => $design_id,
                    'product_attribute_id' => $attribute->id,
                    'product_attribute_value_id' => $data[$attribute->code],
                );
            }
        }
        ProductDesignAttributeValueSave::insert($productAttribute_array);
    }

    private function attributeSaveEdit($input, $design_id)
    {

        $productAttribute_array = array();
        $data = $input->all();
        $attributes = ProductAttribute::where('product_attribute_set_id', $data['attributeSet'])->get();
        foreach ($attributes as $attribute) {
            if (array_key_exists($attribute->code, $data)) {
                $productAttribute_array[] = array(

                    'product_design_id' => $design_id,
                    'product_attribute_id' => $attribute->id,
                    'product_attribute_value_id' => $data[$attribute->code],
                );
            }
        }
        ProductDesignAttributeValueSave::where('product_design_id', $design_id)->delete();
        ProductDesignAttributeValueSave::insert($productAttribute_array);
    }

    private function priceSave($input, $design_id)
    {
        $price = new ProductDesignPrice;
        $price->product_design_id = $design_id;
        $price->price = $input->price;
        $price->splPrice = $input->splPrice;
        $price->startDate = $input->startDate;
        $price->endDate = $input->endDate;
        $price->save();
        return $price;
    }

    private function priceSaveEdit($input, $design_id, $id)
    {
        $price = ProductDesignPrice::find($id);
        $price->product_design_id = $design_id;
        $price->price = $input->price;
        $price->splPrice = $input->splPrice;
        $price->startDate = $input->startDate;
        $price->endDate = $input->endDate;
        $price->save();
        return $price;
    }

    private function videoSave($input, $design_id)
    {
        foreach ($input->video as $key => $video) {
            if (!empty($video)) {
                ProductDesignVideo::create([
                    'product_design_id' => $design_id,
                    'name' => $video,
                ]);
            }
        }
    }

    private function videoSaveEdit($input, $design_id)
    {
        ProductDesignVideo::where('product_design_id', $design_id)->delete();
        foreach ($input->video as $key => $video) {
            if (!empty($video)) {
                ProductDesignVideo::create([
                    'product_design_id' => $design_id,
                    'name' => $video,
                ]);
            }
        }
    }

    private function weightSave($input, $design_id)
    {
        $weight = new ProductDesignWeight;
        $weight->product_design_id = $design_id;
        $weight->inventory_unit_id = $input->weightUnit;
        $weight->weight = $input->weight;
        $weight->save();
        return $weight;
    }

    private function weightSaveEdit($input, $design_id, $id)
    {
        $weight = ProductDesignWeight::find($id);
        $weight->product_id =   $design_id;
        $weight->inventory_unit_id = $input->weightUnit;
        $weight->weight = $input->weight;
        $weight->save();
        return $weight;
    }

    private function imageSave($request, $design_id)
    {
        if ($request->hasFile('p_image')) //Check if the file exists
        {
            $image = $request->file('p_image'); //Grab and store the file on to $image
            $filename = Str::slug($request->name, '-') . '-' . Str::slug(pathinfo($request->p_image->getClientOriginalName(), PATHINFO_FILENAME), '-') . '-' . time() . '.' . $image->getClientOriginalExtension(); //Create a new filename
            $location = public_path('images/product/design/' . $filename);
            Image::make($image)->resize(800, 800)->save($location); //Use intervention to create an image model and store the file with the resize.

            ProductDesignImage::create([
                'product_design_id' => $design_id,
                'position_id' => 1,
                'name' => $filename,
            ]);
        }

        if ($request->hasFile('s_image')) //Check if the file exists
        {
            $image = $request->file('s_image'); //Grab and store the file on to $image
            $filename = Str::slug($request->name, '-') . '-' . Str::slug(pathinfo($request->s_image->getClientOriginalName(), PATHINFO_FILENAME), '-') . '-' . time() . '.' . $image->getClientOriginalExtension(); //Create a new filename
            $location = public_path('images/product/design/' . $filename);
            Image::make($image)->resize(800, 800)->save($location); //Use intervention to create an image model and store the file with the resize.

            ProductDesignImage::create([
                'product_design_id' => $design_id,
                'position_id' => 2,
                'name' => $filename,
            ]);
        }

        if ($request->hasFile('album')) //Check if the file exists
        {
            $count = 1;
            foreach ($request->only('album') as $files) {
                foreach ($files as $file) {
                    if (is_file($file)) {    // not sure this is needed
                        $filename = Str::slug($request->name, '-') .'-album' .'-' . $count . '-' . time() . '.' . $file->getClientOriginalExtension();
                        $location = public_path('images/product/design/' . $filename);
                        Image::make($file)->resize(800, 800)->save($location); // path to file
                        ProductDesignImage::create([
                            'product_design_id' => $design_id,
                            'position_id' => 3,
                            'name' => $filename,
                        ]);
                        $count++;
                    }
                }
            }
        }
    }

    private function imageSaveEdit($request, $design_id)
    {
        if ($request->hasFile('p_image')) //Check if the file exists
        {
            $image = $request->file('p_image'); //Grab and store the file on to $image
            $filename = Str::slug($request->name, '-') . '-' . Str::slug(pathinfo($request->p_image->getClientOriginalName(), PATHINFO_FILENAME), '-') . '-' . time() . '.' . $image->getClientOriginalExtension(); //Create a new filename
            $location = public_path('images/product/design/' . $filename);
            Image::make($image)->resize(800, 800)->save($location); //Use intervention to create an image model and store the file with the resize.

            $oldImages1 = ProductDesignImage::where('product_design_id', $design_id)->get();
            foreach ($oldImages1 as $oldImage1) {
                if ($oldImage1->position_id == 1) {
                    Storage::delete('product/design/' . $oldImage1->name);
                    $oldImage1->delete();
                }
            }

            ProductDesignImage::create([
                'product_design_id' => $design_id,
                'position_id' => 1,
                'name' => $filename,
            ]);
        }

        if ($request->hasFile('s_image')) //Check if the file exists
        {
            $image = $request->file('s_image'); //Grab and store the file on to $image
            $filename = Str::slug($request->name, '-') . '-' . Str::slug(pathinfo($request->s_image->getClientOriginalName(), PATHINFO_FILENAME), '-') . '-' . time() . '.' . $image->getClientOriginalExtension(); //Create a new filename
            $location = public_path('images/product/design/' . $filename);
            Image::make($image)->resize(800, 800)->save($location); //Use intervention to create an image model and store the file with the resize.

            $oldImages2 = ProductDesignImage::where('product_design_id', $design_id)->get();
            foreach ($oldImages2 as $oldImage2) {
                if ($oldImage2->position_id == 2) {
                    Storage::delete('product/design/' . $oldImage2->name);
                    $oldImage2->delete();
                }
            }

            ProductDesignImage::create([
                'product_design_id' => $design_id,
                'position_id' => 2,
                'name' => $filename,
            ]);
        }

        if ($request->hasFile('album')) //Check if the file exists
        {
            $count = 1;
            foreach ($request->only('album') as $files) {
                foreach ($files as $file) {
                    if (is_file($file)) {    // not sure this is needed
                        $filename = Str::slug($request->name, '-') . '-album' . '-' . $count . '-' . time() . '.' . $file->getClientOriginalExtension();
                        $location = public_path('images/product/design/' . $filename);
                        Image::make($file)->resize(800, 800)->save($location); // path to file
                        ProductDesignImage::create([
                            'product_design_id' => $design_id,
                            'position_id' => 3,
                            'name' => $filename,
                        ]);
                        $count++;
                    }
                }
            }
        }
    }
}
