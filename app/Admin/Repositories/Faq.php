<?php

namespace App\Admin\Repositories;

use App\Models\Faq as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Faq extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
