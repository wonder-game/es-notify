<?php

namespace WonderGame\EsNotify;

use EasySwoole\Component\Singleton;
use WonderGame\EsNotify\Interfaces\ConfigInterface;
use WonderGame\EsNotify\Interfaces\NotifyInterface;

class EsNotify
{
    use Singleton;

    protected $container = [];

    public function register(ConfigInterface $Config, string $name = 'default')
    {
        if (isset($this->container[$name]))
        {
            throw new \Exception('EsNotify name already exists: ' . $name);
        }

        $className = $Config->notifyClassName();
        /** @var NotifyInterface $class */
        $class = new $className();
        $class->register($Config);

        $this->container[$name] = $class;
    }

    public function getContainer(string $name):? NotifyInterface
    {
        return $this->container[$name] ?? null;
    }

    /**
     * 执行某一个
     * @param string $name
     * @param array $params
     * @return void
     */
    public function doesOne(string $name, array $params = [])
    {
        if ($Notify = $this->getContainer($name))
        {
            $Notify->does($params);
        }
    }

    /**
     * 执行所有
     * @param array $params
     * @return void
     */
    public function doesAll(array $params = [])
    {
        /**
         * @var string $name
         * @var NotifyInterface $Notify
         */
        foreach ($this->container as $name => $Notify)
        {
            $Notify->does($params);
        }
    }
}
