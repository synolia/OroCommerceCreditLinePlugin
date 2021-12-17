<?php

namespace Synolia\Bundle\CreditLineBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Synolia\Bundle\CreditLineBundle\Entity\CreditLineSettings;

class CreditLineSettingsRepository extends EntityRepository
{
    /**
     * @return CreditLineSettings[]
     */
    public function getEnabledSettings()
    {
        return $this->createQueryBuilder('settings')
            ->innerJoin('settings.channel', 'channel')
            ->andWhere('channel.enabled = true')
            ->getQuery()
            ->getResult();
    }
}
