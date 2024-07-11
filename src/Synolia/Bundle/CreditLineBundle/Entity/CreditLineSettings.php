<?php

namespace Synolia\Bundle\CreditLineBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Oro\Bundle\IntegrationBundle\Entity\Transport;
use Oro\Bundle\LocaleBundle\Entity\LocalizedFallbackValue;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: \Synolia\Bundle\CreditLineBundle\Entity\Repository\CreditLineSettingsRepository::class)]
class CreditLineSettings extends Transport
{
    /**
     * @var Collection|LocalizedFallbackValue[]
     */
    #[Assert\NotBlank]
    #[ORM\ManyToMany(targetEntity: \Oro\Bundle\LocaleBundle\Entity\LocalizedFallbackValue::class, cascade: ['ALL'], orphanRemoval: true)]
    #[ORM\JoinTable(name: 'credit_line_trans_label', joinColumns: [new ORM\JoinColumn(name: 'transport_id', referencedColumnName: 'id', onDelete: 'CASCADE')], inverseJoinColumns: [new ORM\JoinColumn(name: 'localized_value_id', referencedColumnName: 'id', onDelete: 'CASCADE', unique: true)])]
    private $labels;

    /**
     * @var Collection|LocalizedFallbackValue[]
     */
    #[Assert\NotBlank]
    #[ORM\ManyToMany(targetEntity: \Oro\Bundle\LocaleBundle\Entity\LocalizedFallbackValue::class, cascade: ['ALL'], orphanRemoval: true)]
    #[ORM\JoinTable(name: 'credit_line_short_label', joinColumns: [new ORM\JoinColumn(name: 'transport_id', referencedColumnName: 'id', onDelete: 'CASCADE')], inverseJoinColumns: [new ORM\JoinColumn(name: 'localized_value_id', referencedColumnName: 'id', onDelete: 'CASCADE', unique: true)])]
    private $shortLabels;

    /**
     * @var ParameterBag
     */
    private $settings;

    public function __construct()
    {
        $this->labels = new ArrayCollection();
        $this->shortLabels = new ArrayCollection();
    }

    /**
     * @return Collection|LocalizedFallbackValue[]
     */
    public function getLabels()
    {
        return $this->labels;
    }

    /**
     * @param LocalizedFallbackValue $label
     *
     * @return $this
     */
    public function addLabel(LocalizedFallbackValue $label)
    {
        if (!$this->labels->contains($label)) {
            $this->labels->add($label);
        }

        return $this;
    }

    /**
     * @param LocalizedFallbackValue $label
     *
     * @return $this
     */
    public function removeLabel(LocalizedFallbackValue $label)
    {
        if ($this->labels->contains($label)) {
            $this->labels->removeElement($label);
        }

        return $this;
    }

    /**
     * @return Collection|LocalizedFallbackValue[]
     */
    public function getShortLabels()
    {
        return $this->shortLabels;
    }

    /**
     * @param LocalizedFallbackValue $label
     *
     * @return $this
     */
    public function addShortLabel(LocalizedFallbackValue $label)
    {
        if (!$this->shortLabels->contains($label)) {
            $this->shortLabels->add($label);
        }

        return $this;
    }

    /**
     * @param LocalizedFallbackValue $label
     *
     * @return $this
     */
    public function removeShortLabel(LocalizedFallbackValue $label)
    {
        if ($this->shortLabels->contains($label)) {
            $this->shortLabels->removeElement($label);
        }

        return $this;
    }

    /**
     * @return ParameterBag
     */
    public function getSettingsBag()
    {
        if (null === $this->settings) {
            $this->settings = new ParameterBag(
                [
                    'labels' => $this->getLabels(),
                    'short_labels' => $this->getShortLabels(),
                ]
            );
        }

        return $this->settings;
    }
}
