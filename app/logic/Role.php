<?php

namespace app\logic;

use app\model\rbac_role;
use app\validation\del_role;
use app\validation\Role as validation_Role;

/**
 * Description of Role
 * @author Dongasai
 */
class Role extends \app\Base
{

    /**
     * 获取角色列表
     */
    public static function roles()
    {
        return \app\model\rbac_role::find();
    }

    /**
     * 删除角色
     * @param $id
     */
    public function del_role($id)
    {

        $validation = new del_role();

        $validation->validate(['id' => $id]);
        if ($validation->isError()) {
            return $validation->getMessages();
        }
//        $model = rbac_role::findFirstById($id);
        $model = rbac_role::findFirstById($id);
        if ($model === false) {
            return '_empty-info';
        }
        if ($model->delete() === false) {
            return $model->getMessages();
        }
        return true;

    }

    /**
     * 编辑角色
     * @param $data
     * @return bool|string
     */
    public function edit_role($data)
    {
        $validation = new validation_Role();
        $validation->validate($data);
        if ($validation->isError()) {
            return $validation->getMessages();
        }
        $model = rbac_role::findFirstById($data['id']);
        if ($model === false) {
            return '_empty-info';
        }
        $data['update_time'] = time();
        $model->setData($data);

        if ($model->save() === false) {
            return $model->getMessages();
        }
        return true;
    }

    /**
     * 获取单个详情
     * @param $id
     */
    public function role_info($id)
    {
        $model = rbac_role::findFirstById($id);
        if (empty($model)) {
            return '_empty-info';
        }
        return $model;

    }

    /**
     * 角色列表
     */
    public function role_list()
    {
        $list = rbac_role::find();
        return $list;
    }

    /**
     * 增加角色
     * @param $data
     */
    public function add_role($data)
    {
        output($data, 'info');
        $validation = new  validation_Role();
        $validation->add_repetition('identification', [
            'class_name' => rbac_role::class,
            'function_name' => 'findFirstByidentification',
            'where' => $data['findFirstByidentification'],
            'message' => 'repetition'
        ]);
        if (!$validation->validate($data)) {
            return $validation->getMessages();
        }
        $model = new rbac_role();
        $data['create_time'] = time();
        $data['update_time'] = 0;
        $model->setData($data);
        if ($model->save() === false) {
            return $model->getMessages();
        }
        return true;

    }

}
