<?php

namespace app\validation;

/**
 * Description of Rule
 * 角色的验证器
 * @author Dongasai
 */
class Role extends \pms\Validation
{

    # 数据过滤规则
    protected $filter_rule = [
        ['identification', 'string'],
        ['name', 'string'],
        ['sort', 'int'],
        ['status', 'int'],
        ['pid', 'int'],
        ['can_delete', 'int']
    ];

    //定义验证规则
    protected $rules = [
        'id' => [
            'exist' => [
                "message" => "identification",
                "allowEmpty" => true,
                'class_name_list' => 'app\model\rbac_role',
            ]
        ],
        'identification' => [
            'required' => [
                "message" => "identification_required",
            ],
            'stringLength' => [
                "message" => "stringLength",
                'min' => 3,
                'max' => 10
            ]
        ],
        'name' => [
            'required' => [
                "message" => "required",
            ],
            'stringLength' => [
                "message" => "stringLength",
                'min' => 2,
                'max' => 20
            ],

        ],
        'sort' => [
            'required' => [
                "message" => "required"
            ]
        ],
        "can_delete" => [
            'required' => [
                "message" => "required"
            ],
        ]
    ];

}
