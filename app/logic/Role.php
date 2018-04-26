<?php

namespace app\logic;

use app\model\rbac_role;
use app\model\rbac_user as user_role_relationModel;
use app\validation\del_role;
use app\validator\rbac_role_relation_add;
use app\validation\Role as validation_Role;

/**
 * Description of Role
 * @author Dongasai
 */
class Role extends \app\Base
{

    /**
     * 用户角色删除
     * @param $role_id 角色
     * @param $user_id 用户
     * @param bool $must 必须进行删除
     * @return bool|string
     */
    public static function user_del_role($role_id, $user_id, $must = false)
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
        $validation = new \core\CoreValidation();
        $validation->add_exist('role_id', [
            'message' => 'exist',
            'class_name_list' => rbac_role::class,
        ]);
        $validation->add_exist('uid', [
            'message' => 'exist',
            'class_name_list' => \logic\user\model\User::class
        ]);
        $validation->add_exist('uid', [
            'message' => 'exist',
            'class_name_list' => \logic\user\model\User::class
        ]);

        $validation->add_Validator('role_id', [
            'name' => rbac_role_relation_add::class,
            'message' => 'user_role_relation_add'
        ]);
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
     * 获取角色列表
     */
    public static function roles()
    {
        return \app\model\rbac_role::find();
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

    /**
     * 判断用户角色
     * @param $user_id 用户id
     * @param $role_name 角色标识
     * @return bool 是否存在
     * @throws \Phalcon\Validation\Exception 验证器不存在
     */
    public function role_user_is($user_id, $role_name)
    {
        $validation = new \core\CoreValidation();;
        $validation->add_Validator('user_id', [
            'name' => \logic\rbac\validator\rbac_role::class,
            'role_name' => $role_name
        ]);
        if (!$validation->validate(['user_id' => $user_id])) {
            return false;
        }
        return true;

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
            'where' => $data['findFirstByidentification']
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
