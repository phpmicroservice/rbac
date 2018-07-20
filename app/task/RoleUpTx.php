<?php

namespace app\task;

use app\logic\User;
use pms\Task\TaskInterface;

/**
 * 角色更新
 * Class RoleUpTx
 * @package app\task
 */
class RoleUpTx extends \pms\Task\TxTask implements TaskInterface
{
    public function end()
    {

    }

    /**
     * 在依赖处理之前执行,没有返回值
     */
    protected function b_dependenc()
    {
    }

    /**
     * 事务逻辑内容,返回逻辑执行结果,
     * @return bool false失败,将不会再继续进行;true成功,事务继续进行
     */
    protected function logic()
    {
        $data = $this->getData();
        $va = new \app\validation\RoleUpTx();
        if (!$va->validate($data)) {
            return $va->getErrorMessages();
        }
        $user_id = $data['user_id'];
        $role_id = $data['role_id'];
        $type = $data['type'];
        $ser = new User();
        if ($type == 'add') {
            # 增加角色
            $re = $ser->add_user($user_id, $role_id);
        } else {
            # 删除角色
            $re = $ser->user_del_role($role_id, $user_id);
        }
        output($re);
        return $re;
    }
}