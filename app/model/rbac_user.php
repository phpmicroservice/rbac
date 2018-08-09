<?php

namespace app\model;

/**
 * Description of user_role_relation
 *
 * @author Dongasai
 */
class rbac_user extends \pms\Mvc\Model
{

    public $role_id;
    protected $uid = 0;

    public function initialize()
    {

    }

    /**
     * 获取键值对的角色列表
     * @param int $uid
     * @return array
     */
    public function user_roles(int $uid)
    {
        $list = $this->user_roles_index($uid);
        return array_column($list->toArray(), 'sort', 'identification');
    }

    /**
     * 获取索引的 用户角色列表
     * @param int $uid
     */
    public function user_roles_index(int $uid): \Phalcon\Mvc\Model\Resultset\Simple
    {
        $ModelsManager = $this->getModelsManager();
        return $ModelsManager->createBuilder()
            ->from(['user_role_relation' => self::class])
            ->where('uid= :uid:', ['uid' => $uid])
            ->orderBy('role.sort DESC')
            ->columns(['role.identification', 'role.sort', 'role_id'])
            ->join(rbac_role::class, 'user_role_relation.role_id = role.id ', 'role')
            ->getQuery()
            ->execute();
    }

    /**
     * 创始人不可以删除
     * @return bool
     */
    public function beforeDelete()
    {
        if ($this->id == 1) {
            return false;
        }
        return true;
    }

}
