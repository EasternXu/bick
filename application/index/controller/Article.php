<?php
namespace app\index\controller;

use app\admin\model\Article as AMarticle;
use app\index\model\Article as IMarticle;

class Article extends Common
{
    public function index()
    {
        //获取热门文章
        $article = new IMarticle();
        $hotArticle=$article->getHot();

        $articleId = input('articleid');
        $articleData = AMarticle::find($articleId);
        return view('article',[
            'articleData'=>$articleData,
            'hotArticle'=>$hotArticle
        ]);
    }

    public function zan()
    {
        $articleid = input('articleid');
        $articleData = IMarticle::find($articleid);
        $articleData->zan = $articleData['zan']+1;
        $res = $articleData->save();
    }
}
