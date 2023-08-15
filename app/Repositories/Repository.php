<?php


namespace App\Repositories;

use Illuminate\Support\Facades\Cache;
class Repository
{
    /**
     * 缓存实例
     */
    protected $cache;

    /**
     * @var string
     */
    protected $eloquentClass;

    /**
     * 创建一个新的仓库实例
     *
     * @param  \Illuminate\Support\Facades\Cache  $cache
     * @return void
     */
    public function __construct(Cache $cache)
    {
        $this->cache = $cache;
    }

}
