<?php

namespace Zu\Editormd\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Validator;

class EditormdController extends Controller
{
    //上传图片的处理
    public function uploadimage(Request $request)
    {
        //这是官网上面上传图片的json返回数据的固定格式
        $json = [
            'success' => 0,
            'message' => '',
            'url'     => '',
        ];
        if ($request->hasFile('editormd-image-file')) {
            $file = $request->file('editormd-image-file');
            $max = [
                'editormd-image-file' => 'max:10240',
            ];
            $message = [
                'editormd-image-file.max' => '上传图片最大不超过10M',
            ];
            $validator = Validator::make($request->all(), $max, $message);
            if ($validator->passes()) {
                $destpath = config("editormd.upload_path");
                $savepath = trim($destpath, '/') . '/' . date('Ymd', time());
                if ($file->isValid()) {
                    $ext = $file->getClientOriginalExtension();
                    if (in_array($ext, ['png', 'jpg', 'jpeg', 'gif'])) {
                        // 获取存储方式，优先使用editormd.php的配置，没有配置时使用filesystems.php的默认配置
                        $storeType = config("editormd.upload_type");
                        if ($storeType === '') {
                            $storeType = config('filesystems.default');
                        }
                        if ($storeType === '' || $storeType === 'local' || $storeType === 'public') {
                            // 本地存储
                            $root = public_path();
                            $folder_name = $savepath;
                            $savepath = rtrim($root, '/'). '/' . $savepath;
                            if (!is_dir($savepath)) {
                                @mkdir($savepath, 0777, true);
                            }
                            $filename = '/' . uniqid() . '_' . date('s') . '.' . $ext;
                            $file->move($savepath, $filename);
                            $realpath = '/' . $folder_name . $filename;
                            $json = array_replace($json, ['success' => 1, 'url' => $realpath]);
                        } else {
                            // 云存储
                            $realpath = $savepath . '/' . uniqid() . '_' . date('s') . '.' . $ext;
                            $disk = \Storage::disk($storeType);
                            $disk->put($realpath, file_get_contents($file));
                            if (config("editormd.upload_http") === 'https') {
                                $realurl = $disk->url($realpath, 'https');
                            } else {
                                $realurl = $disk->url($realpath);
                            }
                            $json = array_replace($json, ['success' => 1, 'url' => $realurl]);
                        }
                    } else {
                        $json = array_replace($json, ['success' => 0, 'meassge' => '文件类型不符合要求']);
                    }
                } else {
                    $json = array_replace($json, ['success' => 0, 'meassge' => $file->getErrorMessage()]);
                }
            } else {
                $json = array_replace($json, ['success' => 0, 'meassge' => $validator->messages()]);
            }
            return response()->json($json);
        }
    }
}
