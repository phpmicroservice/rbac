<?php

namespace app\controller;

use app\Controller;

/**
 *
 * Class Admin
 * @package app\controller
 */
class Admin extends Controller
{
    /**
     * 更新缓存
     */
    public function updateCache()
    {
        $this->send(true);
        $this->swoole_server->shutdown();
    }

}