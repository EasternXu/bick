<?php
namespace app\admin\controller;

use app\admin\model\Auth_group;
use app\admin\model\Auth_rule;
use app\admin\model\AuthGroupAccess;

class AuthGroup extends common
{
    public function lst()
    {   
        $authgroup = new Auth_group();
        $date = $authgroup::select();
        $this->assign('date',$date);
        return view('list');
    }

    public function add()
    {
        $rule = new Auth_rule();
        $ruledate  = $rule->lst();
        $this->assign('ruledate',$ruledate);
        if (request()->isPost()) {
            $date = input('post.');
            $rules = implode(',',$date['rules']);
            $date['rules'] = $rules;
            $res = Auth_group::create($date);
            if($res)
            {
                return $this->success('用户组添加成功',url('Auth_group/lst'));
            }else{
                return $this->error('用户组添加失败');
            }
        }
        return view();
    }

    public function update()
    {
        $rule = new Auth_rule();
        $ruledate  = $rule->lst();
        $id = input('id');
        $gruopdate = Auth_group::find($id);
        $rules = explode(',',$gruopdate['rules']);
        $this->assign([
            'ruledate'=>$ruledate,
            'groupdate'=>$gruopdate,
            'rules'=>$rules
        ]);

        if (request()->isPost()) {
            $date = input('post.');
            $rulesdate = implode(',',$date['rules']);
            $date['rules'] = $rulesdate;

            $res = Auth_group::update($date,['id'=>$date['id']]);
            if($res)
            {
                return $this->success('用户组更新成功',url('Auth_group/lst'));
            }else{
                return $this->error('用户组更新失败');
            }
        }
        return view();
    }

    public function del()
    {
        $id = input('id');
        $res = Auth_group::destroy($id);
        $wres = AuthGroupAccess::where('group_id',$id)->delete();
        if ($res && $wres)
        {
            return $this->success('用户组删除成功',url('Auth_group/lst'));
        }else{
            return $this->error('用户组删除失败');
        }
    }
}

?>