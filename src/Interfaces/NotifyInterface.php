<?php

namespace WonderGame\EsNotify\Interfaces;

interface NotifyInterface
{
    public function does(MessageInterface $message);
}
