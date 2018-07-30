<?php

namespace app\task;

use app\filterTool\Regs;
use app\logic\Company;
use app\logic\Reg;
use app\logic\User;
use pms\Task\TaskInterface;

/**
 * 多服务协同注册的全局事务
 * Class RegsTx
 * @package app\task
 */
class RegsTx extends \pms\Task\TxTask implements TaskInterface
{
    public function end()
    {

    }

    /**
     * 在依赖处理之前执行,没有返回值
     */
    protected function b_dependenc()
    {
        $data = $this->getData();

    }

    /**
     * 事务逻辑内容,返回逻辑执行结果,
     * @return bool false失败,将不会再继续进行;true成功,事务继续进行
     */
    protected function logic()
    {
        $data = $this->getData();
        # 要进行角色申请
        $logic=new User();
        $re=$logic->add_user($data['user_id'],$data['role_id']);
        if (is_string($re)) {
            return $re;
        }
        return true;
    }
}