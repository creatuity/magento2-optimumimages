<?php
namespace Creatuity\OptimumImages\Setup;

use Creatuity\OptimumImages\Api\Data\ImageInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Zend_Db_Exception;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws Zend_Db_Exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $table = $setup->getConnection()
            ->newTable($setup->getTable(ImageInterface::DB_MAIN_TABLE))
            ->addColumn(
                ImageInterface::ENTITY_ID,
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Image ID'
            )
            ->addColumn(
                ImageInterface::KEY,
                Table::TYPE_TEXT,
                127,
                ['nullable' => false],
                'Image Key'
            )
            ->addColumn(
                ImageInterface::ALT,
                Table::TYPE_TEXT,
                127,
                ['nullable' => false],
                'Image Alt Value'
            )
            ->addColumn(
                ImageInterface::DIMENSION_TYPE,
                Table::TYPE_TEXT,
                63,
                ['nullable' => false],
                'Dimension Type'
            )
            ->addColumn(
                ImageInterface::MOBILE_DIMENSION,
                Table::TYPE_INTEGER,
                null,
                ['nullable' => false],
                'Mobile Dimension'
            )
            ->addColumn(
                ImageInterface::TABLET_DIMENSION,
                Table::TYPE_INTEGER,
                null,
                ['nullable' => false],
                'Tablet Dimension'
            )
            ->addColumn(
                ImageInterface::DESKTOP_DIMENSION,
                Table::TYPE_INTEGER,
                null,
                ['nullable' => false],
                'Desktop Dimension'
            )
            ->addColumn(
                ImageInterface::ORIGIN_LOCATION,
                Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Origin Location'
            )
            ->addColumn(
                ImageInterface::MOBILE_LOCATION,
                Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Mobile Location'
            )
            ->addColumn(
                ImageInterface::TABLET_LOCATION,
                Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Tablet Location'
            )
            ->addColumn(
                ImageInterface::DESKTOP_LOCATION,
                Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Desktop Location'
            )
            ->addColumn(
                ImageInterface::CONVERSION_STATUS,
                Table::TYPE_TEXT,
                63,
                ['nullable' => false],
                'Image Conversion Status'
            )
            ->addColumn(
                ImageInterface::CREATED_AT,
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                'Created At Timestamp'
            )
            ->addColumn(
                ImageInterface::UPDATED_AT,
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
                'Updated At Timestamp'
            )->addIndex(
                $setup->getIdxName(
                    ImageInterface::DB_MAIN_TABLE,
                    [ImageInterface::KEY],
                    AdapterInterface::INDEX_TYPE_UNIQUE
                ),
                [ImageInterface::KEY],
                ['type' => AdapterInterface::INDEX_TYPE_UNIQUE]
            )
            ->setComment("Images table");
        $setup->getConnection()->createTable($table);
    }
}