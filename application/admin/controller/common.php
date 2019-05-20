<?php
namespace app\admin\controller;

use think\Controller;
use app\admin\model\Admin;
use think\Request;

class common extends Controller
{
    public function _initialize()
    {
        if(!session('id') || !session('username')){
            return $this->error('请先登录',url('login/index'));
        }


        $auth = new Auth;
        $uid = session('id');
        $request = Request::instance();
        $con = $request->controller();
        $action = $request->action();
        $name = $con.'/'.$action;
        $nocheck = ['Index/index','Admin/lst','Admin/logout'];
        if (!in_array($name,$nocheck)) {
            if($uid !== 1){
                $res = $auth->check($name,$uid);
                if (!$res) {
                    $this->error('没有权限',url('index/index'));
                }
            }
        }
        
    }
}

?>