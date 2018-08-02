<?php

namespace app\controller;
/**
 * 配置处理
 */
class Index extends \app\Controller
{



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