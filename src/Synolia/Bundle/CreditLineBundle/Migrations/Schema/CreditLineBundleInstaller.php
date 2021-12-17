<?php

namespace Synolia\Bundle\CreditLineBundle\Migrations\Schema;

use Doctrine\DBAL\Schema\Schema;
use Oro\Bundle\EntityExtendBundle\EntityConfig\ExtendScope;
use Oro\Bundle\MigrationBundle\Migration\Installation;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

class CreditLineBundleInstaller implements Installation
{
    /**
     * {@inheritdoc}
     */
    public function getMigrationVersion()
    {
        return 'v1_0';
    }

    /**
     * {@inheritdoc}
     */
    public function up(Schema $schema, QueryBag $queries)
    {
        /** Tables generation **/
        $this->createCreditLineShortLabelTable($schema);
        $this->createCreditLineTransLabelTable($schema);

        /** Foreign keys generation **/
        $this->addCreditLineShortLabelForeignKeys($schema);
        $this->addCreditLineTransLabelForeignKeys($schema);

        /** Add sy_credit_line field on Customer */
        $this->addSyCreditLineFieldOnCustomer($schema);
    }

    /**
     * Create credit_line_short_label table
     *
     * @param Schema $schema
     */
    protected function createCreditLineShortLabelTable(Schema $schema)
    {
        $table = $schema->createTable('credit_line_short_label');
        $table->addColumn('transport_id', 'integer', []);
        $table->addColumn('localized_value_id', 'integer', []);
        $table->setPrimaryKey(['transport_id', 'localized_value_id']);
        $table->addIndex(['transport_id'], 'oro_payment_credit_line_short_label_transport_id', []);
        $table->addUniqueIndex(['localized_value_id'], 'oro_payment_credit_line_short_label_localized_value_id', []);
    }

    /**
     * Create credit_line_trans_label table
     *
     * @param Schema $schema
     */
    protected function createCreditLineTransLabelTable(Schema $schema)
    {
        $table = $schema->createTable('credit_line_trans_label');
        $table->addColumn('transport_id', 'integer', []);
        $table->addColumn('localized_value_id', 'integer', []);
        $table->setPrimaryKey(['transport_id', 'localized_value_id']);
        $table->addIndex(['transport_id'], 'oro_payment_credit_line_trans_label_transport_id', []);
        $table->addUniqueIndex(['localized_value_id'], 'oro_payment_credit_line_trans_label_localized_value_id', []);
    }

    /**
     * Add credit_line_short_label foreign keys.
     *
     * @param Schema $schema
     */
    protected function addCreditLineShortLabelForeignKeys(Schema $schema)
    {
        $table = $schema->getTable('credit_line_short_label');
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_integration_transport'),
            ['transport_id'],
            ['id'],
            ['onDelete' => 'CASCADE', 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_fallback_localization_val'),
            ['localized_value_id'],
            ['id'],
            ['onDelete' => 'CASCADE', 'onUpdate' => null]
        );
    }

    /**
     * Add credit_line_trans_label foreign keys.
     *
     * @param Schema $schema
     */
    protected function addCreditLineTransLabelForeignKeys(Schema $schema)
    {
        $table = $schema->getTable('credit_line_trans_label');
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_integration_transport'),
            ['transport_id'],
            ['id'],
            ['onDelete' => 'CASCADE', 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_fallback_localization_val'),
            ['localized_value_id'],
            ['id'],
            ['onDelete' => 'CASCADE', 'onUpdate' => null]
        );
    }

    private function addSyCreditLineFieldOnCustomer(Schema $schema)
    {
        $table = $schema->getTable('oro_customer');

        $table->addColumn(
            'sy_credit_line',
            'money',
            [
                'notnull' => false,
                'precision' => 19,
                'scale' => 4,
                'comment' => '(DC2Type:money)',
                'oro_options' => [
                    'extend'    => ['is_extend' => true, 'owner' => ExtendScope::OWNER_CUSTOM],
                ]
            ]
        );
    }
}
