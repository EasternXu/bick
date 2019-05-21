<?php
namespace app\admin\controller;
use app\admin\model\Cate as Mcate;
use app\admin\model\Article as Marticle;

class Article extends common
{
    protected $beforeActionList=[
        
    ];

    public function lst()
    {
        $date = db('article')->field('a.*,b.catename')->alias('a')->join('bk_cate b','a.cateid=b.id')->paginate(5);
        $this->assign('date',$date);
        return view('list');
    }
 
    public function add()
    {
        $Mcate = new Mcate();
        $date = $Mcate->lst();
        $this->assign('date',$date);

        if(request()->isPost()){
            $articledate = input('post.');
            $articledate['time'] = time();

            // dump($articledate);die;
            $Article = new Marticle();

            $res = $Article->save($articledate);

            if($res)
            {
                return $this->success('文章添加成功',url('article/lst'));
            }else{
                return $this->error('文章添加失败');
            }
        }


        return view();
    }

    public function update()
    { 
        //栏目信息
        $Mcate = new Mcate();
        $catedate = $Mcate->lst();
        $this->assign('catedate',$catedate);
        //文章信息
        $id = input('id');
        $articledate = db('article')->find($id);
        $this->assign('articledate',$articledate);

        if(request()->isPost()){
            $date = input('post.');
            $Marticle = new Marticle;
            $res =  $Marticle->update($date,['id'=>$date['id']]);
            if($res)
            {
                return $this->success('文章修改成功',url('article/lst'));
            }else{
                return $this->error('文章修改失败');
            }

        }
        return view();
    }

    public function del()
    {
        $id = input('id');

        $res = Marticle::destroy($id);
        if($res)
        {
            return $this->success('文章删除成功',url('article/lst'));
        }else{
            return $this->error('文章删除失败');
        }

    }
}

?>