<?php

namespace GameChange\ProductList\Block\Account;

use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Block\Product\ListProduct;
use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Model\Layer\Resolver;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\Data\Helper\PostHelper;
use Magento\Framework\Url\Helper\Data;
use Magento\Catalog\Helper\Output as OutputHelper;
use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * NewItem class
 */
class NewItem extends ListProduct
{
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var CollectionFactory
     */
    protected $productCollectionFactory;

    /**
     * NewItem Constructor
     *
     * @param Context $context
     * @param PostHelper $postDataHelper
     * @param Resolver $layerResolver
     * @param CategoryRepositoryInterface $categoryRepository
     * @param Data $urlHelper
     * @param array $data
     * @param OutputHelper|null $outputHelper
     * @param ScopeConfigInterface $scopeConfig
     * @param CollectionFactory $productCollectionFactory
     */
    public function __construct(
        Context $context,
        PostHelper $postDataHelper,
        Resolver $layerResolver,
        CategoryRepositoryInterface $categoryRepository,
        Data $urlHelper,
        array $data = [],
        ?OutputHelper $outputHelper = null,
        ScopeConfigInterface $scopeConfig,
        CollectionFactory $productCollectionFactory
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->productCollectionFactory = $productCollectionFactory;
        parent::__construct($context, $postDataHelper, $layerResolver, $categoryRepository, $urlHelper, $data);
    }

    /**
     * Get Product Listing Limit method.
     *
     * @return int
     */
    public function getProductListingLimit()
    {
        return $this->scopeConfig->getValue(
            "productlist/general/product_listing_limit",
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
                );
    }

    /**
     * get Is Module Enalbed method
     *
     * @return boolean
     */
    public function isModuleEnable()
    {
        return $this->scopeConfig->getValue(
            "productlist/general/enable",
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
                );
    }
    
    /**
     * Prepare Layout
     *
     * @return void
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if ($this->getProductCollection()) {

            $toolbar = $this->getLayout()->createBlock(
                'Magento\Catalog\Block\Product\ProductList\Toolbar',
                'productlist_list_toolbar'
                )
                ->setTemplate('Magento_Catalog::product/list/toolbar.phtml')
                ->setCollection($this->getProductCollection());

            $pager = $this->getLayout()->createBlock(
                'Magento\Theme\Block\Html\Pager',
                'productlist.product.pager'
            )->setAvailableLimit(array(3=>3,6=>6,9=>9))->setShowPerPage(true)->setCollection(
                $this->getProductCollection()
            );
            

            $this->setChild('pager', $pager);
            $this->setChild('toolbar', $toolbar);
            $this->getProductCollection()->load();
        }
        return $this;
    }

    /**
     * Get Pager to html method.
     *
     * @return string
     */
    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }

    /**
     * Get Pager to html method.
     */
    public function getToolbarHtml()
    {
        return $this->getChildHtml('toolbar');
    }

    /**
     * Get Mode method.
     */
    public function getMode()
    {
        return $this->getChildBlock('toolbar')->getCurrentMode();
    }
    
    /**
     * Get Product Collection method.
     * 
     * @return object
     */
    public function getProductCollection()
    {
        $page=($this->getRequest()->getParam('p'))? $this->getRequest()->getParam('p') : 1;
        //get values of current limit
        $pageSize=($this->getRequest()->getParam('limit'))? $this->getRequest()->getParam('limit') : 3;

        $collection = $this->productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->addAttributeToFilter('handle_display', ['eq' => 1]);
        $pageSize=($this->getProductListingLimit())? $this->getProductListingLimit() : $collection->count();
        if($this->getRequest()->getParam('product_list_mode') != 'slider')
        {
            $collection->setPageSize($pageSize);
            $collection->setCurPage($page);
        }
        
        return $collection;
    }
}
