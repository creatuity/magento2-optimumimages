<?php

namespace Creatuity\OptimumImages\Api\Data;

interface SliderInterface
{
    const DB_MAIN_TABLE = "creatuity_optimumimages_slider";
    const ENTITY_ID = "entity_id";
    const KEY = "key";
    const ALT = "alt";
    const SLIDE_DELAY = "slide_delay";
    const IMAGES = 'images_ids';
    const CREATED_AT = "created_at";
    const UPDATED_AT = "updated_at";

    /**
     * @return int
     */
    public function getEntityId();

    /**
     * @param int $entity_id
     * @return SliderInterface
     */
    public function setEntityId($entity_id);

    /**
     * @return string
     */
    public function getKey();

    /**
     * @param string $key
     * @return SliderInterface
     */
    public function setKey($key): SliderInterface;

    /**
     * @return string
     */
    public function getAlt();

    /**
     * @param string $alt
     * @return SliderInterface
     */
    public function setAlt($alt): SliderInterface;

    /**
     * @return int
     */
    public function getSlideDelay();

    /**
     * @param int $slide_delay
     * @return SliderInterface
     */
    public function setSlideDelay($slide_delay): SliderInterface;

    /**
     * @param ImageInterface $image
     * @return SliderInterface
     */
    public function addImage(ImageInterface $image): SliderInterface;

    /**
     * @return array
     */
    public function getImages();

    /**
     * @param array $imagesIds Array like:
     * [
     *   <position> => <image id>,
     *   ...
     * ]
     * @return SliderInterface
     */
    public function setImages($imagesIds): SliderInterface;

    /**
     * @return string
     */
    public function getCreatedAt();

    /**
     * @param string $created_at
     * @return SliderInterface
     */
    public function setCreatedAt($created_at): SliderInterface;

    /**
     * @return string
     */
    public function getUpdatedAt();

    /**
     * @param string $updated_at
     * @return SliderInterface
     */
    public function setUpdatedAt($updated_at): SliderInterface;
}