<?php

namespace app\filterTool;

use pms\FilterTool\FilterTool;

class AddRole extends FilterTool
{
    # 数据过滤规则
    protected $_Rules = [
        ['identification', 'string'],
        ['name', 'string'],
        ['sort', 'int'],
        ['status', 'int'],
        ['pid', 'int'],
        ['can_delete', 'int']
    ];

    protected function initialize()
    {

        parent::initialize(); // TODO: Change the autogenerated stub
    }
}