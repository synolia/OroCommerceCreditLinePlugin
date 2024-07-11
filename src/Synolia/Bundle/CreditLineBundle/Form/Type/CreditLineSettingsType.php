<?php

namespace Synolia\Bundle\CreditLineBundle\Form\Type;

use Oro\Bundle\LocaleBundle\Form\Type\LocalizedFallbackValueCollectionType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Synolia\Bundle\CreditLineBundle\Entity\CreditLineSettings;

class CreditLineSettingsType extends AbstractType
{
    public const BLOCK_PREFIX = 'credit_line_settings';

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'labels',
                LocalizedFallbackValueCollectionType::class,
                [
                    'label' => 'credit_line.settings.labels.label',
                    'required' => true
                ]
            )
            ->add(
                'shortLabels',
                LocalizedFallbackValueCollectionType::class,
                [
                    'label' => 'credit_line.settings.short_labels.label',
                    'required' => false
                ]
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => CreditLineSettings::class
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return self::BLOCK_PREFIX;
    }
}
