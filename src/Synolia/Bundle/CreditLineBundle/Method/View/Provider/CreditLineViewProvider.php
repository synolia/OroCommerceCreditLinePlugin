<?php

namespace Synolia\Bundle\CreditLineBundle\Method\View\Provider;

use Oro\Bundle\PaymentBundle\Method\View\AbstractPaymentMethodViewProvider;
use Synolia\Bundle\CreditLineBundle\Method\Config\CreditLineConfigInterface;
use Synolia\Bundle\CreditLineBundle\Method\Config\Provider\CreditLineConfigProviderInterface;
use Synolia\Bundle\CreditLineBundle\Method\View\Factory\CreditLineViewFactoryInterface;

class CreditLineViewProvider extends AbstractPaymentMethodViewProvider
{
    private CreditLineViewFactoryInterface $factory;

    private CreditLineConfigProviderInterface $configProvider;

    public function __construct(
        CreditLineConfigProviderInterface $configProvider,
        CreditLineViewFactoryInterface $factory
    ) {
        $this->factory = $factory;
        $this->configProvider = $configProvider;

        parent::__construct();
    }

    protected function buildViews()
    {
        $configs = $this->configProvider->getPaymentConfigs();
        foreach ($configs as $config) {
            $this->addCreditLineView($config);
        }
        return $this->views;
    }

    protected function addCreditLineView(CreditLineConfigInterface $config)
    {
        $this->addView(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}
