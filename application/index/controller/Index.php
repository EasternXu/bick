<?php
namespace app\index\controller;

use app\index\model\Article;

class Index extends Common
{
    public function index()
    {

        $Marticle = new Article();
        $NewArticleDate = $Marticle->indexNewArticle();
        //获取热门文章
        $hotArticle=$Marticle->getHot();

        //获取友情链接
        $linkData = db('link')->order('sort desc')->limit(6)->select();

        //获取推荐文章
        $RecArtData = $Marticle->getRecArt();
        return view('index',[
            'NewArticleDate'=>$NewArticleDate,
            'hotArticle'=>$hotArticle,
            'linkData'=>$linkData,
            'RecArtData'=>$RecArtData,
        ]);
    }
}
