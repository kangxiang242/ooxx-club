<?php

namespace App\Admin\Repositories;

use App\Models\Anchor as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Anchor extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
