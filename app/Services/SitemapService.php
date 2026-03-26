<?php


namespace App\Services;


use App\Models\Area;
use App\Models\ArticleCate;
use App\Models\Product;
use App\Models\Topic;


class SitemapService
{
    private $xml = [];

    private $last_mod;

    public function __construct()
    {
        $this->last_mod = date('Y-m-d');
    }


    public function generate(){
        $this->header();
        $this->startUrlSet();
        $this->home();
        //$this->article();
        $this->cate();
        $this->product();
        //$this->page();
        $this->endUrlSet();

        $sitemap = join("\n", $this->xml);
        return $sitemap;
        file_put_contents(public_path('sitemap.xml'),$sitemap);
    }

    /**
     * Sitemap页头
     */
    public function header(){
        $this->xml[] = '<?xml version="1.0" encoding="utf-8"?>';

    }

    public function startUrlSet(){
        $this->xml[] = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    }

    public function endUrlSet(){
        $this->xml[] = '</urlset>';
    }

    /**
     * 首页
     */
    public function home(){
        $this->xml[] = '  <url>';
        $this->xml[] = "    <loc>".url('/')."</loc>";
        $this->xml[] = "    <lastmod>{$this->last_mod}</lastmod>";
        $this->xml[] = '    <changefreq>daily</changefreq>';
        $this->xml[] = '    <priority>1.0</priority>';
        $this->xml[] = '  </url>';


    }

    /**
     * 资讯公告
     */
    public function article(){
        $article = ArticleCate::with(['article'=>function($query){
            $query->where('status',1);
        }])->get();

        foreach($article as $item){
            $uri = $item->uri?url($item->uri):url('news');
            $this->xml[] = '  <url>';
            $this->xml[] = "    <loc>".$uri."</loc>";
            $this->xml[] = "    <lastmod>{$this->last_mod}</lastmod>";
            $this->xml[] = "    <changefreq>daily</changefreq>";
            $this->xml[] = '    <priority>0.8</priority>';
            $this->xml[] = "  </url>";

            foreach($item->article as $vv){
                $this->xml[] = '  <url>';
                $this->xml[] = "    <loc>".url($uri.'/'.$vv->id)."</loc>";
                $this->xml[] = "    <lastmod>{$this->last_mod}</lastmod>";
                $this->xml[] = "    <changefreq>daily</changefreq>";
                $this->xml[] = '    <priority>0.8</priority>';
                $this->xml[] = "  </url>";
            }

        }

        $topic = Topic::where('status',1)->get();
        foreach($topic as $item){
            $this->xml[] = '  <url>';
            $this->xml[] = "    <loc>".url('/'.$item->title)."</loc>";
            $this->xml[] = "    <lastmod>{$this->last_mod}</lastmod>";
            $this->xml[] = "    <changefreq>daily</changefreq>";
            $this->xml[] = '    <priority>0.8</priority>';
            $this->xml[] = "  </url>";
        }

    }

    public function cate(){
        $areas = Area::where('parent_id',0)->where('status',1)->get();
        $site_keyword = app('cache.config')->get('site_keyword');
        foreach($areas as $item){
            $this->xml[] = '  <url>';
            $this->xml[] = "    <loc>".url($item->name.$site_keyword)."</loc>";
            $this->xml[] = "    <lastmod>{$this->last_mod}</lastmod>";
            $this->xml[] = "    <changefreq>daily</changefreq>";
            $this->xml[] = '    <priority>0.8</priority>';
            $this->xml[] = "  </url>";
        }
    }

    /**
     * 产品
     */
    public function product(){
        $product = Product::where('status',1)->select(['id'])->get();
        $this->xml[] = '  <url>';
        $this->xml[] = "    <loc>".url('product')."</loc>";
        $this->xml[] = "    <lastmod>{$this->last_mod}</lastmod>";
        $this->xml[] = "    <changefreq>daily</changefreq>";
        $this->xml[] = '    <priority>0.8</priority>';
        $this->xml[] = "  </url>";
        foreach($product as $item){
            $this->xml[] = '  <url>';
            $this->xml[] = "    <loc>".url('product/'.$item->id)."</loc>";
            $this->xml[] = "    <lastmod>{$this->last_mod}</lastmod>";
            $this->xml[] = "    <changefreq>daily</changefreq>";
            $this->xml[] = '    <priority>0.8</priority>';
            $this->xml[] = "  </url>";
        }
    }

    public function page(){
        $this->xml[] = '  <url>';
        $this->xml[] = "    <loc>".url('faq')."</loc>";
        $this->xml[] = "    <lastmod>{$this->last_mod}</lastmod>";
        $this->xml[] = "    <changefreq>daily</changefreq>";
        $this->xml[] = '    <priority>0.8</priority>';
        $this->xml[] = "  </url>";

        $this->xml[] = '  <url>';
        $this->xml[] = "    <loc>".url('about')."</loc>";
        $this->xml[] = "    <lastmod>{$this->last_mod}</lastmod>";
        $this->xml[] = "    <changefreq>daily</changefreq>";
        $this->xml[] = '    <priority>0.8</priority>';
        $this->xml[] = "  </url>";

        $this->xml[] = '  <url>';
        $this->xml[] = "    <loc>".url('contact')."</loc>";
        $this->xml[] = "    <lastmod>{$this->last_mod}</lastmod>";
        $this->xml[] = "    <changefreq>daily</changefreq>";
        $this->xml[] = '    <priority>0.8</priority>';
        $this->xml[] = "  </url>";




    }



}
