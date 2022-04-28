<?php

namespace GameChange\ProductList\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Entity\Attribute\Source\Boolean;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;


class InstallData implements InstallDataInterface
{
    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
    * InstallData Constructor
    *
    * @param EavSetupFactory $eavSetupFactory
    */
    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
    * Install Attribute
    *
    * @param ModuleDataSetupInterface $setup
    * @param ModuleContextInterface $context
    */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        /**
        * Add attributes to the eav/attribute
        */
        if ($eavSetup->getAttributeId(Product::ENTITY, 'handle_display')) {
            $eavSetup->removeAttribute(Product::ENTITY, 'handle_display');
        }
        
        $eavSetup->addAttribute(
            Product::ENTITY,
            'handle_display',
            [
                'group' => 'General',
                'type' => 'int',//'text'
                'backend' => '',
                'frontend' => '',
                'label' => 'Handle Display',
                'input' => 'boolean',//'select'
                'class' => '',
                'source' => Boolean::class,//'Magento\Eav\Model\Entity\Attribute\Source\Boolean'
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                'visible' => true,
                'required' => false,
                'user_defined' => false,
                'default' => '0',
                'searchable' => false,
                'filterable' => false,
                'comparable' => false,
                'visible_on_front' => false,
                'used_in_product_listing' => false,
                'unique' => false,
                'apply_to' => 'simple,configurable,virtual,bundle,downloadable,grouped',
            ]
        );
    }
}
