<?php

namespace Synolia\Bundle\CreditLineBundle\Method\Config\Provider;

use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;
use Synolia\Bundle\CreditLineBundle\Entity\CreditLineSettings;
use Synolia\Bundle\CreditLineBundle\Entity\Repository\CreditLineSettingsRepository;
use Synolia\Bundle\CreditLineBundle\Method\Config\CreditLineConfigInterface;
use Synolia\Bundle\CreditLineBundle\Method\Config\Factory\CreditLineConfigFactoryInterface;

class CreditLineConfigProvider implements CreditLineConfigProviderInterface
{
    protected ManagerRegistry $doctrine;

    protected CreditLineConfigFactoryInterface $configFactory;

    /** @var CreditLineConfigInterface[] */
    protected array $configs;

    protected LoggerInterface $logger;

    public function __construct(
        ManagerRegistry $doctrine,
        LoggerInterface $logger,
        CreditLineConfigFactoryInterface $configFactory
    ) {
        $this->doctrine = $doctrine;
        $this->logger = $logger;
        $this->configFactory = $configFactory;
    }

    public function getPaymentConfigs(): array
    {
        $configs = [];

        $settings = $this->getEnabledIntegrationSettings();

        foreach ($settings as $setting) {
            $config = $this->configFactory->create($setting);

            $configs[$config->getPaymentMethodIdentifier()] = $config;
        }

        return $configs;
    }

    public function getPaymentConfig(string $identifier): ?CreditLineConfigInterface
    {
        $paymentConfigs = $this->getPaymentConfigs();

        if ([] === $paymentConfigs || false === array_key_exists($identifier, $paymentConfigs)) {
            return null;
        }

        return $paymentConfigs[$identifier];
    }

    public function hasPaymentConfig(string $identifier): bool
    {
        return null !== $this->getPaymentConfig($identifier);
    }

    /**
     * @return CreditLineSettings[]
     */
    protected function getEnabledIntegrationSettings(): array
    {
        try {
            /** @var CreditLineSettingsRepository $repository */
            $repository = $this->doctrine
                ->getManagerForClass(CreditLineSettings::class)
                ->getRepository(CreditLineSettings::class);

            return $repository->getEnabledSettings();
        } catch (\UnexpectedValueException $e) {
            $this->logger->critical($e->getMessage());

            return [];
        }
    }
}
