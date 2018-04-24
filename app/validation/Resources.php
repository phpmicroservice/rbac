<?php

namespace logic\rbac\validation;

use core\CoreValidation;

/**
 *  Resources 资源 的验证器
 * @package logic\user\validation
 * @author Dongasai <1514582970@qq.com>
 */
class Resources extends CoreValidation
{
    protected $lang = 'admin/model/user.php';
    protected $lang_field_prefix = 'model-user_resources-field';

    //定义验证规则
    protected $rules = [
        'describe' => [
            'required' => [
                "message" => "required",

            ],
            'stringlength' => [
                "message" => "stringlength",
                "max" => 300,
                "min" => 2,
            ],
        ],
        'title' => [
            'required' => [
                "message" => "required",

            ],
            'stringlength' => [
                "message" => "stringlength",
                "max" => 100,
                "min" => 2,
            ],
        ],

        'name' => [
            'required' => [
                "message" => "required",

            ],
            'stringlength' => [
                "message" => "stringlength",
                "max" => 100,
                "min" => 2,
            ]

        ],

        'id' => [
            'required' => [
                "message" => "required",
                "allowEmpty" => true,
            ],
            'digit' => [
                "message" => "digit",
                "allowEmpty" => true,
            ]
        ],
        'pid' => [
            'required' => [
                "message" => "required"
            ],
            'digit' => [
                "message" => "digit",
            ],
            'exist' => [
                "message" => "exist",
                'class_name_list' => 'logic\rbac\model\rbac_resources',

            ]
        ]

    ];
}