<?php

use Dcat\Admin\Admin;
use Dcat\Admin\Grid;
use Dcat\Admin\Form;
use Dcat\Admin\Grid\Filter;
use Dcat\Admin\Show;
use Dcat\Admin\Layout\Navbar;
/**
 * Dcat-admin - admin builder based on Laravel.
 * @author jqh <https://github.com/jqhph>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 *
 * extend custom field:
 * Dcat\Admin\Form::extend('php', PHPEditor::class);
 * Dcat\Admin\Grid\Column::extend('php', PHPEditor::class);
 * Dcat\Admin\Grid\Filter::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */
Admin::navbar(function (Navbar $navbar) {
    $url = admin_url('clear/redis');
    $web_url = config('app.url');
    $product_html = \App\Admin\Actions\Grid\ProductGroupReset::make()->render();


    $navbar->right(
        <<<HTML
        $product_html
        <button class="btn btn-primary" onclick="window.location.href='$url'" style="margin-right: 20px"><i class="fa fa-circle-o-notch"></i> 刷新缓存 </button>
        <button class="btn btn-primary" onclick="window.location.href='$web_url'" style="margin-right: 20px"><i class="fa fa fa-globe"></i> 前往前台 </button>
HTML

    );

});

Admin::style(<<<STYLE
footer{
    display:none;
}
STYLE
);


// 注册前端组件别名
Admin::asset()->alias('@wang-editor', [
    'js' => ['/vendor/wangEditor5/index.js'],
    'css'=>['/vendor/wangEditor5/style.css']
]);

Form::extend('weditor', \App\Extensions\Form\WangEditor::class);

Form::extend('multipleImage2', \App\Extensions\Form\MultipleImage2::class);

Admin::favicon(app('cache.config')->get('favicon')?asset_upload(app('cache.config')->get('favicon')):null);


Grid::resolving(function (Grid $grid) {
    $grid->disableViewButton();
    $grid->disableRowSelector();
    $grid->disableRefreshButton();
    $grid->withBorder();
    $grid->toolsWithOutline(false);

});

Form::resolving(function(Form $form){
    $form->disableViewButton();
    $form->disableDeleteButton();
    $form->disableResetButton();
    $form->disableViewCheck();
    $form->disableEditingCheck();
});
