<?php
/**
 * Created by PhpStorm.
 * User: Dongasai
 * Date: 2018/4/25
 * Time: 16:38
 */

namespace app\logic;


use app\Base;

class User extends Base
{


    /**
     * 读取当前用户的权限列表
     * @return array
     */
    public static function role(int $user_id)
    {
        # 没能读取用户的 角色信息
        # 读取一下
        $roles = \app\logic\Role::user($user_id);
        # 增加一个游客权限
        $roles['visitor'] = 0;
        return $roles;
    }

}