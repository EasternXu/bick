<?php
namespace app\admin\model;

use think\Model;
use think\Db;

class Admin extends Model
{
    public function lst()
    {
        $res = $this->paginate(5);
        return $res;
    }
    public function add($data)
    {   
        if( !empty($data) || is_array($data) ){
            $res=$this->save($data);
            if ($res) {
                return 1;
            }else{
                return 0;
            }
        }else{
            return 0;
        }
        
    }
    public function edit()
    {
        $data = input('post.');
        
        if(!$data['password']){
            $info = db('admin')->find($data['id']);
            $data['password'] = $info['password'];
        }else{
            $data['password'] =md5($data['password']);
        }

        if( !empty($data) || is_array($data) ){
            $res=$this->save($data,['id'=>$data['id']]);
            if ($res) {
                return 1;
            }else{
                return 0;
            }
        }else{
            return 0;
        }
    }
}

?>