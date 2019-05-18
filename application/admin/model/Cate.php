<?php
namespace app\admin\model;

use think\Model;
use think\Db;

class Cate extends Model
{
    public function lst()
    {
        $data = $this->order('sort desc')->select();
        return $this->cort($data);
    }

    public function cort($data,$pid=0,$level=0)
    {
        static $arr = array();
        foreach($data as $k=>$v){
            if($v['pid']==$pid)
            {   
                $v['level'] = $level;
                $arr[]=$v;
                $this->cort($data,$v['id'],$level+1);
            }
        }
        return $arr;
    }


    public function del($id)
    {
        $data = $this->select();

        return $cates = $this->delchildren($data,$id);

        
    }


    public function delchildren($data,$id)
    {
        static $arr =array();
        foreach ($data as $k => $v) {
            if($v['pid'] == $id){
                $arr[] = $v['id'];
                $this->delchildren($data,$v['id']);
            }
        }

        return $arr;
    }

    
}