<?php

namespace WonderGame\EsNotify;

use EasySwoole\Component\Singleton;
use WonderGame\EsNotify\Interfaces\ConfigInterface;
use WonderGame\EsNotify\Interfaces\MessageInterface;
use WonderGame\EsNotify\Interfaces\NotifyInterface;

class EsNotify
{
    use Singleton;

    protected $container = [];

    protected function getContainer(string $type, string $name = 'default'): ?NotifyInterface
    {
        return $this->container[$type][$name] ?? null;
    }

    public function register(ConfigInterface $Config, string $type, string $name = 'default')
    {
        if (isset($this->container[$type][$name])) {
            throw new \Exception("EsNotify name already exists: $type.$name");
        }

        $this->container[$type][$name] = $Config->getNotifyClass();
    }

    /**
     * 执行某一个
     * @param string $type 类型：dingtalk、wechat
     * @param array $params
     * @param string $name
     * @return void
     */
    public function doesOne(string $type, MessageInterface $message, string $name = 'default')
    {
        if ($Notify = $this->getContainer($type, $name)) {
            $Notify->does($message);
        }
    }

    // 钉钉和微信的 Config Message 不能混用，需识别类型
//    public function doesAll()
}
