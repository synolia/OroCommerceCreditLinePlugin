<?php

namespace Synolia\Bundle\CreditLineBundle\Manager;

use Oro\Bundle\CustomerBundle\Entity\Customer;

interface CustomerCreditLineManagerInterface
{
    public function getCreditLineAmount(Customer $customer): float;
    public function subtractCreditLineAmount(Customer $customer, float $amount): bool;
}
