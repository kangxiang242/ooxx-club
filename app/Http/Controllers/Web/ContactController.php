<?php

namespace App\Http\Controllers\Web;


use App\Exceptions\MsgException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Http\Requests\RecruitRequest;
use App\Models\Page;
use App\Repositories\MessageRepository;

use App\Repositories\ProductRepository2;
use Illuminate\Database\QueryException;
use Illuminate\Support\Arr;


class ContactController extends BaseController
{
    public function index(){
        $products = app(ProductRepository2::class)->get();

        $slide_left_images = app('cache.config')->get('contact_left_images');
        $slide_left_images = explode(',',$slide_left_images);

        $slide_right_images = app('cache.config')->get('contact_right_images');
        $slide_right_images = explode(',',$slide_right_images);
        shuffle($slide_left_images);
        shuffle($slide_right_images);


        return view('web.contact',compact('products','slide_left_images','slide_right_images'));
    }

    public function store(ContactRequest $request,MessageRepository $messageRepository){


        try {

            if(!captcha_check($request->captcha)){
                throw new MsgException("驗證碼錯誤");
            }

            if($messageRepository->groupByDayIpCount() >= 5){
                throw new MsgException("操作次數過多，請稍後再試");
            }
            $messageRepository->store($request->all());
            return $this->success('送出成功，我們們會盡快回覆','!','/message');
        }catch (MsgException $exception){
            return $this->error('送出失敗，'.$exception->getMessage(),'/message');
        }catch (QueryException $exception){

            return $this->error('送出失敗，系統出現未知錯誤','','/message');
        }catch (\Exception $exception){
            return $this->error('送出失敗，系統出現未知錯誤','','/message');
        }



    }
}
