<?php

namespace App\Admin\Repositories;

use App\Models\Serve as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Serve extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
