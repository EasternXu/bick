<?php
namespace app\index\controller;

use app\admin\model\Article as Marticle;

class Article extends Common
{
    public function index()
    {
        $articleId = input('articleid');
        $articleData = Marticle::find($articleId);
        return view('article',[
            'articleData'=>$articleData,
        ]);
    }
}
