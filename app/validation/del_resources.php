<?php

namespace app\validation;


/**
 * 资源删除验证
 * Class del_resources
 * @package logic\user\validation\del_resources
 */
class del_resources extends \pms\Validation
{
    protected $rules = [
        'id' => [
            #验证存在
            'exist' => [
                'message' => 'exist',
                'class_name_list' => 'app\\model\\rbac_resources'
            ],
            #验证引用
            'correlation' => [
                'message' => 'correlation',
                'model_list' => [
                    'app\\model\\rbac_resources',
                    'app\\model\\rbac_rule_auth'
                ],
                'fields_name' => [
                    'pid',
                    'resources'
                ]
            ]

        ],
    ];

}