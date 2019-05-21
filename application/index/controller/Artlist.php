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
        
        //获取但前栏目名称
        $catenamme = array();
        $cateName = Cate::find($cateid);
        $catename['catename'] = $cateName['catename'];
        //获取父级栏目名称
        if ($cateName['pid']!=0) {
            $catePName = Cate::select($cateName['pid']);
            foreach ($catePName as $k => $v) {
                $catename['Pname'] = $v['catename'];
            }
            
        }else {
            $catename['Pname'] = '';
        }
        
        // dump($catename);die;
        //根据栏目id获取文章信息
        $allCateId[]=$cateid;
        $allCateIds = implode(',',$allCateId);
        $articleData = Article::where("cateid IN($allCateIds)")->paginate(2);
        // dump($articleData);die;
        return view('artlist',[
            'articleData'=>$articleData,
            'cateName'=>$catename,
        ]);
    }
}
