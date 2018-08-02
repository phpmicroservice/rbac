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
     *
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
     * 增加时间
     */
    public function add_role()
    {
        $user_id = $this->getData('user_id');
        $role_id = $this->getData('role_id');
        $re = \app\logic\User::add_user($user_id, $role_id);
        $this->send($re);

    }

}