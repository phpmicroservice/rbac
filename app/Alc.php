<?php

namespace app;

use pms\Dispatcher;

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
        if (in_array($dispatcher->getTaskName(), ['index', 'demo'])) {
            # 公共权限
            return true;
        }

        if (in_array($dispatcher->getTaskName(), ['server', 'transaction'])) {
            # 服务间鉴权
            $this->server_auth($dispatcher);
            return true;
        }

        $this->user_id = (int)$dispatcher->session->get('user_id', 0);
        $alc = new \app\logic\Alc($this->user_id);
        $re = $alc->isAllowed(SERVICE_NAME . $dispatcher->getTaskName(), $dispatcher->getActionName());
        if (!$re) {
            $dispatcher->connect->send_error("没有权限!", [$this->user_id, $alc->getRoleNames()], 401);
        }
        return $re;
    }


    /**
     * 服务间的鉴权
     * @return bool
     */
    private function server_auth(Dispatcher $dispatcher)
    {
        $key = $dispatcher->connect->accessKey??'';
        \pms\output([APP_SECRET_KEY, $dispatcher->connect->getData(), $dispatcher->connect->f], '!\pms\verify_access');
        if (!\pms\verify_access($key, APP_SECRET_KEY, $dispatcher->connect->getData(), $dispatcher->connect->f)) {
            $dispatcher->connect->send_error('accessKey-error', [], 412);
            return false;
        }
        return true;
    }

}