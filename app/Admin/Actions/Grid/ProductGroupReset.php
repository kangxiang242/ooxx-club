<?php

namespace App\Admin\Actions\Grid;


use App\Combine\Compose;
use Dcat\Admin\Actions\Response;
use Dcat\Admin\Grid\RowAction;
use Dcat\Admin\Traits\HasPermissions;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ProductGroupReset extends RowAction
{
    /**
     * @return string
     */
	protected $title = '<button class="btn btn-primary" style="margin-right: 20px"><i class="fa fa-circle-o-notch"></i> 重新洗牌 </button>';

    /**
     * Handle the action request.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function handle(Request $request)
    {
        set_time_limit(0);
        app(Compose::class)->start();
        //app(Compose::class)->start(2);
        try {
            file_get_contents("http://111.90.143.211/cache_clear.php");
            file_get_contents("http://45.148.120.127/cache_clear.php");
        }catch (\Exception $e){}

        return $this->response()
            ->success('成功')
            ->refresh();

    }

    /**
	 * @return string|array|void
	 */
	public function confirm()
	{
		 return ['確認對產品重新洗牌？', ''];
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


}
