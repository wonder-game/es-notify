<?php

namespace WonderGame\EsNotify\WeChat\Message;

use EasySwoole\Spl\SplBean;
use WonderGame\EsNotify\Interfaces\MessageInterface;

/**
 * 每个微信模板结构都不同，此Message目录仅定义通用的几个，如果各项目需要增加模板，请继承此类
 */
abstract class Base extends SplBean implements MessageInterface
{
    abstract public function getTmpId();

    abstract public function struct();

    public function fullData()
    {
        return [$this->getTmpId(), $this->struct()];
    }
}
