<?php
/**
 * Copyright © Swarming Technology, LLC. All rights reserved.
 */

namespace Buzzi\PublishPageView\Model;

use Buzzi\Publish\Api\PackerInterface;

class Packer implements PackerInterface
{
    /**
     * @var \Buzzi\PublishPageView\Model\DataBuilder
     */
    private $dataBuilder;

    /**
     * @param \Buzzi\PublishPageView\Model\DataBuilder $dataBuilder
     */
    public function __construct(
        \Buzzi\PublishPageView\Model\DataBuilder $dataBuilder
    ) {
        $this->dataBuilder = $dataBuilder;
    }

    /**
     * @param array $inputData
     * @param \Magento\Customer\Model\Customer|null $customer
     * @param string|null $customerEmail
     * @return array|null
     */
    public function pack(array $inputData, $customer = null, $customerEmail = null)
    {
        if (empty($inputData['page_id']) || empty($inputData['site_id'])) {
            throw new \InvalidArgumentException('Page Id and Site Id are required fields.');
        }

        $category = !empty($inputData['category']) ? $inputData['category'] : null;

        return $customer || $customerEmail
            ? $this->dataBuilder->getPayload($inputData['page_id'], $inputData['site_id'], $category, $customer, $customerEmail)
            : null;
    }
}
