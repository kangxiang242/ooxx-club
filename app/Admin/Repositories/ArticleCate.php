<?php

namespace App\Admin\Repositories;

use App\Models\ArticleCate as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class ArticleCate extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
