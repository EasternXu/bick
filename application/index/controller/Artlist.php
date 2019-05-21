<?php
namespace app\index\controller;

use app\index\model\Cate;
use app\index\model\Article;

class Artlist extends Common
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
        $articleData = Article::where("cateid IN($allCateIds)")->paginate(2);
        // dump($articleData);die;
        return view('artlist',[
            'articleData'=>$articleData,
            
        ]);
    }
}
