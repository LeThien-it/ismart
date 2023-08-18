<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ProductImage;
use App\ProductVariant;
use App\Traits\StorageImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminProductImageController extends Controller
{
    use StorageImageTrait;
    function list(Request $request, $id)
    {
        $kind = $request->kind;
        $count_active = ProductImage::where('product_variant_id', $id)->count();
        $count_trash = ProductImage::where('product_variant_id', $id)
            ->onlyTrashed()
            ->count();
        $count = [$count_active, $count_trash];
        $list_field = [
            'id' => 'ID',
            'image_name' => 'Tên ảnh',
        ];

        if ($kind == 'trash') {
            $images = ProductImage::where('product_variant_id', $id)
                ->onlyTrashed()
                ->paginate(5);
            $list_act = [
                'restore' => 'Khôi phục',
                'forceDelete' => 'Xóa vĩnh viễn',
            ];
        } else {
            $images = ProductImage::where('product_variant_id', $id)->paginate(5);
            $list_act = [
                'delete' => 'Xóa tạm thời',
            ];

            if ($request->search) {
                $field = $request->field;
                $keyword = $request->input('keyword');
                if ($keyword) {
                    $images = ProductImage::where('product_variant_id', $id)
                        ->where($field, 'like', '%' . $keyword . '%')
                        ->paginate(5);
                }
                $keyword1 = $request->input('keyword1');

                if ($keyword1) {
                    $images = ProductImage::where('product_variant_id', $id)
                        ->where($field, 'like', '%' . $keyword1 . '%')
                        ->onlyTrashed()
                        ->paginate(5);
                    $list_act = [
                        'restore' => 'Khôi phục',
                        'forceDelete' => 'Xóa vĩnh viễn',
                    ];
                    return view(
                        'admin.products.images.list-trash',
                        compact(
                            'images',
                            'count',
                            'list_field',
                            'list_act',
                            'id'
                        )
                    );
                }
            }
        }

        return view(
            'admin.products.images.list',
            compact('images', 'list_act', 'count', 'list_field', 'id')
        );
    }

    function add(Request $request, $id)
    {
        $messsages = [
            'image_path.required' => 'Chọn ảnh chi tiết',
            'image_path.*.mimes' =>
                'Ảnh phải thuộc định dạng jpg,png,gif,jpeg,webp',
        ];

        $validator = Validator::make(
            $request->all(),
            [
                'image_path' => ['required', 'array'],
                'image_path.*' => ['required', 'mimes:jpg,png,gif,jpeg,webp'],
            ],
            $messsages
        );

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        foreach ($request->image_path as $fileItem) {
            $dataMultipleImage = $this->uploadImageTrait($fileItem, 'product');
            ProductVariant::find($id)
                ->images()
                ->create([
                    'image_path' => $dataMultipleImage['file_path'],
                    'image_name' => $dataMultipleImage['file_name'],
                ]);
        }

        return redirect()
            ->back()
            ->with('status', 'Thêm hình ảnh thành công');
    }

    function delete($id)
    {
        $image = ProductImage::find($id);
        $image->delete();
        return redirect()
            ->back()
            ->with('status', 'Xóa tạm thời hình ảnh thành công');
    }

    function action(Request $request, $id)
    {
        $listCheck = $request->listCheck;
        $act = $request->act;
        if ($listCheck) {
            if ($act) {
                if ($act == 'delete') {
                    ProductImage::destroy($listCheck);
                    return redirect()
                        ->back()
                        ->with('status', 'Xóa tạm thời hình ảnh thành công');
                }

                if ($act == 'restore') {
                    ProductImage::onlyTrashed()
                        ->whereIn('id', $listCheck)
                        ->restore();
                    return redirect()
                        ->route('product.image.list', ['id' => $id])
                        ->with('status', 'Khôi phục hình ảnh thành công');
                }

                if ($act == 'forceDelete') {
                    foreach ($listCheck as $image_id) {
                        $image = ProductImage::onlyTrashed()->find($image_id);
                        $path = Str::of($image->image_path)->replace(
                            '/storage' . '/',
                            '/'
                        );
                        Storage::disk('public')->delete($path); // mục đích để xóa đường dẫn ảnh cũ trong storage trước khi update
                        $image->forceDelete();
                    }
                    return redirect()
                        ->route('product.image.list', ['id' => $id])
                        ->with('status', 'Xóa vĩnh viễn hình ảnh thành công');
                }
            } else {
                return redirect()
                    ->back()
                    ->with('error', 'Bạn cần chọn tác vụ để thực hiện');
            }
        } else {
            return redirect()
                ->back()
                ->with('error', 'Bạn chưa chọn bản ghi để thực hiện');
        }
    }
}
