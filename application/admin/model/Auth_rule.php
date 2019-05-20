<?php
namespace app\admin\model;
use think\Model;
use think\Db;

class Auth_rule extends Model
{
    public function lst()
    {
        $date = Auth_rule::order('sort asc')->select();
        $res = $this->datetree($date);
        return $res;
    }

    public function datetree($date,$pid=0)
    {
        static $arr = array();
        foreach ($date as $k => $v) {
            if ($v['pid']==$pid) {
                $arr[]=$v;
                $this->datetree($date,$v['id']);
            }
        }
        return $arr;
    }

    public function getchildren($id)
    {
        $date = Auth_rule::select();
        return $this->_getchildren($date,$id);
    }

    public function _getchildren($date,$pid)
    {
        static $arr = array();
        foreach ($date as $k => $v) {
            if ($v['pid'] == $pid) {
                $arr[]= $v['id'];
                $this->_getchildren($date,$v['id']);
            }
        }
        return $arr;

    }
}

?>