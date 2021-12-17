<?php

namespace Synolia\Bundle\CreditLineBundle\Method\View;

use Oro\Bundle\CustomerBundle\Entity\CustomerUser;
use Oro\Bundle\PaymentBundle\Context\PaymentContextInterface;
use Oro\Bundle\PaymentBundle\Method\View\PaymentMethodViewInterface;
use Oro\Bundle\SecurityBundle\Authentication\TokenAccessorInterface;
use Synolia\Bundle\CreditLineBundle\Manager\CustomerCreditLineManagerInterface;
use Synolia\Bundle\CreditLineBundle\Method\Config\CreditLineConfigInterface;

class CreditLineView implements PaymentMethodViewInterface
{
    protected CreditLineConfigInterface $config;

    private TokenAccessorInterface $tokenAccessor;

    private CustomerCreditLineManagerInterface $creditLineManager;

    public function __construct(
        CreditLineConfigInterface $config,
        TokenAccessorInterface $tokenAccessor,
        CustomerCreditLineManagerInterface $creditLineManager
    ) {
        $this->config = $config;
        $this->tokenAccessor = $tokenAccessor;
        $this->creditLineManager = $creditLineManager;
    }

    public function getOptions(PaymentContextInterface $context): array
    {
        $user = $this->tokenAccessor->getUser();

        if (!$user instanceof CustomerUser) {
            return [];
        }

        return [
            'sy_credit_line' => $this->creditLineManager->getCreditLineAmount($user->getCustomer()),
            'total_value' => $context->getTotal(),
            'payment_method' => $this->getPaymentMethodIdentifier(),
        ];
    }

    public function getBlock(): string
    {
        return '_payment_methods_credit_line_widget';
    }

    public function getLabel(): string
    {
        return $this->config->getLabel();
    }

    public function getShortLabel(): string
    {
        return $this->config->getShortLabel();
    }

    public function getAdminLabel(): string
    {
        return $this->config->getAdminLabel();
    }

    public function getPaymentMethodIdentifier(): string
    {
        return $this->config->getPaymentMethodIdentifier();
    }
}
