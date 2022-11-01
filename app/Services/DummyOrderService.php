<?php

namespace App\Services;

class DummyOrderService
{
    /**
     * Returns a dummy order for showcasing project funcionality.
     *
     * @return array
     */
    public static function dummyOrder(): array
    {
        return [
            'number' => '#958201',
            'billing_address' => [
                'companyname' => 'My Great Company B.V.',
                'name' => '',
                'street' => 'Bamendaweg',
                'housenumber' => '18',
                'address_line_2' => '',
                'zipcode' => '3319GS',
                'city' => 'Dordrecht',
                'country' => 'NL',
                'email' => 'emailaddress@example.org',
                'phone' => '0101234567',
            ],
            'delivery_address' => [
                'companyname' => '',
                'name' => 'John Doe',
                'street' => 'Bamendawg',
                'housenumber' => '18',
                'address_line_2' => '',
                'zipcode' => '3319GS',
                'city' => 'Dordrecht',
                'country' => 'NL',
            ],
            'order_lines' => [
                [
                    'amount_ordered' => 2,
                    'name' => 'Jeans - Black - 36',
                    'sku' => 69205,
                    'barcode' => 'JB36',
                ],
                [
                    'amount_ordered' => 1,
                    'name' => 'Sjaal - Rood Oranje',
                    'sku' => 25920,
                    'barcode' => 'SJA2940291',
                ]
            ]
        ];
    }
}