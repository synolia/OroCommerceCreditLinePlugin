<?php

namespace Synolia\Bundle\CreditLineBundle\Method\Config\Provider;

use Synolia\Bundle\CreditLineBundle\Method\Config\CreditLineConfigInterface;

/**
 * Interface for config provider which allows to get configs based on payment method identifier
 */
interface CreditLineConfigProviderInterface
{
    /**
     * @return CreditLineConfigInterface[]
     */
    public function getPaymentConfigs(): array;

    public function getPaymentConfig(string $identifier): ?CreditLineConfigInterface;

    public function hasPaymentConfig(string $identifier): bool;
}
