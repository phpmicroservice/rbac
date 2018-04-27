<?php
/**
 * Created by PhpStorm.
 * User: Dongasai
 * Date: 2017/5/9
 * Time: 13:59
 */

namespace app\validation;

/**
 *  删除权限的验证
 * Class del_auth
 * @package logic\user\validation\del_auth
 */
class del_auth extends \pms\Validation
{

    protected $rules = [
        'id' => [
            #验证存在
            'exist' => [
                'message' => 'exist',
                'class_name_list' => 'app\\model\\rbac_rule_auth'
            ]
            # 没有引用
        ],
    ];
}