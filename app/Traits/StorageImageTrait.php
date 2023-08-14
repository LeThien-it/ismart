<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

trait StorageImageTrait
{
    public function uploadImageTrait($file,$folderName)
    {
        $fileNameOrigin = $file->getClientOriginalName();
        $fileNameHash = Str::random(27) . "." . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('public/' . auth()->id() . '/' . $folderName, $fileNameHash);

        $dataUploadTrait = [
            'file_name' => $fileNameOrigin,
            'file_path' => Storage::url($filePath) //mục đích để đổi tên public ở storeAs thành storage giống tên folder nằm trong thư mục public
        ];
        return $dataUploadTrait;
    }
}
