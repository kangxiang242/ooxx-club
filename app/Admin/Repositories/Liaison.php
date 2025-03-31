<?php

namespace App\Admin\Repositories;

use App\Models\Liaison as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Liaison extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
