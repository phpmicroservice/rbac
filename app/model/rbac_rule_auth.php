<?php

namespace app\model;

/**
 * Description of user_rule_auth
 *
 * @author Dongasai
 */
class rbac_rule_auth extends \pms\Mvc\Model
{
    public $resources;


    /**
     * 检查是否唯一
     * @param $data
     */
    public function check_uniqueness($data): bool
    {
        if (empty($data['role']) or empty($data['resources'])) {
            return false;
        }
        $re = $this->query()
            ->where('role = ' . $data['role'])
            ->andWhere('resources = ' . $data['resources'])
            ->execute();
        if (empty($re->toArray())) {
            return false;
        }
        return true;
    }
}
