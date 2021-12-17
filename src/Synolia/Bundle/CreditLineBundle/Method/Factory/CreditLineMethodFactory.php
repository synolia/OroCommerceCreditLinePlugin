<?php

namespace Synolia\Bundle\CreditLineBundle\Method\Factory;

use Oro\Bundle\EntityBundle\ORM\DoctrineHelper;
use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;
use Synolia\Bundle\CreditLineBundle\Manager\CustomerCreditLineManagerInterface;
use Synolia\Bundle\CreditLineBundle\Method\Config\CreditLineConfigInterface;
use Synolia\Bundle\CreditLineBundle\Method\CreditLine;

class CreditLineMethodFactory implements CreditLineMethodFactoryInterface
{
    private CustomerCreditLineManagerInterface $creditLineManager;

    public function __construct(CustomerCreditLineManagerInterface $creditLineManager)
    {
        $this->creditLineManager = $creditLineManager;
    }

    public function create(CreditLineConfigInterface $config): PaymentMethodInterface
    {
        return new CreditLine($this->creditLineManager, $config);
    }
}
