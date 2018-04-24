<?php
/**
 * Created by PhpStorm.
 * User: Dongasai
 * Date: 2017/5/9
 * Time: 13:59
 */

namespace logic\rbac\validation;

/**
 *  删除权限的验证
 * Class del_auth
 * @package logic\user\validation\del_auth
 */
class del_auth extends \core\CoreValidation
{
    protected $lang = 'admin/model/user.php';
    protected $lang_field_prefix = 'model-user_rule_auth-field';
    protected $rules = [
        'id' => [
            #验证存在
            'exist' => [
                'message' => 'exist',
                'class_name_list' => 'logic\\user\\model\\user_rule_auth'
            ]
            # 没有引用
        ],
    ];
}