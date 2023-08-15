<?php


namespace App\Extensions\Form;

use Dcat\Admin\Form\Field;

class WangEditor extends Field
{


    protected $view = 'admin.extensions.wang-editor';


    protected $options = [
        'height' => 400,
        'mode'  => 'default'
    ];


    public function height(int $height){
        return $this->mergeOptions(['height' => $height]);
    }

    public function simple(){
        return $this->mergeOptions(['mode' => 'simple']);
    }

    /**
     * @return array
     */
    protected function formatOptions()
    {


        return $this->options;
    }

    /**
     * @return string
     */
    public function render()
    {
        $this->addVariables([
            'options' => $this->formatOptions(),
        ]);


        return parent::render();
    }
}
