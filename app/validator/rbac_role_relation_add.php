<?php
/**
 * Created by PhpStorm.
 * User: saisai
 * Date: 17-5-12
 * Time: 上午9:59
 */

namespace logic\rbac\validator;


use logic\rbac\model\rbac_user as user_role_relation;

class rbac_role_relation_add extends \core\CoreValidator
{


    /**
     * 执行验证
     * @param \Phalcon\Validation $validator
     * @param string $attribute
     * @return boolean
     */
    public function validate(\Phalcon\Validation $validation, $attribute)
    {
        # 验证是否存在
        $model = new user_role_relation();
        $where = [
            'conditions' => 'uid = :uid: and role_id = :role_id:',
            'bind' => [
                'uid' => $validation->getValue('uid'),
                'role_id' => $validation->getValue('role_id')
            ]
        ];
        $re = $model->findFirst($where);
        if (!empty($re)) {
            $this->type = '';
            return $this->appendMessage($validation, $attribute);
        }
        return true;
    }

}