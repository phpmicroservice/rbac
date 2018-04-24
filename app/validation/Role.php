<?php

namespace logic\rbac\validation;

/**
 * Description of Rule
 * 角色的验证器
 * @author Dongasai
 */
class Role extends \core\CoreValidation
{
    protected $lang = 'admin/model/user.php';
    protected $lang_field_prefix = 'model-user_role-field';

    //定义验证规则
    protected $rules = [
        'id' => [
            'exist' => [
                "message" => "identification",
                "allowEmpty" => true,
                'class_name_list' => 'logic\\rbac\\model\\rbac_role',
            ]
        ],
        'identification' => [
            'required' => [
                "message" => "identification",
            ],
            'stringLength' => [
                "message" => "stringLength",
                'min' => 3,
                'max' => 10
            ],
            'repetition' => [
                'message' => 'repetition',
                'class_name' => 'logic\rbac\model\rbac_role',
                'function_name' => 'findFirstByIdentification',

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
