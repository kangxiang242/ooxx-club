<?php

namespace App\Admin\Actions\Form;

use App\Console\Commands\CacheClear;
use App\Models\Config;
use App\Services\CacheService;
use App\Services\ConfigService;
use Dcat\Admin\Actions\Response;
use Dcat\Admin\Form\AbstractTool;
use Dcat\Admin\Traits\HasPermissions;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CommentBatchDelete extends AbstractTool
{
    /**
     * @return string
     */
	protected $title = '清空所有';

    /**
     * Handle the action request.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function handle(Request $request)
    {




        $comment_pictures = Config::where('name','comment_picture')->first();
        if($comment_pictures){
            $comment_pictures = explode(',',$comment_pictures->content);
            foreach ($comment_pictures as $item){
                $file = public_path('uploads/'.$item);
                if(file_exists($file)){
                    @unlink($file);
                }
            }
            Config::where('name','comment_picture')->delete();
            ConfigService::cache();
        }


        return $this->response()
            ->success('Processed successfully.')
            ->refresh();
    }

    /**
     * @return string|void
     */
    protected function href()
    {
        // return admin_url('auth/users');
    }

    /**
	 * @return string|array|void
	 */
	public function confirm()
	{
		return ['是否全部清空？', '清空后文件將會從服務器上清理'];
	}

    /**
     * @param Model|Authenticatable|HasPermissions|null $user
     *
     * @return bool
     */
    protected function authorize($user): bool
    {
        return true;
    }

    /**
     * @return array
     */
    protected function parameters()
    {
        return [];
    }
}
