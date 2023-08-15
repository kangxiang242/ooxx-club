<?php

namespace App\Admin\Repositories;

use App\Models\Quick as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Quick extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
