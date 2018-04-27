<?php
/**
 * Created by PhpStorm.
 * User: Dongasai
 * Date: 2018/4/26
 * Time: 9:23
 */

namespace app\controller;

use app\Controller;
use app\logic\Alc2;
use app\model\rbac_resources;

class Resources extends Controller
{

    /**
     * 资源列表
     */
    public function resources_list()
    {
        $list = rbac_resources::find();
        $this->send($list);

    }

    /**
     * 获取单个资源信息
     */
    public function resources_info()
    {
        $id = $this->getData('id');
        $re = Alc2::resources_info($id);
        $this->send($re);
    }

    /**
     * 修改资源
     */
    public function edit_resources()
    {

        $data = $this->getData();
        $re = Alc2::edit_resources($data);
        return $this->send($re);
    }

    /**
     * 增加资源
     */
    public function add_resources()
    {
        $data = $this->getData();
        $re = Alc2::add_resources($data);
        $this->send($re);
    }

    /**
     * 资源删除
     */
    public function del_resources()
    {
        $id = $this->getData('id');
        $re = Alc2::del_resources($id);
        $this->send($re);
    }


}