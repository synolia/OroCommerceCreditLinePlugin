<?php

namespace Synolia\Bundle\CreditLineBundle\Method\View\Factory;

use Oro\Bundle\SecurityBundle\Authentication\TokenAccessorInterface;
use Synolia\Bundle\CreditLineBundle\Manager\CustomerCreditLineManagerInterface;
use Synolia\Bundle\CreditLineBundle\Method\Config\CreditLineConfigInterface;
use Synolia\Bundle\CreditLineBundle\Method\View\CreditLineView;

class CreditLineViewFactory implements CreditLineViewFactoryInterface
{
    private TokenAccessorInterface $tokenAccessor;

    protected CustomerCreditLineManagerInterface $creditLineManager;

    public function __construct(
        TokenAccessorInterface $tokenAccessor,
        CustomerCreditLineManagerInterface $creditLineManager
    ) {
        $this->tokenAccessor = $tokenAccessor;
        $this->creditLineManager = $creditLineManager;
    }

    public function create(CreditLineConfigInterface $config): CreditLineView
    {
        return new CreditLineView($config, $this->tokenAccessor, $this->creditLineManager);
    }
}
