<?php

namespace app\validator;

use app\model\rbac_role as user_role;
use pms\Validation\Validator;

/**
 * 角色删除验证/判断是否可以删除
 * Class user_role_del
 * @package logic\user\validator
 */
class rbac_role_del extends Validator
{
    /**
     * 执行验证
     * @param \Phalcon\Validation $validator
     * @param string $attribute
     * @return boolean
     */
    public function validate(\Phalcon\Validation $validation, $attribute)
    {
        $id = $validation->getValue('id');
        $model = user_role::findFirst([
            'conditions' => 'id = ' . $id
        ]);

        if ($model === false) {
            $this->type = 'empty';
            return $this->appendMessage($validation, $attribute);
        }
        if (!$model->can_delete) {
            $this->type = 'can_delete';
            return $this->appendMessage($validation, $attribute);
        }
        return true;
    }
}