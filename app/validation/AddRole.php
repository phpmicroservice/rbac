<?php

namespace app\validation;

use app\model\rbac_role;
use app\validator\rbac_role_relation_add;
use pms\Validation;

/**
 * 角色增加的验证器
 * Class AddRole
 * @package logic\rbac\validation
 */
class AddRole extends Validation
{
    protected function initialize()
    {
        # 判断是 角色 否存在
        $this->add_exist('role_id', [
            'message' => 'exist',
            'class_name_list' => rbac_role::class,
        ]);


        # 判断关联
        $this->add_Validator('role_id', [
            'name' => rbac_role_relation_add::class,
            'message' => 'user_role_relation_add'
        ]);
        return parent::initialize(); // TODO: Change the autogenerated stub
    }

    /**
     * 重新验证
     * @param $data
     */
    public function beforeValidation1($data)
    {
        # 判断用户是否存在
        $this->add_Validator('uid', [
            'name' => Validation\Validator\ServerAction::class,
            'message' => 'userexit',
            'server_action' => "user@/server/user_exist",
            'data' => [
                'user_id'=>$data['uid']
            ]
        ]);
    }

}