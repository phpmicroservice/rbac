<?php


namespace app\logic;

use app\model\rbac_resources;
use app\model\rbac_rule_auth;
use app\validation\Resources;
use app\validation\Atuh as validation_Atuh;


/**
 * Alc 权限控制相关
 *
 * @author Dongasai <1514582970@qq.com>
 */
class Alc2 extends \pms\Base
{

    static private $resources; #资源储存变量
    static private $auths;

    /**
     * 获取单个权限信息
     * @param $id
     */
    public static function auth_info($id)
    {

        $model = rbac_rule_auth::findFirstById($id);
        if ($model === false) {
            return "_empty-info";
        }
        return $model;
    }

    public static function getServerList()
    {

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
            return $model->getMessages();
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
            return "_empty-info";
        }
        if ($model->delete() === false) {
            return $model->getMessages();
        }
        return true;
    }

    /**
     * 删除资源
     * @param $id
     * @return bool|string
     */
    public static function del_resources($id)
    {
        $validation = new \app\validation\del_resources();
        $validation->validate(['id' => $id]);
        if ($validation->isError()) {
            return $validation->getMessages();
        }
        $model = rbac_resources::findFirstById($id);
        if ($model->delete() === false) {
            return $model->getMessages();
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
        $validation->validate($data);
        if ($validation->getMessages()) {
            return $validation->getMessages();
        }

        $user_resourcesModel->setData($data);
        if ($user_resourcesModel->update() === false) {
            return $user_resourcesModel->getMessages();
        }
        return true;
    }

    /**
     * 增加权限
     * @param $data
     */
    public static function add_auth($data)
    {
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
     * 增加资源
     * @param $data
     */
    public static function add_resources($data)
    {
        $data['lv'] = self::resources_lv($data['pid']);
        $validation = new Resources();
        if (!$validation->validate($data)) {
            return $validation->getMessages();
        }
        $user_resourcesModel = new rbac_resources();


        $user_resourcesModel->setData($data);
        if ($user_resourcesModel->save() === false) {
            return $user_resourcesModel->getMessages();
        }
        return true;
    }

    /**
     * 获取资源等级
     * @param $pid 腹肌资源的id
     * @return int 当前资源的等级
     */
    private static function resources_lv($pid)
    {
        if ($pid == 0) {
            return 1;
        }
        $info = self::resources_info($pid);
        return $info->lv + 1;
    }

    /**
     * 资源信息
     */
    public static function resources_info($id)
    {
        return rbac_resources::findFirstById($id);
    }

    /**
     * 编辑资源信息
     *
     * @param $data
     */
    public static function edit_resources($data)
    {
        $validation = new Resources();
        if (!$validation->validate($data)) {
            return $validation->getMessages();
        }
        $dob = rbac_resources::findFirst('id=' . $data['id']);
        $data['lv'] = self::resources_lv($data['pid']);
        $dob->setData($data);
        if ($dob->update() === false) {
            return $dob->getMassage();
        }
        return true;
    }

    /**
     * 权限列表
     * @param type $role_id
     */
    public static function auths(int $role_id, string $index = 'index')
    {
        if (empty(self::$auths)) {
            self::authsAll();
        }
        if (isset(self::$auths[$index][$role_id])) {
            return self::$auths[$index][$role_id];
        } else {
            return [];
        }
    }

    /**
     *  读取所有权限
     */
    private static function authsAll()
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

        self::$auths['index'] = $index_arr;
        self::$auths['list'] = $list2;
        return $index_arr;
    }

    /**
     * 根据资源索引获取资源
     */
    private static function ri2ra($index)
    {
        if (empty(self::$resources)) {
            self::resourcesAll();
        }

        if (isset(self::$resources['index'][$index])) {
            return self::$resources['index'][$index];
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
        self::$resources['list'] = $list;
        self::$resources['recursion'] = $recursion;
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
        self::$resources['array'] = $ar;
        self::$resources['index'] = $index_array;

        return $ar;
    }

    /**
     * 获取资源列表
     */
    public static function resources($index = 'array')
    {
        if (empty(self::$resources)) {
            self::resourcesAll();
        }
        return self::$resources[$index];
    }

}
