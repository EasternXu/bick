<?php

namespace app\index\model;

use think\Model;

class Cate extends Model
{
    public  function getAllCateid($cateid)
    {
        $cateData = Cate::all();
        $allCateId = $this->_getAllChildrenId($cateData,$cateid);
        return $allCateId;
    }

    public function _getAllChildrenId($cateData,$pid)
    {
        static $arr=array();
        foreach ($cateData as $k => $v) {
            if ($v['pid'] == $pid) {
                $arr[] = $v['id'];
                $this->_getAllChildrenId($cateData,$v['id']);
            }

        }
        return $arr;
    }
}