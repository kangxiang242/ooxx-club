<?php


namespace App\Admin\Controllers;

use App\Models\Config;
use App\Services\ConfigService;
use Dcat\Admin\Traits\HasUploadedFile;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class FileController
{
    use HasUploadedFile;

    public function handle()
    {
        $disk = $this->disk('admin');

        // 判断是否是删除文件请求
        if ($this->isDeleteRequest()) {
            // 删除文件并响应
            return $this->deleteFileAndResponse($disk);
        }

        // 获取上传的文件
        $file = $this->file();

        // 获取上传的字段名称
        $column = $this->uploader()->upload_column;

        $dir = 'images';
        $newName = md5(uniqid()).'.'.$file->getClientOriginalExtension();

        $result = $disk->putFileAs($dir, $file, $newName);

        $path = "{$dir}/$newName";

        return $result
            ? $this->responseUploaded($path, $disk->url($path))
            : $this->responseErrorMessage('文件上传失败');
    }

    public function googleVerify(){


        // 判断是否是删除文件请求
        if ($this->isDeleteRequest()) {
            $file = public_path(request()->key);
            if(file_exists($file)){
                unlink($file);
            }
            $_column = request('_column');
            $_column = explode('.',$_column);
            $_column = Arr::get($_column,1);
            if($_column){
                Config::where('name',$_column)->delete();
                ConfigService::cache();
            }
            return $this->deleteFileAndResponse();
        }



        $file = $this->file();
        $file_name = $file->getClientOriginalName();

        $path = public_path('/'.$file_name);
        if(move_uploaded_file($file->getPathname(),$path)){
            $response = [
                'data'=>[
                    'id'=>$file_name,
                    'name'=>$file_name,
                    'path'=>$file_name,
                    'url'=>asset($file_name)
                ],
                'status'=>true
            ];
            return json_encode($response);
        }else{
            $this->responseErrorMessage('文件上传失败');
        }

    }

    public function htmlZip(){


        // 判断是否是删除文件请求
        if ($this->isDeleteRequest()) {
            $file = public_path(request()->key);
            if(file_exists($file)){
                unlink($file);
            }

            return $this->deleteFileAndResponse();
        }
        $file = $this->file();
        //$file_name = $file->getClientOriginalName();
        $file_name = md5(uniqid()).'.'.$file->getClientOriginalExtension();
        $path = public_path('/uploads/article_html/'.$file_name);

        if(move_uploaded_file($file->getPathname(),$path)){
            $zip = new \ZipArchive();
            $key = str_replace('.zip','',$file_name);
            $zip->open(public_path('uploads/article_html/'.$file_name));
            $zip->extractTO(public_path('uploads/article_html/'.$key.'/'));
            file_put_contents(public_path('uploads/article_html/'.$key.'/index.html'),"<script>document.domain='xenicalshop.com'</script>",FILE_APPEND);
            $response = [
                'data'=>[
                    'id'=>$file_name,
                    'name'=>$file_name,
                    'path'=>$file_name,
                    'url'=>asset($file_name)
                ],
                'status'=>true
            ];
            return json_encode($response);
        }else{
            $this->responseErrorMessage('文件上传失败');
        }
    }

    public function wangEditorImage(Request $request){

        // 判断是否是删除文件请求
        if ($this->isDeleteRequest()) {
            $file = public_path(request()->key);
            if(file_exists($file)){
                unlink($file);
            }

            return $this->deleteFileAndResponse();
        }

        $file = $request->file('file');


        $file_name = md5(uniqid()).'.'.$file->getClientOriginalExtension();
        $path_file = '/uploads/wang-editor/'.$file_name;

        $path = public_path($path_file);

        if(move_uploaded_file($file->getPathname(),$path)){

            $response = [
                'data'=>[
                    'url'=>$path_file
                ],
                'errno'=>0
            ];
            return json_encode($response);
        }else{
            $response = [

                'errno'=>1,
                'message'=>'上传失败',
            ];
            return json_encode($response);
        }
    }

}
