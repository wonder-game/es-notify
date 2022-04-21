<?php

namespace WonderGame\EsNotify\DingTalk;

use WonderGame\EsNotify\Interfaces\ConfigInterface;

class Config implements ConfigInterface
{
    public function notifyClassName()
    {
        return Notify::class;
    }
}
