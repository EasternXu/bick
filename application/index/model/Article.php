<?php

namespace app\index\model;

use think\Model;

class Article extends Model
{
    public function getHot()
    {
        $hotArticle = db('article')->order('click desc')->limit(5)->select();
        return $hotArticle;
    }


    //首页最新文章
    public function indexNewArticle()
    {
        $NewArticleDate = db('article')->field('a.*,c.catename')->alias('a')->join('bk_cate c','a.cateid=c.id')->order('time desc')->limit(3)->select();
        return $NewArticleDate;
    }

    //获取推荐文章
    public function getRecArt()
    {
        $recArt = db('article')->field('id,title,thumb')->where('rec',1)->order('click desc')->limit(4)->select();

        return $recArt;
    }
}