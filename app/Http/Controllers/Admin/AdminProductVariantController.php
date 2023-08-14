<?php

namespace App\Http\Controllers\Admin;

use App\AttributeValue;
use App\Http\Controllers\Controller;
use App\Product;
use App\ProductVariant;
use App\Traits\StorageImageTrait;
use App\Attribute;
use App\Http\Requests\ProductVariantAddRequest;
use App\Http\Requests\ProductVariantUpdateRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminProductVariantController extends Controller
{
    use StorageImageTrait;
    function list(Request $request)
    {
        $kind = $request->kind;
        $count_active = ProductVariant::count();
        $count_trash = ProductVariant::onlyTrashed()->count();

        $count = [$count_active, $count_trash];
        $list_field = [
            'id' => 'ID',
            'product_id' => 'Tên sản phẩm',
        ];

        if ($kind == 'trash') {
            $variants = ProductVariant::onlyTrashed()->latest()->paginate(8);
            $list_act = [
                'restore' => 'Khôi phục',
                'forceDelete' => 'Xóa vĩnh viễn'
            ];
        } else {
            $variants = ProductVariant::latest()->paginate(8);
            $list_act = [
                'delete' => 'Xóa tạm thời'
            ];

            if ($request->search) {
                $field = $request->field;
                $keyword = $request->input('keyword');
                if ($keyword) {
                    if ($field == 'product_id') {
                        $get_id = Product::where('name', 'like', '%' . $keyword . '%')->get();
                        if(count($get_id) > 0){
                            foreach ($get_id as $item) {
                                $ids[] = $item->id;
                            }
                        }else{
                            $ids[] = 0;
                        }
                        $variants = ProductVariant::whereIn($field, $ids)->paginate(8);
                    } else {
                        $variants = ProductVariant::where($field, 'like', '%' . $keyword . '%')->paginate(8);
                    }
                }
                $keyword1 = $request->input('keyword1');

                if ($keyword1) {
                    if ($field == 'product_id') {
                        $get_id = Product::where('name', 'like', '%' . $keyword1 . '%')->get();
                        if(count($get_id) > 0){
                            foreach ($get_id as $item) {
                                $ids[] = $item->id;
                            }
                        }else{
                            $ids[] = 0;
                        }
                        $variants = ProductVariant::whereIn($field, $ids)->onlyTrashed()->paginate(8);
                    } else {
                        $variants = ProductVariant::where($field, 'like', '%' . $keyword1 . '%')->onlyTrashed()->paginate(8);
                    }
                    $list_act = [
                        'restore' => 'Khôi phục',
                        'forceDelete' => 'Xóa vĩnh viễn'
                    ];
                    return view('admin.products.variants.list-trash', compact('variants', 'list_field', 'list_act', 'count'));
                }
            }
        }
        return view('admin.products.variants.list', compact('variants', 'list_field', 'list_act', 'count'));
    }

    function add()
    {
        $attributes = Attribute::where('status', 1)->get();
        $products = Product::where('status', 1)->latest()->get();
        return view('admin.products.add.add-variant', compact('attributes', 'products'));
    }

    function store(ProductVariantAddRequest $request)
    {
        $dataFeatureImage = $this->uploadImageTrait($request->feature_image_path, 'product');

        $data = [
            'product_id' => $request->product_id,
            'feature_image_path' => $dataFeatureImage['file_path'],
            'feature_image_name' => $dataFeatureImage['file_name'],
            'price' => $request->price,
            'price_old' => $request->price_old,
            'quantity' => $request->quantity,
            'discount' => $request->discount,
            'display_style' => $request->display_style,
            'show_search' => $request->show_search,
        ];

        $variant = ProductVariant::create($data);
        $attributeValueIds = $request->attribute_value_id;
        $variant->attributeValues()->attach($attributeValueIds);
        if ($request->hasFile('image_path')) {
            foreach ($request->image_path as $fileItem) {
                $dataMultipleImage = $this->uploadImageTrait($fileItem, 'product');
                $variant->images()->create([
                    'image_path' => $dataMultipleImage['file_path'],
                    'image_name' => $dataMultipleImage['file_name'],
                ]);
            }
        }

        return redirect()->route('product.variant.list')->with('status', 'thêm sản phẩm thành công');
    }

    function edit($id)
    {
        $attributes = Attribute::where('status', 1)->get();
        $products = Product::where('status', 1)->latest()->get();
        $variant = ProductVariant::find($id);
        foreach ($variant->attributeValues as $value) {
            $check[] = $value->id;
        }
        return view('admin.products.variants.edit', compact('variant', 'products', 'attributes', 'check'));
    }

    function update(ProductVariantUpdateRequest $request, $id)
    {
        $data = [
            'product_id' => $request->product_id,
            'price' => $request->price,
            'price_old' => $request->price_old,
            'quantity' => $request->quantity,
            'discount' => $request->discount,
            'display_style' => $request->display_style,
            'show_search' => $request->show_search,
        ];
        $variant = ProductVariant::find($id);
        if ($request->hasFile('feature_image_path')) {
            $path = Str::of($variant->feature_image_path)->replace('/storage' . "/", "/");
            Storage::disk('public')->delete($path); // mục đích để xóa ảnh cũ sau khi update
            $dataFeatureImage = $this->uploadImageTrait($request->feature_image_path, 'product');
            $data['feature_image_path'] = $dataFeatureImage['file_path'];
            $data['feature_image_name'] = $dataFeatureImage['file_name'];
        }

        $variant->update($data);

        //Cập nhật thuộc tính
        if ($request->attribute_value_id) {
            $attributeValueIds = $request->attribute_value_id;
            $variant->attributeValues()->sync($attributeValueIds);
        }

        //Cập nhật bên bảng product images
        if ($request->hasFile('image_path')) {
            $variant->images()->delete(); // xóa các ảnh trong database trước khi update
            foreach ($variant->images as $item) {
                $path = Str::of($item->image_path)->replace('/storage' . "/", "/");
                Storage::disk('public')->delete($path); // mục đích để xóa đường dẫn ảnh cũ trong storage trước khi update
            }
            foreach ($request->image_path as $image_path) {
                $dataMultipleImage = $this->uploadImageTrait($image_path, 'product');
                $variant->images()->create([
                    'image_path' => $dataMultipleImage['file_path'],
                    'image_name' => $dataMultipleImage['file_name'],
                ]);
            }
        }

        return redirect()->route('product.variant.list')->with('status', 'Cập nhật sản phẩm thành công');
    }

    function delete($id)
    {
        $variant = ProductVariant::find($id);
        $variant->delete();
        return redirect()->route('product.variant.list')->with('status', 'Xóa tạm thời thành công');
    }


    function action(Request $request)
    {
        $listCheck = $request->listCheck;
        $act = $request->act;

        if ($listCheck) {
            if ($act) {
                if ($act == 'delete') {
                    ProductVariant::destroy($listCheck);
                    return redirect()->route('product.variant.list')->with('status', 'Bạn đã xóa tạm thời thành công');
                }

                if ($act == "restore") {
                    ProductVariant::onlyTrashed()->whereIn('id', $listCheck)->restore();
                    return redirect()->route('product.variant.list')->with('status', 'Bạn đã khôi phục thành công');
                }

                if ($act == "forceDelete") {
                    foreach ($listCheck as $id) {
                        $variant = ProductVariant::onlyTrashed()->find($id);
                        $path = Str::of($variant->feature_image_path)->replace('/storage' . "/", "/");
                        Storage::disk('public')->delete($path);
                        foreach ($variant->images as $item) {
                            $path = Str::of($item->image_path)->replace('/storage' . "/", "/");
                            Storage::disk('public')->delete($path); // mục đích để xóa đường dẫn ảnh cũ trong storage trước khi update
                        }

                        $variant->attributeValues()->detach();
                        $variant->images()->forceDelete();
                        $variant->forceDelete();
                    }

                    return redirect()->route('product.variant.list')->with('status', 'Bạn đã xóa vĩnh viễn thành công');
                }
            } else {
                return redirect()->back()->with('error', 'Bạn cần chọn tác vụ để thực hiện');
            }
        } else {
            return redirect()->back()->with('error', 'Bạn chưa chọn bản ghi để thực hiện');
        }
    }
}
