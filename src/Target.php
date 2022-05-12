<?php

namespace WKasunSampath\LaravelVuforia;

use Exception;
use JsonSerializable;

/**
 * Vuforia Webservice Target
 *
 * @property string $name Target name
 * @property float $width Target width
 * @property mixed $image Target image(optional)
 * @property boolean Target active state(optional)
 * @property mixed Target metadata(optional)
 */
class Target implements JsonSerializable
{
    /**
     * Target name
     *
     * @var string
     */
    public $name;

    /**
     * Target width
     *
     * @var float
     */
    public $width;

    /**
     * Target image file content
     *
     * @var mixed $image
     */
    public $image;

    /**
     * Target active state(optional)
     *
     * @var boolean
     */
    public $active;

    /**
     * Target metadata content(optional)
     *
     * @var mixed
     */
    public $metadata;

    /**
     * Constructor
     *
     * @param array $attributes Array to fill properties with
     */
    public function __construct($attributes = null)
    {
        if (!empty($attributes)) {

            if (array_key_exists('name', $attributes)) {
                $this->name = $attributes['name'];
            }

            if (array_key_exists('width', $attributes)) {
                $this->width = $attributes['width'];
            }

            if (array_key_exists('image', $attributes)) {
                $this->image = $attributes['image'];
            } else if (array_key_exists('path', $attributes)) {
                try
                {
                    $this->image = file_get_contents($attributes['path']);
                } catch (Exception $e) {
                    throw new Exception("Failed to read image from " . $attributes['path'] . ': ' . $e->getMessage());
                }
            }

            if (array_key_exists('active', $attributes)) {
                $this->active = $attributes['active'];
            }

            if (array_key_exists('metadata', $attributes)) {
                $this->metadata = $attributes['metadata'];
            }
        }
    }

    public function jsonSerialize()
    {

        $array = [];

        if (!empty($this->name)) {
            $array['name'] = $this->name;
        }

        if (is_numeric($this->width)) {
            $array['width'] = $this->width;
        }

        if (!empty($this->image)) {
            $array['image'] = base64_encode($this->image);
        }

        if (is_bool($this->active)) {
            $array['active_flag'] = $this->active ? 1 : 0;
        }

        if (!empty($this->metadata)) {
            $array['application_metadata'] = base64_encode($this->metadata);
        }

        return $array;
    }
}
