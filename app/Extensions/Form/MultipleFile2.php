<?php

namespace App\Extensions\Form;


use App\Admin\Actions\Form\CommentBatchDelete;
use Dcat\Admin\Form\Field\MultipleFile;

class MultipleFile2 extends MultipleFile
{
    protected $view = 'admin.extensions.file';

    public function __construct($column, $arguments = [])
    {
        parent::__construct($column, $arguments);

        $this->options['reset_btn'] = CommentBatchDelete::make();

    }
}
