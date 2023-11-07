<?php

namespace App\Admin\Forms;

use App\Services\ConfigService;
use Dcat\Admin\Widgets\Form;

class Config extends Form
{
    /**
     * Handle the form request.
     *
     * @param array $input
     *
     * @return mixed
     */
    public function handle(array $input)
    {

        foreach($input as $key=>$item){

            if (is_array($item)){
                foreach ($item as $k=>&$val){
                    if(isset($val['_remove_']) && $val['_remove_'] == 1){
                        unset($item[$k]);
                    }
                }
                $item = json_encode($item);
            }


            if($config = \App\Models\Config::where('name',$key)->first()){
                \App\Models\Config::where('id',$config->id)->update([
                    'name'=>$key,
                    'content'=>$item
                ]);
            }else{
                \App\Models\Config::create([
                    'name'=>$key,
                    'content'=>$item
                ]);
            }

        }
        ConfigService::cache();
        return $this
				->response()
				->success('Processed successfully.')
				->refresh();
    }


    /**
     * The data of the form.
     *
     * @return array
     */
    public function default()
    {
        return \App\Models\Config::pluck('content','name')->toArray();

    }
}
