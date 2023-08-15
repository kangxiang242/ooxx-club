<?php

namespace App\View\Components;

use App\Repositories\BirthplaceRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\QuickRepository;
use App\Repositories\ServeRepository;
use Illuminate\View\Component;

class Filter extends Component
{
    protected $birthplace;

    protected $serve;

    protected $category;

    protected $quick;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        BirthplaceRepository $birthplaceRepository,
        ServeRepository $serveRepository,
        CategoryRepository $categoryRepository,
        QuickRepository $quickRepository
    )
    {

        $this->birthplace = $birthplaceRepository;
        $this->serve = $serveRepository;
        $this->category = $categoryRepository;
        $this->quick = $quickRepository;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {

        $birthplace = $this->birthplace->all();
        $serve = $this->serve->all();
        $category = $this->category->all();
        $quick = $this->quick->all();
        return view('components.filter',compact('birthplace','serve','category','quick'));
    }
}
