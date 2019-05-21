<?php
namespace app\index\controller;

use think\Controller;
use app\index\model\Cate;

class Common extends Controller
{
    public function _initialize()
    {
        //获取栏目信息
        $this->getCate();
        //获取栏目位置信息
        $this->getPcate();
    }
    public function getCate()
    {
        $catedata = Cate::where('pid',0)->select();
        foreach ($catedata as $k => $v) {
            $cateChildren =  Cate::where('pid',$v['id'])->select();
            if ($cateChildren) {
                $catedata[$k]['children'] = $cateChildren;
            }else{
                $catedata[$k]['children'] = 0;
            }
        }
        // dump($catedata);die;
        $this->assign('cates',$catedata);
        
    }


    public function getPcate()
    {   
        $cateid = input('cateid');
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
         $this->assign('cateName',$catename);
    }
}
