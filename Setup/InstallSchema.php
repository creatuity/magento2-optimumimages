<?php
declare(strict_types=1);

namespace Creatuity\OptimumImages\Setup;

use Creatuity\OptimumImages\Api\Data\ImageInterface;
use Creatuity\OptimumImages\Api\Data\SliderImageInterface;
use Creatuity\OptimumImages\Api\Data\SliderInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Zend_Db_Exception;

/**
 * Class InstallSchema
 * @package Creatuity\OptimumImages\Setup
 * @deprecated Schema is done by etc/db_schema.xml since Magento 2.3
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws Zend_Db_Exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $this->addImagesTable($setup);
        $this->addSlidersTable($setup);
        $this->addSliderImageTable($setup);
    }

    private function addImagesTable(SchemaSetupInterface $setup)
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
                ImageInterface::LINK_URL,
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

    private function addSlidersTable(SchemaSetupInterface $setup)
    {
        $table = $setup->getConnection()
            ->newTable($setup->getTable(SliderInterface::DB_MAIN_TABLE))
            ->addColumn(
                SliderInterface::ENTITY_ID,
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Slider ID'
            )
            ->addColumn(
                SliderInterface::KEY,
                Table::TYPE_TEXT,
                127,
                ['nullable' => false],
                'Slider Key'
            )
            ->addColumn(
                SliderInterface::ALT,
                Table::TYPE_TEXT,
                127,
                ['nullable' => false],
                'Slider Alt Value'
            )
            ->addColumn(
                SliderInterface::SLIDE_DELAY,
                Table::TYPE_INTEGER,
                null,
                ['nullable' => false],
                'Slide delay'
            )
            ->addColumn(
                SliderInterface::CREATED_AT,
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                'Created At Timestamp'
            )
            ->addColumn(
                SliderInterface::UPDATED_AT,
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
                'Updated At Timestamp'
            )
            ->addIndex(
                $setup->getIdxName(
                    SliderInterface::DB_MAIN_TABLE,
                    [SliderInterface::KEY],
                    AdapterInterface::INDEX_TYPE_UNIQUE
                ),
                [SliderInterface::KEY],
                ['type' => AdapterInterface::INDEX_TYPE_UNIQUE]
            )
            ->setComment("Sliders table");
        $setup->getConnection()->createTable($table);
    }

    private function addSliderImageTable(SchemaSetupInterface $setup)
    {
        $table = $setup->getConnection()
            ->newTable($setup->getTable(SliderImageInterface::DB_MAIN_TABLE))
            ->addColumn(
                SliderImageInterface::SLIDER_ID,
                Table::TYPE_INTEGER,
                null,
                ['identity' => false, 'unsigned' => true, 'nullable' => false],
                'Slider ID'
            )
            ->addColumn(
                SliderImageInterface::IMAGE_ID,
                Table::TYPE_INTEGER,
                null,
                ['identity' => false, 'unsigned' => true, 'nullable' => false],
                'Image ID'
            )
            ->addColumn(
                SliderImageInterface::POSITION,
                Table::TYPE_INTEGER,
                null,
                ['nullable' => false],
                'Slide delay'
            )
            ->addIndex(
                $setup->getIdxName(
                    SliderImageInterface::DB_MAIN_TABLE,
                    [
                        SliderImageInterface::SLIDER_ID,
                        SliderImageInterface::IMAGE_ID
                    ],
                    AdapterInterface::INDEX_TYPE_PRIMARY
                ),
                [
                    SliderImageInterface::SLIDER_ID,
                    SliderImageInterface::IMAGE_ID
                ],
                ['type' => AdapterInterface::INDEX_TYPE_PRIMARY]
            )
            ->addIndex(
                $setup->getIdxName(
                    SliderImageInterface::DB_MAIN_TABLE,
                    [SliderImageInterface::POSITION],
                    AdapterInterface::INDEX_TYPE_INDEX
                ),
                [SliderImageInterface::POSITION],
                ['type' => AdapterInterface::INDEX_TYPE_INDEX]
            )
            ->addForeignKey(
                $setup->getFkName(
                    SliderImageInterface::DB_MAIN_TABLE,
                    SliderImageInterface::SLIDER_ID,
                    SliderInterface::DB_MAIN_TABLE,
                    SliderInterface::ENTITY_ID
                ),
                SliderImageInterface::SLIDER_ID,
                SliderInterface::DB_MAIN_TABLE,
                SliderInterface::ENTITY_ID,
                AdapterInterface::FK_ACTION_CASCADE
            )
            ->addForeignKey(
                $setup->getFkName(
                    SliderImageInterface::DB_MAIN_TABLE,
                    SliderImageInterface::IMAGE_ID,
                    ImageInterface::DB_MAIN_TABLE,
                    ImageInterface::ENTITY_ID
                ),
                SliderImageInterface::IMAGE_ID,
                ImageInterface::DB_MAIN_TABLE,
                ImageInterface::ENTITY_ID,
                AdapterInterface::FK_ACTION_CASCADE
            )
            ->setComment("Slider - Image connection table");
        $setup->getConnection()->createTable($table);
    }
}
