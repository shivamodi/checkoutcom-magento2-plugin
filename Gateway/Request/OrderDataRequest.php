<?php
/**
 * Checkout.com Magento 2 Payment module (https://www.checkout.com)
 *
 * Copyright (c) 2017 Checkout.com (https://www.checkout.com)
 * Author: David Fiaty | integration@checkout.com
 *
 * License GNU/GPL V3 https://www.gnu.org/licenses/gpl-3.0.en.html
 */
 
namespace CheckoutCom\Magento2\Gateway\Request;

class OrderDataRequest extends AbstractRequest {

    /**
     * Builds ENV request
     *
     * @param array $buildSubject
     * @return array
     * @throws \InvalidArgumentException
     */
    public function build(array $buildSubject) {


        $paymentDO      = $this->subjectReader->readPayment($buildSubject);
        $order          = $paymentDO->getOrder();

        $data = [
            'trackId'   => $order->getOrderIncrementId(),
            'products'  => [],
        ];

        /* @var $item \Magento\Sales\Api\Data\OrderItemInterface */
        foreach($order->getItems() as $item) {
            $data['products'][] = [
                'description'   => $item->getDescription(),
                'name'          => $item->getName(),
                'price'         => $item->getPrice(),
                'quantity'      => $item->getQtyOrdered(),
                'sku'           => $item->getSku(),
            ];
        }

        return $data;
    }

}
