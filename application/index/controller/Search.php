<?php
namespace app\index\controller;

use app\admin\model\Article as AMarticle;
use app\index\model\Article as IMarticle;

class Search extends Common
{
    public function index()
    {
        //获取热门文章
        $article = new IMarticle();
        $hotArticle=$article->getHot();

        $keyword = input('keyword');
        $articleData = AMarticle::where('title','like','%'.$keyword.'%')->order('click desc')->paginate(2,false,$congif=['query'=>array('keyword'=>$keyword)]);
        // dump($articleData);die;
        return view('search',[
            'articleData'=>$articleData,
            'hotArticle'=>$hotArticle
        ]);
    }
}
