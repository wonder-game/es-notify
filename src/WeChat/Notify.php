<?php

namespace WonderGame\EsNotify\WeChat;

use EasySwoole\WeChat\Factory;
use EasySwoole\WeChat\OfficialAccount\Application as OfficialAccount;
use WonderGame\EsNotify\Interfaces\ConfigInterface;
use WonderGame\EsNotify\Interfaces\MessageInterface;
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


    public function __construct(ConfigInterface $Config)
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
     * @param MessageInterface $message
     * @return void
     */
    public function does(MessageInterface $message)
    {
        $url = $this->Config->getUrl();
        $toOpenid = $this->Config->getToOpenid();


        list($templateId, $data) = $message->fullData();

        foreach ($toOpenid as $openid)
        {
            try {
                $this->OfficialAccount->templateMessage->send([
                    'touser' => $openid,
                    'template_id' => $templateId,
                    'url' => $url,
                    'data' => $data,
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
