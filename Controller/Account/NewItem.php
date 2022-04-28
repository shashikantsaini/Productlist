<?php

namespace GameChange\ProductList\Controller\Account;

use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\Context;
use Magento\Customer\Controller\AbstractAccount;
use Magento\Customer\Model\Session;

class NewItem extends AbstractAccount
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var Session
     */
    protected $customerSession;

    /**
     * NewItem Constructor
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param Session $customerSession
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        Session $customerSession
    ) {
        $this->resultPageFactory    = $resultPageFactory;
        $this->customerSession = $customerSession;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $customerLoggedIn = $this->customerSession->isLoggedIn();
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__('New Items'));
        
        if($customerLoggedIn){
            return $resultPage;
        }else{
            $resultPage->setUrl('customer/account/login');
            return $resultPage;
        }
        
        /** @var \Magento\Framework\View\Result\Page $resultPage */
        
    }
}