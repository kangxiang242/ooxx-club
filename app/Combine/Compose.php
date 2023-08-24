<?php


namespace App\Combine;


use App\Models\Area;
use App\Models\Audio;
use App\Models\Birthplace;
use App\Models\Category;
use App\Models\Picture;
use App\Models\Product;
use App\Models\ProductAddedServe;
use App\Models\ProductCategory;
use App\Models\ProductPrice;
use App\Models\ProductQuick;
use App\Models\ProductWithServe;
use App\Models\Quick;
use App\Models\Serve;
use App\Models\Video;
use App\Services\ConfigService;
use Illuminate\Support\Facades\Cache;

class Compose
{
    protected $nicknames = [];

    protected $comment = [];

    protected $picture;

    protected $video;

    protected $category;

    protected $area;

    protected $comment_picture;

    protected $videos;

    protected $audios1;

    protected $audios2;

    protected $outgoing_price;

    protected $fixation_price;

    protected $quicks;

    protected $serves;

    protected $product_ids;

    protected $type;

    protected $birthplace;



    public function __construct()
    {
        $nickname = app(ConfigService::class)->get('nickname');
        $this->nicknames = collect(explode(' ',$nickname));



        $comment = app(ConfigService::class)->get('comment_picture');
        $this->comment = collect(explode(',',$comment));

        $this->picture = Picture::get()->shuffle();

        $this->video = Video::where('status',1)->get();


        $this->category = Category::with('sub')->where('parent_id',0)->get();

        $this->area = Area::with('sub')->where('status',1)->where('parent_id',0)->get();

        $this->comment_picture = collect(array_filter(explode(',',app(ConfigService::class)->get('comment_picture'))));

        $this->videos = Video::where('status',1)->get()->shuffle();

        $this->audios1 = Audio::where('status',1)->where('type',0)->get()->shuffle();

        $this->audios2 = Audio::where('status',1)->where('type',1)->get()->shuffle();

        $this->fixation_price = collect(explode(',',app(ConfigService::class)->get('fixation_price')));

        $this->outgoing_price = collect(explode(',',app(ConfigService::class)->get('outgoing_price')));

        $this->quicks = Quick::all();

        $this->serves = Serve::all();

        $this->product_ids = Product::where('sham',1)->pluck('id');

        $this->birthplace = Birthplace::where('status',1)->get();


    }


    public function start(){
        ConfigService::cache();
        $birthplace_rules = json_decode(app(ConfigService::class)->get('birthplace_rules'),true);

        foreach($this->nicknames->shuffle() as $name){

            if($this->picture->count()<=0){ //图片使用完 不再生成
                break;
            }

            $picture = $this->picture->pop();
            if(!$picture->image){
                continue;
            }
            $images = collect(explode(',',$picture->image));


            $video = $this->videos->pop();
            $this->videos->prepend($video);



            $comment_picture = [];
            $comment_count = rand(3,5);
            for ($i=0;$i<$comment_count;$i++){
                $temp_image = $this->comment_picture->pop();
                $comment_picture[] = $temp_image;
                $this->comment_picture->prepend($temp_image);
            }



            $birthplace = $this->findBirthplaceById($picture->birthplace_id);
            $outgoing = 0;
            $fixation = 0;
            switch ($birthplace->allow_type){
                case 1:
                    $outgoing = 1;
                    break;
                case 2:
                    $fixation = 1;
                    break;
                default:
                    rand(1,2) == 1?$outgoing = 1:$fixation = 1;
            }

            $category_ids = [];
            foreach($this->category as $cate){
                $is_on = true;
                if($cate->id == 4 && rand(1,10)>3){
                    $is_on = false;
                }
                if($is_on){
                    $res_id = $this->birthplaceRules($birthplace->id,$birthplace_rules,$cate->sub->pluck('id'));
                    if($res_id){
                        $category_ids = array_merge($category_ids,$res_id);
                    }
                }

            }

            $pose = collect($this->rules($category_ids));

            $price = $pose->get('price');
            if(!$price){
                if($birthplace->price_range){
                    $price = collect(explode(',',$birthplace->price_range))->random();
                }else{
                    if($fixation && !$outgoing){
                        $price = $this->fixation_price->random()?:2500;
                    }else{
                        $price = $this->outgoing_price->random()?:3000;
                    }
                }
            }

            if($birthplace->use_audio_type == 1){
                $audio = $this->audios2->pop();
                $this->audios2->prepend($audio);
            }else{
                $audio = $this->audios1->pop();
                $this->audios1->prepend($audio);
            }



            $area = $this->area->random();
            $data = [
                'birthplace_id'=>$birthplace->id,
                'name'=>$name,
                'cover'=>$images->first(),
                'age'=>$pose->get('age',$this->getAge()),
                'height'=>$pose->get('height',$this->getHeight()),
                'weight'=>$pose->get('weight',$this->getWeight()),
                'cup'=>$pose->get('cup',$this->getCup()),
                'area_city'=>$area->id,
                'area_county'=>$area->sub->random()->id,
                'price_start'=>$price,
                'price_end'=>$price*3,
                'picture'=>$picture->image,
                'comment_picture'=>implode(',',$comment_picture),
                'video'=>$video->video,
                'video_cover'=>$video->cover,
                'audio'=>$audio->audio,
                'audio_time'=>$audio->duration,
                'sham'=>1,
                'outgoing'=>$outgoing,
                'fixation'=>$fixation,
            ];



            if($this->product_ids->count()>0){
                $product_id = $this->product_ids->shift();
                Product::where('id',$product_id)->update($data);
                ProductPrice::where('product_id',$product_id)->delete();
                ProductQuick::where('product_id',$product_id)->delete();
                ProductWithServe::where('product_id',$product_id)->delete();
                ProductAddedServe::where('product_id',$product_id)->delete();
                ProductCategory::where('product_id',$product_id)->delete();
                Cache::forget('goods-'.$product_id);
            }else{
                $product = Product::create($data);
                $product_id = $product->id;
            }


            $price_insert = [
                [
                    'product_id'=>$product_id,
                    'text'=>'一節/50min/1S',
                    'price'=>$price
                ],
                [
                    'product_id'=>$product_id,
                    'text'=>'兩節/100min/2S',
                    'price'=>$price*2
                ],
                [
                    'product_id'=>$product_id,
                    'text'=>'三節/150min/NS',
                    'price'=>$price*3
                ],
            ];

            ProductPrice::insert($price_insert);


            $quick_ids = $this->quicks->pluck('id');
            $quick_ids = $quick_ids->except('4');
            ProductQuick::create([
                'product_id'=>$product_id,
                'quick_id'=>$pose->get('quick',$quick_ids->random()),
            ]);

            $serve_count = $this->serves->count();

            $serves = $this->serves->shuffle();

            $with_serve_count = rand(8,$serve_count-8);

            $with_serve = $serves->slice(0,$with_serve_count);

            $with_serves_insert = [];
            foreach($with_serve as $serve_item){
                $with_serves_insert[] = [
                    'product_id'=>$product_id,
                    'serve_id'=>$serve_item->id,
                ];
            }
            ProductWithServe::insert($with_serves_insert);


            $added_serve = $serves->slice($with_serve_count,$serve_count-$with_serve_count);

            $added_serves_insert = [];
            foreach($added_serve as $serve_item){
                $serve_price = 0;
                if($serve_item->price){
                    $serve_price = collect(explode(',',$serve_item->price))->random();
                }
                $added_serves_insert[] = [
                    'product_id'=>$product_id,
                    'serve_id'=>$serve_item->id,
                    'price'=>$serve_price,
                ];
            }

            ProductAddedServe::insert($added_serves_insert);


            $product_category_insert = [];
            foreach ($category_ids as $item){
                $product_category_insert[] = [
                    'product_id'=>$product_id,
                    'category_id'=>$item,
                ];
            }
            ProductCategory::insert($product_category_insert);


        }


    }


    /**
     * 茶籍互斥
     *
     * @param $birthplace_id
     * @param $rules
     * @param $category_ids
     * @return bool|\Illuminate\Support\Collection|mixed|\Tightenco\Collect\Support\Collection
     */
    protected function birthplaceRules($birthplace_id,$rules,$category_ids){

        if($category_ids){
            foreach($rules as $rule){
                if($rule['field'] == $birthplace_id){

                    if($rule['operator'] == 'except'){
                        $fruits = $category_ids->diff($rule['value']);
                        if($fruits->isNotEmpty()){
                            return $fruits->random(1)->toArray();
                        }else{
                            return false;
                        }

                    }

                }else{
                    return $category_ids->random(rand(1,$category_ids->count()))->toArray();
                }
            }
        }

    }

    /**
     * 茶籍互斥
     * @param array $category_ids
     * @return array
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function rules($category_ids = []){
        $pose = [];
        if($category_ids){
            $rules = json_decode(app(ConfigService::class)->get('rules'),true);

            foreach($rules as $rule){
                if(in_array($rule['field'],$category_ids)){

                    if($rule['mate'] == 'height'){
                        $pose['height'] = $this->RuleHeight($rule['operator'],$rule['value']);
                    }else if($rule['mate'] == 'weight'){
                        $pose['weight'] = $this->RuleWeight($rule['operator'],$rule['value']);
                    }else if($rule['mate'] == 'age'){
                        $pose['age'] = $this->RuleAge($rule['operator'],$rule['value']);
                    }else if($rule['mate'] == 'cup'){
                        $pose['cup'] = $this->RuleCup($rule['operator'],$rule['value']);
                    }else if($rule['mate'] == 'price'){
                        $pose['price'] = $this->RulePrice($rule['operator'],$rule['value']);
                    }else if($rule['mate'] == 'quick'){
                        $pose['quick'] = $this->RuleQuick($rule['operator'],$rule['value']);
                    }
                }
            }
        }
        return $pose;


    }

    /**
     * 获取随机身高
     *
     * @param null $start
     * @param null $end
     * @return int
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function getHeight($start = null,$end = null){
        $start = $start?:app(ConfigService::class)->get('height_start');
        $end = $end?:app(ConfigService::class)->get('height_end');
        return rand($start,$end);
    }

    /**
     * 获取随机体重
     *
     * @param null $start
     * @param null $end
     * @return int
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function getWeight($start = null,$end = null){
        $start = $start?:app(ConfigService::class)->get('weight_start');
        $end = $end?:app(ConfigService::class)->get('weight_end');
        return rand($start,$end);
    }

    /**
     * 获取随机年龄
     *
     * @param null $start
     * @param null $end
     * @return int
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function getAge($start = null,$end = null){
        $start = $start?:app(ConfigService::class)->get('age_start');
        $end = $end?:app(ConfigService::class)->get('age_end');
        return rand($start,$end);
    }

    /**
     * 获取随机罩杯
     *
     * @return string
     */
    protected function getCup(){
        return collect(['A','B','C','D','E','F','G'])->random();
    }

    /**
     * 获取茶籍
     *
     * @param $id
     * @return mixed
     */
    protected function findBirthplaceById($id){
        return $this->birthplace->firstWhere('id',$id);
    }

    /**
     * 多项拆解
     *
     * @param $value
     * @param string $delimiter
     * @return \Illuminate\Support\Collection|mixed|\Tightenco\Collect\Support\Collection
     */
    protected function Disassemble($value,$delimiter='|'){
        return collect(explode($delimiter,$value));
    }


    /**
     * 体重规则
     *
     * @param $operator
     * @param $value
     * @return \Illuminate\Support\Collection|int|mixed|\Tightenco\Collect\Support\Collection
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function RuleHeight($operator,$value){
        switch ($operator){
            case ">=":
                $height = $this->getHeight($value);
                break;
            case "<=":
                $height = $this->getHeight(null,$value);
                break;
            case "=":
                $height = $value;
                break;
            case "random":
                $height = $this->Disassemble($value,',')->random();
                break;
            case "contain":
                $height = $this->Disassemble($value)->random();
                break;
            case "not_contain":
                $height = $this->getHeight();
                break;
            default:
                $height = $this->getHeight();

        }
        return $height;
    }


    /**
     * 身高规则
     *
     * @param $operator
     * @param $value
     * @return \Illuminate\Support\Collection|int|mixed|\Tightenco\Collect\Support\Collection
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function RuleWeight($operator,$value){
        switch ($operator){
            case ">=":
                $weight = $this->getWeight($value);
                break;
            case "<=":
                $weight = $this->getWeight(null,$value);
                break;
            case "=":
                $weight = $value;
                break;
            case "random":
                $weight = $this->Disassemble($value,',')->random();
                break;
            case "contain":
                $weight = $this->Disassemble($value)->random();
                break;
            case "not_contain":
                $weight = $this->getWeight();
                break;
            default:
                $weight = $this->getWeight();

        }
        return $weight;
    }

    /**
     * 年龄规则
     *
     * @param $operator
     * @param $value
     * @return \Illuminate\Support\Collection|int|mixed|\Tightenco\Collect\Support\Collection
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function RuleAge($operator,$value){
        switch ($operator){
            case ">=":
                $age = $this->getAge($value);
                break;
            case "<=":
                $age = $this->getAge(null,$value);
                break;
            case "=":
                $age = $value;
                break;
            case "random":
                $age = $this->Disassemble($value,',')->random();
                break;
            case "contain":
                $age = $this->Disassemble($value)->random();
                break;
            case "not_contain":
                $age = $this->getAge();
                break;
            default:
                $age = $this->getAge();

        }
        return $age;
    }

    /**
     * 罩杯规则
     *
     * @param $operator
     * @param $value
     * @return \Illuminate\Support\Collection|int|mixed|\Tightenco\Collect\Support\Collection
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function RuleCup($operator,$value){
        switch ($operator){
            case "=":
                $cup = $value;
                break;
            case "random":
                $cup = $this->Disassemble($value,',')->random();
                break;
            case "contain":
                $cup = $this->Disassemble($value)->random();
                break;
            default:
                $cup = $this->getAge();

        }
        return $cup;
    }

    /**
     * 价格规则
     *
     * @param $operator
     * @param $value
     * @return \Illuminate\Support\Collection|int|mixed|\Tightenco\Collect\Support\Collection
     */
    protected function RulePrice($operator,$value){
        switch ($operator){
            case "=":
                $price = $value;
                break;
            case "random":
                $price = $this->Disassemble($value,',')->random();
                break;
            default:
                $price = 0;

        }
        return $price;
    }

    /**
     * 价格规则
     *
     * @param $operator
     * @param $value
     * @return \Illuminate\Support\Collection|int|mixed|\Tightenco\Collect\Support\Collection
     */
    protected function RuleQuick($operator,$value){
        switch ($operator){
            case "=":
                $quick = $value;
                break;
            case "random":
                $quick = $this->Disassemble($value,',')->random();
                break;
            default:
                $quick = 0;

        }
        return $quick;
    }

    /**
     * 茶籍规则
     *
     * @param $operator
     * @param $value
     * @return \Illuminate\Support\Collection|mixed|\Tightenco\Collect\Support\Collection
     */
    protected function RuleBirthplace($operator,$value){

        switch ($operator){
            case "=":
                $cup = collect($value)->first();
                break;
            case "contain":
                $cup = collect($value)->random();
                break;
            default:
               // $cup = $this->getBirthplace();

        }
        return $cup;
    }

    /**
     * 权重分配
     * @param $data
     * @return mixed
     */
    protected function roundWeight($data){
        $weight = 0;
        $tempdata = array ();
        foreach ($data as $one) {
            $weight += $one['weight'];
            for ($i = 0; $i < $one['weight']; $i++) {
                $tempdata[] = $one;
            }
        }
        $use = rand(0, $weight -1);
        $one = $tempdata[$use];
        return $one;
    }


}
