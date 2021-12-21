<?php

namespace Suma\VolumeDiscount;

use Laravel\Nova\Fields\Field;

class VolumeDiscount extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'volume-discount';

    /**
     * @param $tiers array|null
     *
     * @return VolumeDiscount
     */
    public function tiers( $tiers = null ){

        $tiers = !empty( $tiers ) ? $tiers : ['Discount'];

        return $this->withMeta(['tiers' => $tiers]);
    }

    /**
     * @param $heading string|null
     *
     * @return VolumeDiscount
     */
    public function qtyColumnHeading( $heading = null ){
        return $this->withMeta(['headingQty' => $heading ?: 'Qty']);
    }

    /**
     * @param $heading string|null
     *
     * @return VolumeDiscount
     */
    public function discountColumnHeading( $heading = null ){
        return $this->withMeta(['headingDiscount' => $heading ?: 'Discount']);
    }

    /**
     * @param $suffix string|null
     *
     * @return VolumeDiscount
     */
    public function discountSuffix( $suffix = '%' ){
        return $this->withMeta(['discountSuffix' => $suffix]);
    }

    /**
     * @param $heading string|null
     *
     * @return VolumeDiscount
     */
    public function maxTiers( $count = -1 ){
        return $this->withMeta(['maxTiers' => $count]);
    }
}
