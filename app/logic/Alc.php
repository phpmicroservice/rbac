<?php

namespace app\logic;

use app\Base;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Resource;
use Phalcon\Acl\Role;

/**
 * alc
 * 权限控制
 * @author Dongasai
 */
class Alc extends Base
{

    private $aclp; #权限控制对象
    private $roleNames;# 角色列表

    public function __construct($user_id = 0)
    {
        $this->load_acl(); #读取权限列表
        $this->roleNames = User::role($user_id);
        output($this->roleNames, 'roleNames');

    }

    public function getRoleNames()
    {
        return $this->roleNames;
    }


    /**
     * 读取权限控制
     */
    private function load_acl()
    {


        $acl_data = $this->gCache->get('alc');
        if (1) {
            $acl = new AclList();
            # 读取资源
            $this->load_resources($acl);
            // 设置默认访问级别为拒绝
            $acl->setDefaultAction(
                \Phalcon\Acl::DENY
            );
            # 读取角色列表
            $user_roles = \app\logic\Role::roles();
            $user_roles_index = \funch\Arr::array_change_index($user_roles->toArray(), 'id');
            $roleObj = [];
            foreach ($user_roles_index as $k => $role) {

                $roleObj[$k] = new Role($role['identification'], $role['name']);
                $acl->addRole($roleObj[$k]);
                if ($role['pid']) {
                    $acl->addRole($roleObj[$k], $roleObj[$k]);
                }
                $this->load_auth($user_roles_index, $role, $acl);
            }

            $this->gCache->save('alc', $acl, 2);
        } else {
            $acl = unserialize($acl_data);
        }
        $this->aclp = $acl;
    }

    /**
     * 读取资源
     */
    private function load_resources(&$acl)
    {
        # 读取用户角色列表
        $user_roles = \app\logic\Alc2::resources();
        foreach ($user_roles as $k => $v) {
            // 定义 "Customers" 资源
            $Resource = new Resource($k);
            // 为 "customers"资源添加一组操作
            $acl->addResource(
                $Resource, $v
            );
        }
    }


    /**
     * 读取权限
     * @param type $role
     */
    private function load_auth($user_roles, $role, \Phalcon\Acl\Adapter\Memory &$alc)
    {
        $auths = \app\logic\Alc2::auths($role['id']);
        if ($role['pid']) {
            $this->load_auth($user_roles, $user_roles[$role['pid']], $alc);
        }
        foreach ($auths as $auth) {
            if (empty($auth['resource'])) {
                continue;
            }
            if ($auth['type']) {
                $alc->allow($role['identification'], $auth['resource']['controller'], $auth['resource']['action']);
            } else {
                $alc->deny($role['identification'], $auth['resource']['controller'], $auth['resource']['action']);
            }
        }
    }

    /**
     * 权限判断
     * @param $resourceName
     * @param $actionName
     */
    public function isAllowed($resourceName, $actionName)
    {
        $resourceName = strtolower($resourceName);
        $actionName = strtolower($actionName);
        $re = $this->isAllowed2($this->roleNames, $resourceName, $actionName);
        output(["权限鉴定结果!", $resourceName, $actionName, $re], "info");
        return $re;
    }


    /**
     * 多角色的权限验证
     */
    private function isAllowed2($roleNames, $resourceName, $access): bool
    {
        # 角色数量
        $roleNumber = count($roleNames);
        $first = false; # 第一个角色
        var_dump($roleNames);
        foreach ($roleNames as $role => $sort) {
            # 设置一个特例 调试模式下,admin拥有所有权限
            if ($role == 'sadmin') {
                return true;
            }

            $isAllowed = $this->aclp->isAllowed($role, $resourceName, $access);
            var_dump($isAllowed);

            if ($roleNumber == 1) {
                #单角色 直接跳出
                break;
            }
            if ($roleNumber > 1 && !$first) {
                # 第一个角色不处理
                $first = true;
                $isAllowedOld = $isAllowed;
                $sortOld = $sort;
                continue;
            }
            # 多角色处理
            if ($sortOld > $sort) {
                $isAllowed = $isAllowedOld;
                break;
            } else {
                $isAllowed = ($isAllowedOld or $isAllowed);
            }
            $isAllowedOld = $isAllowed;
            $sortOld = $sort;
        }
        return $isAllowed;
    }

}


