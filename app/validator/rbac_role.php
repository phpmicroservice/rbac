<?php

namespace app\validator;

use logic\rbac\model as thisModel;
use pms\Validation\Validator;

/**
 * 用户角色验证,验证用户是否属于某角色
 * role_name:角色名字
 * Class user_role
 * @package logic\user\validator
 */
class rbac_role extends Validator
{

    /**
     * 执行验证
     * @param \Phalcon\Validation $validation 这个验证器
     * @param string $attribute 要验证的字段名字
     * @return boolean
     */
    public function validate(\Phalcon\Validation $validation, $attribute)
    {
        $user_id = $validation->getValue($attribute);
        $role_name = $this->getOption('role_name');
        $role_info = thisModel\rbac_role::i4name($role_name);
        $inf = thisModel\rbac_user::findFirst([
            'uid= :uid: and role_id=:role_id:',
            'bind' => [
                'uid' => $user_id,
                'role_id' => $role_info->id
            ]]);
        if (!$inf) {
            $this->type = 'rbac_role';
            return $this->appendMessage($validation, $attribute);
        }
        return true;


    }
}