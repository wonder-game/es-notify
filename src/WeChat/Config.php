<?php

namespace WonderGame\EsNotify\WeChat;

use WonderGame\EsNotify\Interfaces\ConfigInterface;
use EasySwoole\Spl\SplBean;

class Config extends SplBean implements ConfigInterface
{
    /**
     * 微信公众平台后台的 appid
     * @var string
     */
    protected $appId = '';

    /**
     * 微信公众平台后台配置的 AppSecret
     * @var string
     */
    protected $appSecret = '';

    /**
     * 微信公众平台后台配置的 Token
     * @var string
     */
    protected $token = '';

    /**
     * 注册WeChat实例时追加的配置
     * @var array
     */
    protected $append = [];

    /**
     * 发送给谁, openid[]
     * @var array
     */
    protected $toOpenid = [];

    /**
     * 点击后跳转地址
     * @var string
     */
    protected $url = '';

    public function setAppId($appId)
    {
        $this->appId = $appId;
    }

    public function getAppId()
    {
        return $this->appId;
    }

    public function setAppSecret($appSecret)
    {
        $this->appSecret = $appSecret;
    }

    public function getAppSecret()
    {
        return $this->appSecret;
    }

    public function setToken($token)
    {
        $this->token = $token;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function setAppend(array $append = [])
    {
        $this->append = $append;
    }

    public function getAppend()
    {
        return $this->append;
    }

    public function setToOpenid($openid)
    {
        if (is_string($openid))
        {
            $openid = [$openid];
        }
        $this->toOpenid = $openid;
    }

    public function getToOpenid()
    {
        return $this->toOpenid;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function notifyClassName()
    {
        return Notify::class;
    }
}
