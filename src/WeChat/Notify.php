<?php

namespace WonderGame\EsNotify\WeChat;

use EasySwoole\WeChat\Factory;
use EasySwoole\WeChat\OfficialAccount\Application as OfficialAccount;
use WonderGame\EsNotify\Interfaces\ConfigInterface;
use WonderGame\EsNotify\Interfaces\NotifyInterface;

class Notify implements NotifyInterface
{
    /**
     * @var Config
     */
    protected $Config = null;

    /**
     * @var OfficialAccount
     */
    protected $OfficialAccount = null;

    /**
     * @param Config $Config
     * @return void
     */
    public function register(ConfigInterface $Config)
    {
        $configArray = array_merge(
            [
                'appId' => $Config->getAppId(),
                'token' => $Config->getToken(),
                'appSecret' => $Config->getAppSecret()
            ],
            $Config->getAppend()
        );

        $this->Config = $Config;
        $this->OfficialAccount = Factory::officialAccount($configArray);
    }

    /**
     * @document http://www.easyswoole.com/Components/WeChat2.x/officialAccount/templateMessage.html
     * @param array $params [template => 模板id, data => 要发送的数据]
     * @return void
     */
    public function does(array $params)
    {
        $url = $this->Config->getUrl();
        $toOpenid = $this->Config->getToOpenid();

        foreach (['template', 'data'] as $col)
        {
            if (empty($params[$col]))
            {
                return;
            }
        }

        foreach ($toOpenid as $openid)
        {
            try {
                $this->OfficialAccount->templateMessage->send([
                    'touser' => $openid,
                    'template_id' => $params['template'],
                    'url' => $url,
                    'data' => $params['data'],
                ]);
            }
            // 未关注、取消关注 或 其他
            catch (\Throwable | \Exception $e)
            {
                continue;
            }
        }
    }
}
