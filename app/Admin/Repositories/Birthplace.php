<?php

namespace App\Admin\Repositories;

use App\Models\Birthplace as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Birthplace extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
