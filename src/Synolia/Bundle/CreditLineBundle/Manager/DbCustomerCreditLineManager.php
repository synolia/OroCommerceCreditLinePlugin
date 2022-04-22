<?php

namespace Synolia\Bundle\CreditLineBundle\Manager;

use Oro\Bundle\CustomerBundle\Entity\Customer;
use Oro\Bundle\EntityBundle\ORM\DoctrineHelper;

class DbCustomerCreditLineManager implements CustomerCreditLineManagerInterface
{
    protected DoctrineHelper $doctrineHelper;

    public function __construct(DoctrineHelper $doctrineHelper)
    {
        $this->doctrineHelper = $doctrineHelper;
    }

    public function getCreditLineAmount(Customer $customer): float
    {
        // @phpstan-ignore-next-line
        return $customer->getSyCreditLine() ?? 0;
    }

    public function subtractCreditLineAmount(Customer $customer, float $amount): bool
    {
        // @phpstan-ignore-next-line
        if ($customer->getSyCreditLine() < $amount) {
            return false;
        }

        // @phpstan-ignore-next-line
        $customer->setSyCreditLine($customer->getSyCreditLine() - $amount);
        $this->doctrineHelper->getEntityManager($customer)->flush($customer);

        return true;
    }
}
