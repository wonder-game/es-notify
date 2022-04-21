<?php

namespace WonderGame\EsNotify\Interfaces;

interface ConfigInterface
{
    public function getNotifyClass(): NotifyInterface;
}
