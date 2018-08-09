<?php

namespace app\validation;

/**
 * Description of Rule
 * 角色的验证器
 * @author Dongasai
 */
class Role extends \pms\Validation
{



    //定义验证规则
    protected $rules = [
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
