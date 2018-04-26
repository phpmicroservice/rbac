<?php

namespace app\validation;

/**
 * Description of Rule
 * 规则 的验证器
 * @author Dongasai
 */
class Rule extends \pms\Validation
{

    //定义验证规则
    protected $rule = [
        'identification' => [
            'required' => [
                "message" => "The identification is required",
            ],
            'stringLength' => [
                "message" => "The username is stringLength",
                'min' => 3,
                'max' => 10
            ],
            'uq' => [
                'message' => 'usernmae 重复',
                'model' => 'logic\user\model\user_role'
            ]
        ],
        'password' => [
            'required' => [
                "message" => "The password is required",
            ],
            'stringLength' => [
                "message" => "The password is stringLength",
                'min' => 6,
                'max' => 20
            ],
            'confirmation' => [
                'message' => 'The password is confirmation',
                'with' => 'password2'
            ]
        ],
        'email' => [
            'required' => [
                "message" => "The email is required"
            ],
            'notempty' => [
                "message" => "The email is notempty"
            ],
            'email' => [
                "message" => "The email is email"
            ],
        ]
    ];

}
