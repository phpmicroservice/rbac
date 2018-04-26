<?php

namespace app\model;

/**
 * Description of user_role
 *
 * @author Dongasai
 */
class rbac_role extends \pms\Mvc\Model
{
    //put your code here
    public $can_delete = 0;

    /**
     * 获取角色信息 使用角色标示
     * @param $name
     */
    public static function i4name($name): rbac_role
    {
        return self::findFirstByidentification($name);

    }
}
