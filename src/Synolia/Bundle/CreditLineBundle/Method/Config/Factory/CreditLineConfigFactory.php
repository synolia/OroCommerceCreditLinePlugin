<?php

namespace Synolia\Bundle\CreditLineBundle\Method\Config\Factory;

use Doctrine\Common\Collections\Collection;
use Oro\Bundle\IntegrationBundle\Generator\IntegrationIdentifierGeneratorInterface;
use Oro\Bundle\LocaleBundle\Helper\LocalizationHelper;
use Synolia\Bundle\CreditLineBundle\Entity\CreditLineSettings;
use Synolia\Bundle\CreditLineBundle\Method\Config\CreditLineConfig;

class CreditLineConfigFactory implements CreditLineConfigFactoryInterface
{
    private LocalizationHelper $localizationHelper;

    private IntegrationIdentifierGeneratorInterface $identifierGenerator;

    public function __construct(
        LocalizationHelper $localizationHelper,
        IntegrationIdentifierGeneratorInterface $identifierGenerator
    ) {
        $this->localizationHelper = $localizationHelper;
        $this->identifierGenerator = $identifierGenerator;
    }

    public function create(CreditLineSettings $settings): CreditLineConfig
    {
        $params = [];
        $channel = $settings->getChannel();

        $params[CreditLineConfig::FIELD_LABEL] = $this->getLocalizedValue($settings->getLabels());
        $params[CreditLineConfig::FIELD_SHORT_LABEL] = $this->getLocalizedValue($settings->getShortLabels());
        $params[CreditLineConfig::FIELD_ADMIN_LABEL] = $channel->getName();
        $params[CreditLineConfig::FIELD_PAYMENT_METHOD_IDENTIFIER] =
            $this->identifierGenerator->generateIdentifier($channel);

        return new CreditLineConfig($params);
    }

    private function getLocalizedValue(Collection $values): string
    {
        return (string)$this->localizationHelper->getLocalizedValue($values);
    }
}
