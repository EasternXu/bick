<?php
namespace app\admin\controller;
use app\admin\model\Cate as Mcate;
use app\admin\model\Article as Marticle;

class Article extends common
{
    public function lst()
    {
        $date = db('article')->paginate(5);
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
        return view();
    }
}

?>