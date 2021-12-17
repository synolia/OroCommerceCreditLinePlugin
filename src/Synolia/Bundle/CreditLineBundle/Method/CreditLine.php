<?php

namespace Synolia\Bundle\CreditLineBundle\Method;

use Oro\Bundle\PaymentBundle\Context\PaymentContextInterface;
use Oro\Bundle\PaymentBundle\Entity\PaymentTransaction;
use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;
use Synolia\Bundle\CreditLineBundle\Manager\CustomerCreditLineManagerInterface;
use Synolia\Bundle\CreditLineBundle\Method\Config\CreditLineConfigInterface;

class CreditLine implements PaymentMethodInterface
{
    private CustomerCreditLineManagerInterface $creditLineManager;
    private CreditLineConfigInterface $config;

    public function __construct(
        CustomerCreditLineManagerInterface $creditLineManager,
        CreditLineConfigInterface $config
    ) {
        $this->config = $config;
        $this->creditLineManager = $creditLineManager;
    }

    public function execute($action, PaymentTransaction $paymentTransaction): array
    {
        if (!$this->supports($action)) {
            throw new \InvalidArgumentException(sprintf('Unsupported action "%s"', $action));
        }

        return $this->{$action}($paymentTransaction) ?: [];
    }

    public function getIdentifier(): string
    {
        return $this->config->getPaymentMethodIdentifier();
    }

    /**
     * @SuppressWarnings(PHPMD)
     */
    public function isApplicable(PaymentContextInterface $context): bool
    {
        return true;
    }

    public function supports($actionName): bool
    {
        return $actionName === self::PURCHASE;
    }

    public function purchase(PaymentTransaction $paymentTransaction): array
    {
        $isSuccess = $this->subtractCreditLine($paymentTransaction);

        $paymentTransaction
            ->setSuccessful($isSuccess)
            ->setActive($isSuccess);

        return ['isSuccess' => $isSuccess];
    }

    protected function subtractCreditLine(PaymentTransaction $paymentTransaction): bool
    {
        $customer = $paymentTransaction->getFrontendOwner()->getCustomer();

        if (!$customer) {
            return false;
        }
        return $this->creditLineManager->subtractCreditLineAmount($customer, $paymentTransaction->getAmount());
    }
}
