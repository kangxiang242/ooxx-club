<?php

namespace App\Admin\Actions\Form;

use App\Console\Commands\CacheClear;
use App\Models\Comment;
use App\Models\Config;
use App\Services\CacheService;
use App\Services\ConfigService;
use Dcat\Admin\Actions\Response;
use Dcat\Admin\Form\AbstractTool;
use Dcat\Admin\Traits\HasPermissions;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        $comment = Comment::get();
        if($comment){
            foreach ($comment as $item){
                $file = public_path('uploads/'.$item->image);
                if(file_exists($file)){
                    @unlink($file);
                }
            }
            DB::select('TRUNCATE TABLE comments;');
            DB::select('ALTER TABLE comments AUTO_INCREMENT=1;');
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
