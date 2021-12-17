<?php

namespace Synolia\Bundle\CreditLineBundle\Integration;

use Oro\Bundle\IntegrationBundle\Provider\ChannelInterface;
use Oro\Bundle\IntegrationBundle\Provider\IconAwareIntegrationInterface;

class CreditLineChannelType implements ChannelInterface, IconAwareIntegrationInterface
{
    const TYPE = 'synolia_credit_line';

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return 'credit_line.channel_type.label';
    }

    /**
     * {@inheritDoc}
     */
    public function getIcon()
    {
        return 'bundles/oropaymentterm/img/payment-term-logo.png';
    }
}
