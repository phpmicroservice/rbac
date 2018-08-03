<?php

namespace app\controller;

use app\Controller;
use app\logic\Role;

/**
 * 角色管理的用户管理
 * Class User
 * @package app\controller
 */
class My extends Controller
{



    /**
     * 用户角色列表
     *
     */
    public function role_list()
    {
        $user_id = $this->user_id;
        $service = new \app\logic\User();
        $re = $service->user_roles_index($user_id);
        return $this->send($re);

    }

}