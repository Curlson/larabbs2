<?php
/**
 * Created by PhpStorm.
 * User: Freelancer
 * Date: 2019/7/1
 * Time: 16:17
 */

namespace App\Handlers;


use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageUploadHandler
{
    // 只允许以下后缀名的图片文件上传
    protected $allowed_ext = ['png', 'jpg', 'gif', 'jpeg'];
    
    /**
     * @param UploadedFile $file
     * @param $folder
     * @param $file_prefix
     * @return array|bool
     */
    public function save($file, $folder, $file_prefix, $max_width)
    {
        // 构建存储的文件夹规则，值如： uploads/images/avatars/201909/21/
        // 文件夹切割能让查找效率更高。
        $folder_name = "uploads/images/{$folder}/" . date("Ym/d", time());
        
        // 文件具体存储的物理路径，`public_path()` 获取的是 `public` 文件夹的物理路径。
        // 值如：/home/vagrant/Code/larabbs/public/uploads/images/avatars/201909/21
        $upload_path = public_path() . '/' . $folder_name;
        
        // 获取文件的后缀那个，因图片从剪贴板里黏贴时后缀名为空，所以磁珠确保后缀名一直存在
        $extension = strtolower($file->getClientOriginalExtension()) ?: 'png';
        
        // 拼接文件名，加前缀时为了增加辨析度，前缀可以时相关数据模型的 ID
        // 值如：1_149878799_7vB812.png
        $file_name = $file_prefix . '_' . time() . '_' . Str::random(10) . '.' . $extension;
        
        // 如果上传的不是图片将终止操作
        if( ! in_array($extension, $this->allowed_ext)) {
            return false;
        }
        
        // 将图片移动到我们的目标存储路径中
        $file->move($upload_path, $file_name);
        
        // 如果限制了图片快递, 就进行裁剪
        if($max_width && $extension != 'git') {
            $this->reduceSize($upload_path . '/' . $file_name, $max_width);
        }
        
        return [
            'path' => config('app.url') . "/{$folder_name}/{$file_name}"
        ];
    }
    
    private function reduceSize(string $file_path, $max_width)
    {
        // 先治理华, 传参是文件的磁盘物理路径
        $image = Image::make($file_path);
        
        // 进行大小调整的操作
        $image->resize($max_width, null, function ($constraint) {
            
            // 设定宽度是 $max_width, 高度等比例双方缩放
            $constraint->aspectRatio();
            
            // 防止裁图时图片尺寸变大
            $constraint->upsize();
        });
        
        // 对图片修改后进行保存
        $image->save();
    }
}
