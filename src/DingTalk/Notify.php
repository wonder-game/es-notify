<?php

namespace WonderGame\EsNotify\DingTalk;

use EasySwoole\HttpClient\HttpClient;
use WonderGame\EsNotify\Interfaces\ConfigInterface;
use WonderGame\EsNotify\Interfaces\NotifyInterface;

class Notify implements NotifyInterface
{
    /**
     * @var Config
     */
    protected $Config = null;

    public function register(ConfigInterface $Config)
    {
        $this->Config = $Config;
    }

    /**
     * @document https://open.dingtalk.com/document/group/custom-robot-access
     * 每个机器人每分钟最多发送20条消息到群里，如果超过20条，会限流10分钟
     * @param array $params
     * @return void
     */
    public function does(array $params)
    {
        // 默认markdown类型
        $params['msgtype'] = $params['msgtype'] ?? 'markdown';

        // 处理不同的格式
        $method = '_before' . ucfirst($params['msgtype']);
        if (!method_exists($this, $method))
        {
            return;
        }
        $array = $this->$method($params);

        $url = $this->Config->getUrl();
        $secret = $this->Config->getSignKey();

        // 签名 &timestamp=XXX&sign=XXX
        $timestamp = round(microtime(true), 3) * 1000;

        $sign = utf8_encode(urlencode(base64_encode(hash_hmac('sha256', $timestamp . "\n" . $secret, $secret, true))));

        $url .= "&timestamp={$timestamp}&sign={$sign}";

        $client = new HttpClient($url);

        // 支持文本 (text)、链接 (link)、markdown(markdown)、ActionCard、FeedCard消息类型

        $response = $client->postJson(json_encode($array));
        $json = json_decode($response->getBody(), true);

        if ($json['errcode'] !== 0)
        {
            // todo 异常处理
        }
    }

    protected function getAtArray($content = '')
    {
        $at = $this->Config->getAt();
        $atArray = [];
        if (is_bool($at)) {
            $atArray = ['isAtAll' => $at];
        }
        elseif (is_array($at))
        {
            // 指定@哪些人的时候，在text内容里要有@人的手机号，只有在群内的成员才可被@，非群内成员手机号会被脱敏。
            foreach ($at as $tel)
            {
                $content .= ' @' . $tel;
            }
            $atArray = $at;
        }
        return [$atArray, $content];
    }

    /**
     * @param $params [content => 文本内容]
     * @return array
     */
    protected function _beforeText($params = [])
    {
        // todo 参数检查 抛异常终止程序
        list($atArray, $params['content']) = $this->getAtArray($params['content']);
        $data = [
            'msgtype' => 'text',
            'text' => ['content' => $params['content']],
            'at' => $atArray
        ];
        $atArray && $data['at'] = $atArray;
        return $data;
    }

    /**
     * @param $params [text => 正文, title => 标题]
     * @return array
     */
    protected function _beforeMarkdown($params = [])
    {
        list($atArray, $params['text']) = $this->getAtArray($params['text']);
        $data = [
            'msgtype' => 'markdown',
            'markdown' => [
                'title' => $params['title'] ?? '',
                'text' => $params['text']
            ]
        ];
        $atArray && $data['at'] = $atArray;
        return $data;
    }
}
