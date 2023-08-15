<?php

namespace App\Admin\Controllers;

use App\Admin\Metrics\Dashboard;
use App\Http\Controllers\Controller;

use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        /*$content->row(function(Row $row){
            $row->column(6, $this->title());

        });
        $content->row(function(Row $row){

            $row->column(6,$this->info());

        });
        return $content;*/

        $content
            ->header('Dashboard')
            ->description('Description...')
            ->body(function (Row $row) {
                $row->column(6, function (Column $column) {
                    $column->row($this->title());
                    $column->row($this->info());
                });

                $row->column(6, function (Column $column) {

                    $column->row(new Dashboard\NewDevices());
                    $column->row(new Dashboard\AccessPage());
                    /*$column->row(new Examples\ProductOrders());*/
                });
            });

        return $content;

        /*return $content
            ->header('Dashboard')
            ->description('Description...')
            ->body(function (Row $row) {
                $row->column(6, function (Column $column) {
                    $column->row(Dashboard::title());
                    $column->row(new Examples\Tickets());
                });

                $row->column(6, function (Column $column) {
                    $column->row(function (Row $row) {
                        $row->column(6, new Examples\NewUsers());
                        $row->column(6, new Examples\NewDevices());
                    });

                    $column->row(new Examples\Sessions());
                    $column->row(new Examples\ProductOrders());
                });
            });*/
    }

    private function title()
    {
        return view('admin.dashboard.title');
    }

    private function info(){
        return view('admin.dashboard.info');
    }
}
