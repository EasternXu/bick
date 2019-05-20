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
}
