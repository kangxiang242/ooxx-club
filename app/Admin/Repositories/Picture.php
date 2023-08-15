<?php

namespace App\Admin\Repositories;

use App\Models\Picture as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Picture extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
