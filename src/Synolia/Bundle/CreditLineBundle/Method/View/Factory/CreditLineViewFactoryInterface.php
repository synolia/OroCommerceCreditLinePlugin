<?php

namespace Synolia\Bundle\CreditLineBundle\Method\View\Factory;

use Oro\Bundle\PaymentBundle\Method\View\PaymentMethodViewInterface;
use Synolia\Bundle\CreditLineBundle\Method\Config\CreditLineConfigInterface;

interface CreditLineViewFactoryInterface
{
    public function create(CreditLineConfigInterface $config): PaymentMethodViewInterface;
}
