<?php


namespace App\Extensions;
use App\Exports\OrdersExport;
use App\Models\Order;
use Dcat\Admin\Grid\Exporters\AbstractExporter;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Facades\Excel;

class OrderExpoter extends AbstractExporter
{
    public function export()
    {
        $data[] = ['訂單號','内單號','商品','總價','名字','電話','郵箱','地址','收貨方式','配送时间','備注','訂單狀態'];
        $order = Order::with('products')->orderBy('created_at','desc');

        $request = request();

        if($input = $request->_search){
            $order = $order->where('no', 'like', "%{$input}%")
                ->orWhere('inside_no', 'like', "%{$input}%")
                ->orWhere('name', 'like', "%{$input}%")
                ->orWhere('phone', 'like', "%{$input}%")
                ->orWhere('email', 'like', "%{$input}%")
                ->orWhere('ip', 'like', "%{$input}%");
        }

        if($request->_export_){
            $selected = str_replace('selected:','',$request->_export_);
            $selected_ids = explode(',',$selected);
            if($selected_ids){
                $order = $order->whereIn('id',$selected_ids);
            }
        }


        if($no = $request->no){
            $order = $order->where('no', $no);
        }

        if($inside_no = $request->inside_no){
            $order = $order->where('inside_no', $inside_no);
        }

        if($ip = $request->ip){
            $order = $order->where('ip', $ip);
        }

        if($name = $request->name){
            $order = $order->where('name', $name);
        }

        if($email = $request->email){
            $order = $order->where('email', $email);
        }

        if($phone = $request->phone){
            $order = $order->where('phone', $phone);
        }

        if($created_at = $request->created_at){
            $start = Arr::get($created_at,'start');
            $end = Arr::get($created_at,'end');
            if($start){
                $order = $order->where('created_at','>=', $start);
            }

            if($end){
                $order = $order->where('created_at','<=', $end);
            }
        }



        $order = $order->get();

        foreach($order as $item){
            $product_txt='';
            foreach($item->products as $k=>$vv){
                $product_txt .= $vv->product_name."({$vv->unit_price}/件)*{$vv->number}";
                if(($k+1) < count($item->products)){
                    $product_txt .= PHP_EOL;
                }
            }
            if($item->delivery_type > 0){
                if($item->delivery_type == 1){
                    $addr = $item->address."（7-11".$item->shop_name."門市".$item->shop_no."自取件）電話通知到店取貨";
                }else{
                    $addr = $item->address."（".$item->shop_name.$item->shop_no."自取件）電話通知到店取貨";
                }

            }else{
                if($item->delivery_time == 1){
                    $gettime = "11:20:00";
                }elseif($item->delivery_time == 2){
                    $gettime = "14:35:00";
                }else{
                    $gettime = "18:50:00";
                }
                $get_deliver_time = explode(':',$gettime);
                if($get_deliver_time[1] == '55'){
                    $get_deliver_time[1] = '00';
                    $get_deliver_time[0] += 0;
                    $get_deliver_time[0] ++;
                    if($get_deliver_time[0] < 10){
                        $get_deliver_time[0] = '0'.$get_deliver_time[0];
                    }
                }else{
                    $get_deliver_time[1] += 5;
                    if($get_deliver_time[1] < 10){
                        $get_deliver_time[1] = '0'.$get_deliver_time[1];
                    }
                }
                $update_gettime = $get_deliver_time[0].":".$get_deliver_time[1].":00";

                $addr = $item->city.$item->county.$item->street.$item->address.'-請於'.substr($update_gettime, 0, 5).'前送達';;
            }

            $delivery_time = "09:00~12:00";
            if(!is_null($item->delivery_time)){
                $delivery_time = Arr::get(Order::DELIVERY_TIME,$item->delivery_time,'');
            }

            $data[] = [
                $item->no,
                $item->inside_no,
                $product_txt,
                $item->total_price,
                $item->name,
                $item->phone,
                $item->email,
                $addr,
                "本人收貨",
                $delivery_time,
                $item->remarks,
                Arr::get(Order::STATUS_TXT,$item->status),

            ];
        }

        $exception = Excel::download(new OrdersExport($data), 'order.xlsx', \Maatwebsite\Excel\Excel::XLSX);



        $filename = $exception->getFile();
        $out_filename = '訂單導出-'.date('YmdHis').'.xlsx';

        header('Accept-Ranges: bytes');
        header('Accept-Length: ' . filesize($filename));

        header('Content-Transfer-Encoding: binary');
        header('Content-type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . $out_filename);
        header('Content-Type: application/octet-stream; name=' . $out_filename);

        if(is_file($filename) && is_readable($filename)){
           $file = fopen($filename, "r");
           echo fread($file, filesize($filename));
           fclose($file);
        }
        exit;

/*        Excel::create('Filename', function($excel) {

            $excel->sheet('Sheetname', function($sheet) {

                // 最多导出10W条数据
                // 必须设置maxSize，当否则选择导出所有选项时只能导出默认的20条数据。
                $maxSize = 10000;

                // 这段逻辑是从表格数据中取出需要导出的字段
                $rows = collect($this->buildData(1, $maxSize))->map(function ($item) {
                    return Arr::only($item, ['id', 'no', 'inside_no']);
                });

                $sheet->rows($rows);

            });

        })->export('xls');*/
    }

}
