<?php
namespace app\index\controller;

use app\index\model\Cate;
use app\index\model\Article;

class Imglist extends Common
{
    public function index()
    {
        $cateid = input('cateid');
        //获取栏目id
        $cate  = new Cate();
        $allCateId = $cate->getAllCateid($cateid);
        
       
        
        // dump($catename);die;
        //根据栏目id获取文章信息
        $allCateId[]=$cateid;
        $allCateIds = implode(',',$allCateId);
        // dump($allCateId);die;
        $imgArticleData = Article::where("cateid IN($allCateIds)")->paginate(3);
        // dump($articleData);die;
        return view('imglist',[
            'imgArticleData'=>$imgArticleData,
        ]);
    }
}
