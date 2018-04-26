<?php

namespace app\validation;

use pms\Validation;


/**
 *  Resources 资源 的验证器
 * @package logic\user\validation
 * @author Dongasai <1514582970@qq.com>
 */
class Resources extends Validation
{

    protected $filter_rule = [
        ['id', 'int'],
        ['pid', 'int'],
        ['name', 'string'],
        ['title', 'string'],
        ['describe', 'string'],
    ];

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
                'class_name_list' => 'app\model\rbac_resources',

            ]
        ]

    ];
}