<?php

namespace WonderGame\EsNotify\WeChat\Message;

class Warning extends Base
{
    protected $file = '';

    protected $line = '';

    protected $servername = '';

    protected $message = '';

    protected $color = '#FF0000';

    public function struct()
    {
        return [
            'first' => [
                'value' => "程序异常：第{$this->line}行",
                'color' => $this->color
            ],
            'keyword1' => [
                'value' => "服务器： {$this->servername}",
                'color' => $this->color
            ],
            'keyword2' => [
                'value' => "相关文件： {$this->file}",
                'color' => $this->color
            ],
            'keyword3' => [
                'value' => "相关内容：{$this->message}",
                'color' => $this->color
            ],
            'keyword4' => date('Y年m月d日 H:i:s'),
            'remark' => '查看详情'
        ];
    }
}
