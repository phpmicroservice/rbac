<?php

namespace logic\rbac\validation;

use core\CoreValidation;

/**
 * 资源删除验证
 * Class del_resources
 * @package logic\user\validation\del_resources
 */
class del_resources extends CoreValidation
{
    protected $lang = 'admin/model/user.php';
    protected $lang_field_prefix = 'model-user_resources-field';
    protected $rules = [
        'id' => [
            #验证存在
            'exist' => [
                'message' => 'exist',
                'class_name_list' => 'logic\\rbac\\model\\rbac_resources'
            ],
            #验证引用
            'correlation' => [
                'message' => 'correlation',
                'model_list' => [
                    'logic\\rbac\\model\\rbac_resources',
                    'logic\\rbac\\model\\rbac_rule_auth'
                ],
                'fields_name' => [
                    'pid',
                    'resources'
                ]
            ]

        ],
    ];

}