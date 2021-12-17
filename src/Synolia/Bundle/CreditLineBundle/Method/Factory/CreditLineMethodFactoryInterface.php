<?php


namespace Synolia\Bundle\CreditLineBundle\Method\Factory;

use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;
use Synolia\Bundle\CreditLineBundle\Method\Config\CreditLineConfigInterface;

interface CreditLineMethodFactoryInterface
{
    public function create(CreditLineConfigInterface $config): PaymentMethodInterface;
}
