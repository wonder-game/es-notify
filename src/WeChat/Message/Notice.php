<?php

namespace WonderGame\EsNotify\WeChat\Message;

class Notice extends Base
{
    protected $title = '';

    protected $content = '';

    protected $color = '#32CD32';

    public function getTmpId()
    {
        return 'bzuNFewc_MxyTJzAnNzqOQHFzXvvfQ-dTqmKINQvbF8';
    }

    public function struct()
    {
        return [
            'first' => [
                'value' => $this->title,
                'color' => $this->color
            ],
            'keyword1' => [
                'value' => $this->content,
                'color' => $this->color
            ],
            'keyword3' => date('Y年m月d日 H:i:s'),
            'remark' => '查看详情'
        ];
    }
}
