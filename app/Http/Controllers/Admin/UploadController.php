<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    /**
     * 统一的上传图片
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadImage(Request $request)
    {
        $dir = 'uploads/' . date("Ymd");
        $image_urls = [];
        foreach ($request->files as $key => $file) {
            $path = $request->file($key)->store($dir, 'root');
            $image_urls[] = "/" . $path;
        }
        return response()->json(['code' => 0, 'msg' => '上传成功', 'data' => $image_urls]);
    }

    /**
     * 统一的上传文件
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadFile(Request $request)
    {
        $dir = date("Ymd");
        $file_urls = [];
        foreach ($request->files as $key => $file) {
            $file_name = str_random(32) . "." . $file->getClientOriginalExtension();
            $path = $request->file($key)->storeAs($dir, $file_name);
            $file_urls[] = "/app/" . $path;
        }
        return response()->json(['code' => 0, 'msg' => '上传成功', 'data' => $file_urls]);
    }
}
