<?php
/**
 * Copyright © GameChange, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace GameChange\ProductList\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

/**
 * ListMode class
 */
class ListMode implements ArrayInterface
{
    /**
     * {@inheritdoc}
     *
     * @codeCoverageIgnore
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'grid', 'label' => __('Grid Only')],
            ['value' => 'list', 'label' => __('List Only')],
            ['value' => 'grid-list', 'label' => __('Grid (default) / List')],
            ['value' => 'list-grid', 'label' => __('List (default) / Grid')],
            ['value' => 'grid-list-slider', 'label' => __('Grid (default) / List / Slider')]
        ];
    }
}
