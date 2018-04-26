<?php
/**
 * Created by PhpStorm.
 * User: Dongasai
 * Date: 2018/4/25
 * Time: 17:50
 */

namespace app;


class NotFound
{
    public function beforeNotFoundHandler(\Phalcon\Events\Event $Event, \pms\Dispatcher $dispatcher)
    {
        $dispatcher->connect->send_error("不存在的控制器!", 404);
    }

    public function beforeNotFoundAction(\Phalcon\Events\Event $Event, \pms\Dispatcher $dispatcher)
    {
        $dispatcher->connect->send_error("不存在的方法!", 404);

    }

}