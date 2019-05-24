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

    public function get_ip()
    {
        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
            $cip = $_SERVER['HTTP_CLIENT_IP'];
        }else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        }else if(!empty($_SERVER["REMOTE_ADDR"])){
            $cip = $_SERVER["REMOTE_ADDR"];
        }else{
            $cip = '';
        }
        preg_match("/[\d\.]{7,15}/", $cip, $cips);
        $cip = isset($cips[0]) ? $cips[0] : 'unknown';
        unset($cips);
        return $cip;
    }
}
