<?php

namespace app;

use app\logic\Alc as alcLogic;

/**
 * Class Alc
 * @package app
 */
class Alc extends Base
{
    public $user_id;

    /**
     *
     * beforeDispatch 在调度之前
     * @param \Phalcon\Events\Event $Event
     * @param \Phalcon\Mvc\Dispatcher $Dispatcher
     * @return
     */
    public function beforeDispatch(\Phalcon\Events\Event $Event, \pms\Dispatcher $dispatcher)
    {
        if ($dispatcher->getTaskName() == 'server') {
            return true;
        }
        output("进行权限鉴定!", 'alc');
        $this->user_id = (int)$dispatcher->session->get('user_id', 0);
        $alc = new alcLogic($this->user_id);
        $re = $alc->isAllowed(SERVICE_NAME . $dispatcher->getTaskName(), $dispatcher->getActionName());
        if (!$re) {
            $dispatcher->connect->send_error("没有权限!", [$this->user_id, $alc->getRoleNames()], 401);
        }
        return $re;
    }


}