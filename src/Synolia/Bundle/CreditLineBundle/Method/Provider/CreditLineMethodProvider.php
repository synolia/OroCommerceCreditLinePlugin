<?php

namespace Synolia\Bundle\CreditLineBundle\Method\Provider;

use Oro\Bundle\PaymentBundle\Method\Provider\AbstractPaymentMethodProvider;
use Synolia\Bundle\CreditLineBundle\Method\Config\CreditLineConfigInterface;
use Synolia\Bundle\CreditLineBundle\Method\Config\Provider\CreditLineConfigProviderInterface;
use Synolia\Bundle\CreditLineBundle\Method\Factory\CreditLineMethodFactoryInterface;

class CreditLineMethodProvider extends AbstractPaymentMethodProvider
{
    protected CreditLineMethodFactoryInterface $factory;

    private CreditLineConfigProviderInterface $configProvider;

    public function __construct(
        CreditLineConfigProviderInterface $configProvider,
        CreditLineMethodFactoryInterface $factory
    ) {
        parent::__construct();

        $this->configProvider = $configProvider;
        $this->factory = $factory;
    }

    protected function collectMethods()
    {
        $configs = $this->configProvider->getPaymentConfigs();
        foreach ($configs as $config) {
            $this->addCreditLineMethod($config);
        }
    }

    protected function addCreditLineMethod(CreditLineConfigInterface $config)
    {
        $this->addMethod(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}
