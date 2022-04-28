<?php
/**
 * Copyright © GameChange, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace GameChange\ProductList\Helper\Product;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Registry;
use Magento\Store\Model\ScopeInterface;
use Magento\Catalog\Helper\Product\ProductList as CoreProductList;
use Magento\Framework\App\Request\Http;

/**
 * Returns data for toolbars of Sorting and Pagination
 *
 * @api
 * @since 100.0.2
 */
class ProductList extends CoreProductList
{
    /**
     * ProductList Constructor
     *
     * @param ScopeConfigInterface $scopeConfig
     * @param Http $request
     * @param Registry|null $coreRegistry
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        Http $request,
        Registry $coreRegistry = null
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->request = $request;
        $this->coreRegistry = $coreRegistry ?? ObjectManager::getInstance()->get(Registry::class);
        parent::__construct($scopeConfig, $coreRegistry);
    }
    
    /**
     * Returns available mode for view
     *
     * @return array|null
     */
    public function getAvailableViewMode()
    {
        $value = $this->scopeConfig->getValue(self::XML_PATH_LIST_MODE, ScopeInterface::SCOPE_STORE);
        //get module details
        $moduleName = $this->request->getModuleName();
        $routeName = $this->request->getRouteName();
        $controllerName = $this->request->getControllerName();
        $actionName = $this->request->getActionName();

        if ($moduleName == 'productlist' && $routeName == 'productlist' && $controllerName == 'account' && $actionName == 'newitem') {
            $value = 'grid-list-slider';
        }

        switch ($value) {
            case 'grid':
                return ['grid' => __('Grid')];

            case 'list':
                return ['list' => __('List')];

            case 'grid-list':
                return ['grid' => __('Grid'), 'list' => __('List')];

            case 'list-grid':
                return ['list' => __('List'), 'grid' => __('Grid')];
            
            case 'grid-list-slider':
                return ['grid' => __('Grid'), 'list' => __('List'), 'slider' => __('Slider')];
        }

        return null;
    }

}
