<?php

namespace Synolia\Bundle\CreditLineBundle\Method\Config\Factory;

use Synolia\Bundle\CreditLineBundle\Entity\CreditLineSettings;
use Synolia\Bundle\CreditLineBundle\Method\Config\CreditLineConfigInterface;

interface CreditLineConfigFactoryInterface
{
    public function create(CreditLineSettings $settings): CreditLineConfigInterface;
}
