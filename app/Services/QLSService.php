<?php

namespace App\Services;

use App\Clients\QLSClient;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class QLSService
{
    private QLSClient $qlsClient;

    private string $apiUser;
    private string $apiPassword;
    private string $apiCompanyId;
    private string $apiBrandId;

    public function __construct()
    {
        // Assume that a company has only one API connection, for now.
        $user = auth()->user()->load(['company', 'company.brands', 'company.apis']);

        // Set QLS credentials.
        $this->apiUser = $user->company->apis->first()->qls_user;
        $this->apiPassword = $user->company->apis->first()->qls_password;
        $this->apiCompanyId = $user->company->qls_company_id;
        $this->apiBrandId = $user->company->brands->first()->qls_brand_id;

        $this->qlsClient = new QLSClient(
            $this->apiUser,
            $this->apiPassword,
        );
    }

    /**
     * Get available shipping products.
     *
     * @return mixed
     */
    public function getShippingProducts(): mixed
    {
        $response = $this->qlsClient->get("company/$this->apiCompanyId/product")->json();
        return $response['data'];
    }

    /**
     * Get shipping label.
     *
     * @param $order
     * @return StreamedResponse
     */
    public function getShippingLabel($order)
    {
        $params = [
            'brand_id' => $this->apiBrandId,
            'reference' => $order->order_number,
            'weight' => $order->weight,
            'product_id' => $order->qls_shipping_product_id,
            'product_combination_id' => $order->qls_shipping_product_combination_id,
            'cod_amount' => 0,
            'piece_total' => 1,
            'receiver_contact' => [
                'companyname' => $order->receiver_company,
                'name' => $order->receiver_name,
                'street' => $order->receiver_street,
                'housenumber' => $order->receiver_housenumber,
                'postalcode' => $order->receiver_zip,
                'locality' => $order->receiver_city,
                'country' => $order->receiver_country,
                'email' => $order->receiver_email,
            ]
        ];

        // If label exists, download without creating a new one.
        if (Storage::exists('labels/' . $order->id . '.pdf')) {
            return Storage::download('labels/' . $order->id . '.pdf');
        }

        $response = $this->qlsClient->post('company/' . $this->apiCompanyId . '/shipment/create', $params)->json();

        // Download PDF to Laravel storage.
        if (array_key_exists('a6', $response['data']['labels'])) {
            $label = Http::get($response['data']['labels']['a6'])->body();
        } else {
            // Not all shipping products have return a pdf label
            // in the response.
            return redirect()->route('orders.index');
        }

        Storage::put('labels/' . $order->id . '.pdf', $label);
        LabelService::convertPdfToPng($order);

        return Storage::download('labels/' . $order->id . '.pdf');
    }
}
