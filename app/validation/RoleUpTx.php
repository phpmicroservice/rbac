<?php
/**
 * Created by PhpStorm.
 * User: dongasai
 * Date: 2018/7/20
 * Time: 17:03
 */

namespace app\validation;


use pms\Validation;

class RoleUpTx extends Validation
{
    protected function initialize()
    {
        $this->add_required('user_id', [
            'message' => 'required'
        ]);
        $this->add_required('role_id', [
            'message' => 'required'
        ]);
        $this->add_required('type', [
            'message' => 'required'
        ]);
        $this->add_in('type', [
            'domain' => [
                'delete', 'add'
            ]
        ]);
        return parent::initialize(); // TODO: Change the autogenerated stub
    }

}