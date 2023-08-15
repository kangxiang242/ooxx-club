<?php

namespace App\Http\Controllers\Web;

use App\Exceptions\MsgException;
use App\Http\Requests\OrderStoreRequest;
use App\Models\Product;
use App\Repositories\OrderRepository;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Validator;
class OrderController extends BaseController
{
    /**
     * @var OrderRepository
     */
    private $orderRepository;

    /**
     * OrderController constructor.
     * @param OrderRepository $orderRepository
     */
    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }


    /**
     * 订单查询
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function check(Request $request){

        if($request->isMethod('POST')){

            if($request->no){
                $order = $this->orderRepository->getByNo(trim($request->no));
            }else{
                $validator = Validator::make($request->all(), [
                    'name' => 'required',
                    'phone' => 'required',
                ],[
                    'name.required'=>'請填寫訂購人姓名',
                    'phone.required'=>'請填寫訂購電話',
                ]);

                if ($validator->fails()) {
                    $errors = $validator->errors();
                    return response()->json(['code'=>400,'message'=>$errors->first()]);
                }
                $order = $this->orderRepository->getByNamePhone($request->name,$request->phone);
            }

            if($order){
                return response()->json(['code'=>200,'message'=>'訂單查詢成功','jump'=>url('check/'.$order->no.'?source=check')]);
            }else{
                return response()->json(['code'=>400,'message'=>'您所查詢的訂單不存在']);

            }
        }

        return view('web.order.check');
    }



    /**
     * 订单查询成功页
     * @param $no
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function checking($no){

        $order = $this->orderRepository->getByNo($no);

        if(!$order){
            abort(404);
        }
        return view('web.order.show',compact('order'));
    }

    /**
     * 下单成功页
     *
     * @param $no
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function succeed($no)
    {
        $order = $this->orderRepository->getByNo($no);

        if(!$order){
            abort(404);
        }
        return view('web.order.succeed',compact('order'));
    }

    /**
     * 订单结算页
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function checkout($id,Request $request){
        $goods = Product::where('id',$id)->where('status',1)->first();
        if (!$goods){
            abort(404);
        }

        //token 防止多次提交
        $form_token = md5(time());
        //将token存入session
        $request->session()->put('form_token',$form_token);
        return view('web.order.checkout',compact('form_token','goods'));
    }

    /**
     * 兼容旧站下单页
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function checkout2(Request $request){
        $goods = Product::where('status',1)->first();
        if (!$goods){
            abort(404);
        }

        //token 防止多次提交
        $form_token = md5(time());
        //将token存入session
        $request->session()->put('form_token',$form_token);
        return view('web.order.checkout',compact('form_token','goods'));
    }


    /**
     * 订单提交
     * @param OrderStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(OrderStoreRequest $request){
        try {

            $form_token = $request->input('form_token');
            if( !$request->session()->get('form_token') || $request->session()->get('form_token')!=$form_token ){
                throw new MsgException('請勿重複提交！');
            }
            $request->session()->put('form_token',null);

            $products = Product::where('id',$request->goods_id)->where('status',1)->get();
            if(!$products || $products->isEmpty()){
                throw new MsgException('商品数据有误！');
            }

            $order = $this->orderRepository->store($request->all(),$products);

            session()->flash('flash',json_encode(['type'=>'tips','msg'=>'訂單提交成功','sub_msg'=>'我們將會儘快為您安排發貨','code'=>200,'form_data'=>request()->except('_token','_method')],JSON_UNESCAPED_UNICODE));

            return response()->json(['code'=>200,'msg'=>'訂單提交成功','data'=>['id'=>$order->no]]);
        }catch (MsgException $exception){
            return response()->json(['code'=>400,'msg'=>$exception->getMessage()],400);
        }catch (QueryException $exception){
            return response()->json(['code'=>400,'msg'=>'系統出現異常！'],400);
        }catch (\Exception $exception){

            return response()->json(['code'=>400,'msg'=>'系統出現異常！'],400);
        }

    }
}
