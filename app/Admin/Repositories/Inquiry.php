<?php

namespace App\Admin\Repositories;

use App\Models\Inquiry as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Inquiry extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
