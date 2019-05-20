<?php
namespace app\admin\model;

use think\Model;
use think\Db;
use app\admin\validate\Admin as Vadmin;

class Admin extends Model
{

    //一对一关联
    public  function AuthGroupAccess()
    {
        return $this->hasOne('auth_group_access','uid','id');
    }

    public function lst()
    {
        $res = array();
        $res = $this->order('id','asc')->paginate(5);
        return $res;
    }
    public function add($data)
    {   
        if( !empty($data) || is_array($data) ){
            $data['password'] = md5($data['password']);

            //验证器验证数据
            $Vadmin = new Vadmin();
            if (!$Vadmin->scene('add')->check($data)) {
                return $Vadmin->getError();
            }

            
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

        //验证器验证数据
        $Vadmin = new Vadmin();
        if (!$Vadmin->scene('edit')->check($data)) {
            return $Vadmin->getError();
        }

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