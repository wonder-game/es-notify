<?php

namespace WonderGame\EsNotify\DingTalk\Message;

use EasySwoole\Spl\SplBean;
use WonderGame\EsNotify\Interfaces\MessageInterface;

abstract class Base extends SplBean implements MessageInterface
{
    /**
     * 手机号
     * @var array
     */
    protected $atMobiles = [];

    /**
     * Userid
     * @var array
     */
    protected $atUserIds = [];

    protected $isAtAll = false;

    public function getAtText($text = '')
    {
        foreach (['atMobiles', 'atUserIds'] as $item)
        {
            foreach ($this->{$item} as $tel)
            {
                $text .= ' @' . $tel;
            }
        }
        return $text;
    }
}
