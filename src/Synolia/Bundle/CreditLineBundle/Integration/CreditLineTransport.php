<?php

namespace Synolia\Bundle\CreditLineBundle\Integration;

use Oro\Bundle\IntegrationBundle\Entity\Transport;
use Oro\Bundle\IntegrationBundle\Provider\TransportInterface;
use Synolia\Bundle\CreditLineBundle\Entity\CreditLineSettings;
use Synolia\Bundle\CreditLineBundle\Form\Type\CreditLineSettingsType;

class CreditLineTransport implements TransportInterface
{
    /**
     * {@inheritdoc}
     */
    public function init(Transport $transportEntity)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return 'credit_line.settings.transport.label';
    }

    /**
     * {@inheritdoc}
     */
    public function getSettingsFormType()
    {
        return CreditLineSettingsType::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getSettingsEntityFQCN()
    {
        return CreditLineSettings::class;
    }
}
