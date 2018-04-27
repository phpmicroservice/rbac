<?php
/**
 * Created by PhpStorm.
 * User: Dongasai
 * Date: 2018/4/25
 * Time: 16:38
 */

namespace app\logic;

use app\model\rbac_user as user_role_relationModel;
use app\validator\rbac_role_relation_add;
use app\Base;
use app\validation\AddRole;
use Phalcon\Validation\Message;
use pms\Validation;

class User extends Base
{


    /**
     * 用户角色删除
     * @param $role_id 角色
     * @param $user_id 用户
     * @param bool $must 必须进行删除
     * @return bool|string
     */
    public function user_del_role($role_id, $user_id, $must = false)
    {
        $where = [
            'conditions' => 'uid =:user_id: and role_id  = :role_id:',
            'bind' => [
                'user_id' => $user_id,
                'role_id' => $role_id
            ]
        ];
        $user_role_relationModel = user_role_relationModel::findFirst($where);
        if (empty($user_role_relationModel)) {
            if ($must) {
                return '_empty-info';
            } else {
                return true;
            }
        }

        if ($user_role_relationModel->delete() === false) {
            return $user_role_relationModel->getMessages();
        }
        return true;
    }

    /**
     * 角色和用户绑定
     * @param $data
     * @return bool|string
     */
    public static function add_user($user_id, $role_id)
    {
        $data = [
            'uid' => $user_id,
            'role_id' => $role_id
        ];
//        user_role_relation_add
        $validation = new AddRole();
        $validation->validate($data);
        if ($validation->isError()) {
            return $validation->getMessages();
        }
        $data['status'] = 1;
        $data['step'] = 0;
        # 验证通过
        # 判断旧数据
        $user_role_relation = new user_role_relationModel();
        $user_role_relation->setData($data);
        if ($user_role_relation->save() === false) {

            return $user_role_relation->getMessages();
        }
        return true;
    }


    /**
     * 读取当前用户的权限列表
     * @return array
     */
    public static function role(int $user_id)
    {
        # 没能读取用户的 角色信息
        # 读取一下
        $roles = self::user($user_id);
        # 增加一个游客权限
        $roles['visitor'] = 0;
        return $roles;
    }


    /**
     * 角色的用户列表
     * @param $role
     * @param $page
     */
    public function role_user_list($role_id, $page)
    {
        $modelsManager = $this->modelsManager;
        $builder = $modelsManager->createBuilder()
            ->from(user_role_relationModel::class)
            ->andWhere('role_id = :role_id:', [
                'role_id' => $role_id
            ]);

        $builder->orderBy("id");
        $paginator = new \Phalcon\Paginator\Adapter\QueryBuilder(
            [
                "builder" => $builder,
                "limit" => 10,
                "page" => $page,
            ]
        );
        return $paginator->getPaginate();
    }

    /**
     * 清空角色的用户关联
     * @param $role_id
     */
    public function empty_user_role($role_id)
    {

        $list = user_role_relationModel::find([
            'role_id = :role_id:',
            'bind' => [
                'role_id' => $role_id
            ],
            'limit' => 100
        ]);
        if ($list === false) {
            return '_empty-error';
        }
        foreach ($list as $user_role_relation) {
            if ($user_role_relation->delete() === false) {
                return $user_role_relation->getMessages();
            }
        }
        if (user_role_relationModel::count([
                'role_id = :role_id:',
                'bind' => ['role_id' => $role_id]]) > 0) {
            return '大于100,只删除了前100个';
        } else {
            return '成功!';
        }
    }

    /**
     * 判断用户角色
     * @param $user_id 用户id
     * @param $role_name 角色标识
     * @return bool 是否存在
     * @throws \Phalcon\Validation\Exception 验证器不存在
     */
    public function role_user_is($user_id, $role_name)
    {
        $validation = new Validation();;
        $validation->add_Validator('user_id', [
            'name' => \app\validator\rbac_role::class,
            'role_name' => $role_name
        ]);
        if (!$validation->validate(['user_id' => $user_id])) {
            return false;
        }
        return true;
    }

    /**
     * 获取用户 的 角色 列表
     * @param int $uid
     * @return array
     */
    public static function user(int $uid = 0): array
    {
        output($uid, 113);
        $user_role_relationModel = new user_role_relationModel();
        $list = $user_role_relationModel->user_roles($uid);
        return $list;
    }

    /**
     * 获取 索引的用户角色列表
     * @param int $uid
     * @return array
     */
    public static function user_roles_index(int $uid): array
    {
        $user_role_relationModel = new user_role_relationModel();
        $list = $user_role_relationModel->user_roles_index($uid);
        return $list->toArray();
    }

}