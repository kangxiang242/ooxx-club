<?php

namespace App\Admin\Repositories;

use App\Models\Seo as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Seo extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
