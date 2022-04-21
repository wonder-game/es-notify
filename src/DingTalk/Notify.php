<?php

namespace WonderGame\EsNotify\DingTalk;

use WonderGame\EsNotify\Interfaces\ConfigInterface;
use WonderGame\EsNotify\Interfaces\NotifyInterface;

class Notify implements NotifyInterface
{
    public function register(ConfigInterface $Config)
    {

    }

    public function does(array $params)
    {
        var_dump(__METHOD__);
    }
}
