<?php

namespace app\controller;

use app\Controller;

/**
 * 服务相关
 *
 *
 */
class Server extends Controller
{
    /**
     * 判断是否具有角色
     */
    public function in_role()
    {
        $user_id = $this->getData('user_id');
        $role_id = $this->getData('role_id');
        $ser = new \app\logic\User();
        $re = $ser->role_user_is($user_id, '', $role_id);
        $this->send($re);

    }

    /**
     * 增加角色
     */
    public function add_role()
    {
        $user_id = $this->getData('user_id');
        $role_id = $this->getData('role_id');
        $re = \app\logic\User::add_user($user_id, $role_id);
        $this->send($re);

    }

    /**
     * 权限鉴定
     */
    public function alc()
    {
        $servername = $this->connect->f;
        $cname = $this->getData('c');
        $aname = $this->getData('a');
        $user_id = $this->getData('u');
        $alc = new \app\logic\Alc($user_id);
        $re = $alc->isAllowed($servername . $cname, $aname);
        $this->send($re);
    }

}