<?php
/**
 * Copyright © Swarming Technology, LLC. All rights reserved.
 */
namespace Buzzi\PublishPageView\Block;

use Buzzi\PublishPageView\Model\DataBuilder;

class EventTrigger extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Buzzi\Publish\Model\Config\Events
     */
    private $configEvents;

    /**
     * @var \Magento\Framework\Registry
     */
    private $coreRegistry;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Buzzi\Publish\Model\Config\Events $configEvents
     * @param \Magento\Framework\Registry $coreRegistry
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Buzzi\Publish\Model\Config\Events $configEvents,
        \Magento\Framework\Registry $coreRegistry,
        array $data = []
    ) {
        $this->configEvents = $configEvents;
        $this->coreRegistry = $coreRegistry;
        parent::__construct($context, $data);
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->configEvents->isEventEnabled(DataBuilder::EVENT_TYPE);
    }

    /**
     * @return string
     */
    public function getEventType()
    {
        return DataBuilder::EVENT_TYPE;
    }

    /**
     * @return string
     */
    public function getPageId()
    {
        return $this->getRequest()->getFullActionName('-');
    }

    /**
     * @return string
     */
    public function getWebsiteCode()
    {
        return $this->_storeManager->getWebsite()->getCode();
    }

    /**
     * @return string
     */
    public function getCurrentCategoryName()
    {
        $currentCategory = $this->coreRegistry->registry('current_category');
        return $currentCategory instanceof \Magento\Catalog\Api\Data\CategoryInterface
            ? $currentCategory->getName()
            : '';
    }

    /**
     * @return string
     */
    protected function _toHtml()
    {
        return $this->isEnabled() ? parent::_toHtml() : '';
    }
}
