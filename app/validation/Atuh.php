<?php

namespace app\validation;

use pms\Validation;

/**
 * Class Atuh 权限验证
 * @package logic\user\validation
 */
class Atuh extends Validation
{


    protected $filter_rule = [
        ['title', 'string'],
        ['role', 'int'],
        ['resources', 'int'],
        ['description', 'string'],
        ['type', 'int'],
        ['status', 'string']
    ]; # 数据过滤规则

    //定义验证规则
    protected $rules = [

        'role' => [
            'required' => [
                "message" => "required",
            ],
            'exist' => [
                "message" => "exist",
                'class_name_list' => 'app\model\rbac_role',
            ]
        ],

        'resources' => [
            'required' => [
                "message" => "required",
            ],
            'exist' => [
                "message" => "exist",
                'class_name_list' => 'app\model\rbac_resources',
            ]
        ],
        'title' => [
            'required' => [
                "message" => "required",
            ],
            'stringLength' => [
                "message" => "stringLength",
                "max" => 100,
                "min" => 5,
            ],
        ],

        'description' => [
            'required' => [
                "message" => "required",

            ],
            'stringLength' => [
                "message" => "stringLength",
                "max" => 200,
                "min" => 2,
            ]
        ],
        'type' => [
            'required' => [
                "message" => "required",
            ],
            'in' => [
                "message" => "digit",
                'domain' => [1, 0]
            ]
        ],
        'status' => [
            'required' => [
                "message" => "required",
                "allowEmpty" => true,
            ],
            'in' => [
                "message" => "digit",
                "domain" => [1, 0],
            ]
        ],
        'condition' => [
            'required' => [
                "message" => "required",
                "allowEmpty" => true,
            ],
            'stringLength' => [
                "message" => "stringLength",
                "max" => 200,
                "min" => 0,
            ],

        ],
    ];

    /**
     * 设置重复验证
     * @param type $obj 用于验证的对象
     */
    public function setRepetition(\app\model\rbac_rule_auth $obj, $data)
    {
        $parameter = [
            "message" => "repetition",
            'class_name' => $obj,
            'function_name' => 'check_uniqueness',
            'where' => $data
        ];
        $this->add_repetition('role', $parameter);
    }
}