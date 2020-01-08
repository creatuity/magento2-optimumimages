<?php

namespace Creatuity\OptimumImages\Model\ResourceModel;

use Creatuity\OptimumImages\Api\Data\SliderImageInterface;
use Creatuity\OptimumImages\Api\Data\SliderInterface;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Slider extends AbstractDb
{
    protected function _construct()
    {
        $this->_init(SliderInterface::DB_MAIN_TABLE, SliderInterface::ENTITY_ID);
    }

    protected function _afterSave(AbstractModel $object)
    {
        $result = parent::_afterSave($object);

        $this->saveImageAssignment($object);

        return $result;
    }

    protected function _afterLoad(\Magento\Framework\Model\AbstractModel $object)
    {
        $result = parent::_afterLoad($object);

        $this->loadImageAssignment($object);

        return $result;
    }

    protected function loadImageAssignment(AbstractModel $object)
    {
        /** @var SliderInterface $object */
        $query = $this->getConnection()->select()
            ->from(
                $this->getConnection()->getTableName(SliderImageInterface::DB_MAIN_TABLE),
                [SliderImageInterface::IMAGE_ID, SliderImageInterface::POSITION]
            )
            ->where(SliderImageInterface::SLIDER_ID . ' = ?', $object->getEntityId())
            ->order('position');
        $images = (array)$this->getConnection()->fetchAll($query);
        $images = array_combine(array_column($images, SliderImageInterface::IMAGE_ID), $images);

        $object->setImages($images);
    }

    protected function saveImageAssignment(AbstractModel $object)
    {
        /** @var SliderInterface $object */
        $this->deleteAssignedImages($object);

        if (!$object->getImages()) {
            return;
        }

        $insert = [];
        $position = 1;
        foreach ($object->getImages() as $imageId) {
            $insert[] = [
                SliderImageInterface::SLIDER_ID => $object->getEntityId(),
                SliderImageInterface::IMAGE_ID => $imageId,
                SliderImageInterface::POSITION => $position++
            ];
        }
        $this->getConnection()->insertMultiple(
            $this->getConnection()->getTableName(SliderImageInterface::DB_MAIN_TABLE),
            $insert
        );
    }

    protected function deleteAssignedImages(AbstractModel $object)
    {
        $this->getConnection()->delete(
            $this->getConnection()->getTableName(SliderImageInterface::DB_MAIN_TABLE),
            [SliderImageInterface::SLIDER_ID . ' = ?' => $object->getEntityId()]
        );
    }
}
