<?php

namespace app\logic;


use app\Base;
use app\model\rbac_rule_auth;
use app\validation\Atuh as validation_Atuh;
use app\model\rbac_resources;

/**
 * 权限管理
 * Class Auth
 * @package app\logic
 */
class Auth extends Base
{
    /**
     * 权限列表
     * @param int $role_id
     * @param string $index
     * @return mixed
     */
    public static function auths(int $role_id, string $index = 'index')
    {
        $list = rbac_rule_auth::find();
        $index_arr = [];
        $list2 = [];
        foreach ($list->toArray() as $v) {
            if (!isset($index_arr[$v['role']])) {
                $index_arr[$v['role']] = [];
                $list2[$v['role']] = [];
            }
            $list2[$v['role']][] = $v;
            $index_arr[$v['role']][] = [
                'resource' => self::ri2ra($v['resources']),
                'type' => $v['type']
            ];
        }
        $auths['index'] = $index_arr;
        $auths['list'] = $list2;
        return $auths[$index][$role_id];
    }

    /**
     * 根据资源索引获取资源
     */
    private static function ri2ra($index)
    {

        $resources = self::resourcesAll();
        if (isset($resources['index'][$index])) {
            return $resources['index'][$index];
        } else {
            return false;
        }
    }

    /**
     * 获取资源列表
     * @param type $pid
     */
    private static function resourcesAll()
    {
        $list = rbac_resources::find();
        $recursion = \funch\Arr::recursion($list->toArray(), 'pid', 'id', 0, 1);
        $resources['list'] = $list;
        $resources['recursion'] = $recursion;
        $ar = [];
        $index_array = [];
        foreach ($recursion as $k => $v1) {
#01
            if (is_array($v1['sub'])) {
                foreach ($v1['sub'] as $v2) {
# 02
                    if (is_array($v2['sub'])) {
                        foreach ($v2['sub'] as $v3) {
#03 只有进入到3级 也就是存在Action的才能算是合格的资源 否自被抛弃
                            $name = $v1['name'] . $v2['name'];
                            $action = $v3['name'];
                            $index_array[$v3['id']] = [
                                'controller' => $name,
                                'action' => $action
                            ];
                            if (!isset($ar[$name])) {
                                $ar[$name] = [];
                            }
                            $ar[$name] [] = $action;
                        }
                    }
                }
            }
        }
        $resources['array'] = $ar;
        $resources['index'] = $index_array;
        return $ar;
    }

    /**
     * 增加权限
     * @param $data
     */
    public static function add_auth($data)
    {
        output($data, 'info');
        $validation = new validation_Atuh();
        $user_resourcesModel = new rbac_rule_auth();
        $validation->setRepetition($user_resourcesModel, $data);
        if (!$validation->validate($data)) {
            return $validation->getMessages();
        }

        $user_resourcesModel->setData($data);
        if ($user_resourcesModel->save() === false) {
            return $user_resourcesModel->getMessages();
        }
        return true;
    }

    /**
     * 编辑权限
     * @param $id
     * @param $data
     */
    public static function edit_auth($id, $data)
    {
        $validation = new \app\validation\Atuh();

        $user_resourcesModel = rbac_rule_auth::findFirstById($id);
        if (!$user_resourcesModel) {
            return "_information that doesn~t exist";
        }
        if (!$validation->validate($data)) {
            return $validation->getMessages();
        }

        $user_resourcesModel->setData($data);
        if ($user_resourcesModel->update() === false) {
            return $user_resourcesModel->getMessages();
        }
        return true;
    }

    /**
     * 获取单个权限信息
     * @param $id
     */
    public static function auth_info($id)
    {

        $model = rbac_rule_auth::findFirstById($id);
        if ($model === false) {
            return "empty-info";
        }
        return $model;
    }

    /**
     * 删除权限
     * @param $id
     */
    public static function del_auth($id)
    {
        $validation = new \app\validation\del_auth();
        $validation->validate(['id' => $id]);
        if ($validation->isError()) {
            return $validation->getMessages();
        }
        $model = rbac_rule_auth::findFirstById($id);
        if ($model->delete() === false) {
            return $model->getMessage();
        }
        return true;
    }

    /**
     * 删除权限信息
     * @param $role 角色
     * @param $resources 资源
     * @return int
     */
    public static function del_auth2($role, $resources)
    {
        $where = [
            ' role = :role: and   resources = :resources: ',
            'bind' => ['role' => $role, 'resources' => $resources]
        ];
        $model = rbac_rule_auth::findFirst($where);
        if (empty($model)) {
            return "empty-info";
        }
        if ($model->delete() === false) {
            return $model->getMessages();
        }
        return true;
    }


}