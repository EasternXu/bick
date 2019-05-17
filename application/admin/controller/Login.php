<?php
namespace app\admin\controller;

use app\admin\model\Admin;
use think\Controller;

class Login extends Controller
{
    public function index()
    {
        if(request()->ispost()){
            $login = new Admin();
            $res = $login->login();

            if($res){
                return $this->success('登录成功',url('admin/index/index'));

            }else{
                    return $this->error('账号密码错误',url('login/index'));
            }
        }
        return view('login');
    }
}

?>