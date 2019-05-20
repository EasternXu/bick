<?php
namespace app\admin\controller;

use app\admin\model\Auth_rule;

class AuthRule extends common
{
    protected $beforeActionList=[
        'delchildren' => ['only'=>'del'],
    ];
    public function lst()
    {   
        $MaultRule = new Auth_rule();
        $ruleDate = $MaultRule->lst();
        
        $this->assign('ruleDate',$ruleDate);   

        if (request()->isPost()) {
            $date = input('post.');
            foreach ($date as $k => $v) {
                $res = Auth_rule::update(['id'=>$k,'sort'=>$v]);
            }
            if($res)
            {
                return $this->success('排序成功',url('AuthRule/lst'));
            }else{
                return $this->error('排序失败');
            }
        }
        return view('list');
    }

    public function add()
    {
        $MaultRule = new Auth_rule();
        $pruleDate = $MaultRule->lst();
        $this->assign([
            'pruleDate'=>$pruleDate,
        ]); 

        if (request()->isPost()) {
            $date = input('post.');
            $plevel = Auth_rule::find($date['pid']);
            if($date['pid'] != 0){
                $date['level'] = $plevel['level']+1;
            }else {
                $date['level'] =0;
            }
            
            $res = Auth_rule::create($date);
            if($res)
            {
                return $this->success('权限添加成功',url('AuthRule/lst'));
            }else{
                return $this->error('权限添加失败');
            }
        }


        return view();
    }

    public function update()
    {
        $id = input('id');
        $MaultRule = new Auth_rule();
        $pruledate = $MaultRule->lst();

        $ruledate = Auth_rule::find($id);
        $this->assign([
            'pruledate'=>$pruledate,
            'ruledate'=>$ruledate
        ]); 

        if (request()->isPost()) {
            $date = input('post.');

            $res = Auth_rule::update($date,['id'=>$date['id']]);
            if($res)
            {
                return $this->success('权限修改成功',url('AuthRule/lst'));
            }else{
                return $this->error('权限修改失败');
            }
        }
        return view();
    }

    public function del()
    {
        $id = input('id');
        $res = Auth_rule::destroy($id);
        // $wres = $this->delchildren();
        if($res)
        {
            return $this->success('权限删除成功',url('AuthRule/lst'));
        }else{
            return $this->error('权限删除失败');
        }

    }
    public function delchildren()
    {
        $id = input('id');
        $Auth_group = new Auth_rule();
        $arr = $Auth_group->getchildren($id);
        // dump($arr);die;
        if (!empty($arr)){
            $res = Auth_rule::destroy($arr);
        }
        
        
    }
}

?>