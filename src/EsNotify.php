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

    protected function getContainer(string $name):? NotifyInterface
    {
        return $this->container[$name] ?? null;
    }

    public function register(ConfigInterface $Config, string $name = 'default')
    {
        if (isset($this->container[$name]))
        {
            throw new \Exception('EsNotify name already exists: ' . $name);
        }

        $this->container[$name] = $Config->getNotifyClass();
    }

    /**
     * 执行某一个
     * @param string $name
     * @param array $params
     * @return void
     */
    public function doesOne(string $name, MessageInterface $message)
    {
        if ($Notify = $this->getContainer($name))
        {
            $Notify->does($message);
        }
    }

    // 钉钉和微信的 Config Message 不能混用，需识别类型
//    public function doesAll()
}
