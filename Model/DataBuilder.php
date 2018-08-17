<?php
/**
 * Copyright © Swarming Technology, LLC. All rights reserved.
 */
namespace Buzzi\PublishPageView\Model;

use Magento\Framework\DataObject;

class DataBuilder
{
    const EVENT_TYPE = 'buzzi.ecommerce.page-view';

    /**
     * @var \Buzzi\Publish\Helper\DataBuilder\Base
     */
    private $dataBuilderBase;

    /**
     * @var \Buzzi\Publish\Helper\DataBuilder\Customer
     */
    private $dataBuilderCustomer;

    /**
     * @var \Magento\Framework\Event\ManagerInterface
     */
    private $eventDispatcher;

    /**
     * @param \Buzzi\Publish\Helper\DataBuilder\Base $dataBuilderBase
     * @param \Buzzi\Publish\Helper\DataBuilder\Customer $dataBuilderCustomer
     * @param \Magento\Framework\Event\ManagerInterface $eventDispatcher
     */
    public function __construct(
        \Buzzi\Publish\Helper\DataBuilder\Base $dataBuilderBase,
        \Buzzi\Publish\Helper\DataBuilder\Customer $dataBuilderCustomer,
        \Magento\Framework\Event\ManagerInterface $eventDispatcher
    ) {
        $this->dataBuilderBase = $dataBuilderBase;
        $this->dataBuilderCustomer = $dataBuilderCustomer;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param string $pageId
     * @param string $siteId
     * @param string|null $category
     * @param \Magento\Customer\Model\Customer|null $customer
     * @param string|null $customerEmail
     * @return mixed[]
     */
    public function getPayload($pageId, $siteId, $category = null, $customer = null, $customerEmail = null)
    {
        $payload = $this->dataBuilderBase->initBaseData(self::EVENT_TYPE);

        $payload['customer'] = $customer ? $this->dataBuilderCustomer->getCustomerData($customer) : ['email' => $customerEmail];
        $payload['page_id'] = $pageId;
        $payload['site_id'] = $siteId;

        if ($category) {
            $payload['category'] = $category;
        }

        $transport = new DataObject(['payload' => $payload]);
        $this->eventDispatcher->dispatch('buzzi_publish_page_view', ['transport' => $transport]);

        return (array)$transport->getData('payload');
    }
}
