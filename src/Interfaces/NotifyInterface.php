<?php

namespace WonderGame\EsNotify\Interfaces;

interface NotifyInterface
{
    public function register(ConfigInterface $Config);

    public function does(array $params);
}
