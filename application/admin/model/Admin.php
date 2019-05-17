<?php
namespace app\admin\model;

use think\Model;
use think\Db;

class Admin extends Model
{
    public function lst()
    {
        $res = $this->order('id','asc')->paginate(5);
        return $res;
    }
    public function add($data)
    {   
        if( !empty($data) || is_array($data) ){
            $data['password'] = md5($data['password']);
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


    public function del($id)
    {
        if($this->destroy($id)){
            return 1;
        }else{
            return 0;
        }
    }

    public function login()
    {
        $data = input('post.');
        // dump($data);
        if(!$data['name']){
            return -1;
        }else{
            $res = Admin::getByName($data['name']);
            //   dump($res);die;
            if($res['password'] == md5($data['password'])){
                session('id',$res['id']);
                session('username',$res['name']);
                return 1;
            }else{
                return 0;
            }
        }
    }
}

?>