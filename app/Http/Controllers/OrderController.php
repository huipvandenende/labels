<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderLine;
use App\Services\DummyOrderService;
use App\Services\LabelService;
use App\Services\QLSService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class OrderController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $brandID = auth()->user()->company()->first()->brands()->find(1)->id;
        $orders = Order::where('brand_id', $brandID)->get()->sortBy('id');

        return view('orders.index', compact('orders'));
    }

    /**
     * @return RedirectResponse
     */
    public function create()
    {
        /*
         * Example of an order we might receive from a webshop API.
         */
        $dummyOrder = DummyOrderService::dummyOrder();

        $newOrder = Order::create([
            'brand_id' => auth()->user()->company()->find(1)->brands()->first()->id,
            'order_number' => $dummyOrder['number'],
            'weight' => 1000,
            'qls_shipping_product_id' => null,
            'qls_shipping_product_combination_id' => null,
            'cod_amount' => null,
            'piece_total' => 1,
            'receiver_company' => $dummyOrder['delivery_address']['companyname'],
            'receiver_name' => $dummyOrder['delivery_address']['name'],
            'receiver_street' => $dummyOrder['delivery_address']['street'],
            'receiver_housenumber' => $dummyOrder['delivery_address']['housenumber'],
            'receiver_zip' => $dummyOrder['delivery_address']['zipcode'],
            'receiver_city' => $dummyOrder['delivery_address']['city'],
            'receiver_country' => $dummyOrder['delivery_address']['country'],
            'receiver_email' => $dummyOrder['billing_address']['email'],
        ]);

        foreach ($dummyOrder['order_lines'] as $orderLine) {
            OrderLine::create([
                'order_id' => $newOrder->id,
                'quantity' => $orderLine['amount_ordered'],
                'name' => $orderLine['name'],
                'sku' => $orderLine['sku'],
                'barcode' => $orderLine['barcode'],
            ]);
        }

        return redirect()->route('orders.index');
    }

    /**
     * Displays the add product view.
     *
     * @param  Order  $order
     * @return Application|Factory|View
     */
    public function addProduct(Order $order)
    {
        $order->load('orderLines');
        $qlsService = new QLSService();
        $products = $qlsService->getShippingProducts($order->receiver_country);

        return view('orders.product', compact('order', 'products'));
    }

    /**
     * Gets hit when the user selects a product.
     *
     * @param  Request  $request
     * @param  Order  $order
     * @return RedirectResponse
     */
    public function edit(Request $request, Order $order)
    {
        $request->validate([
            'product_id' => 'required',
            'product_combi_id' => 'required'
        ]);


        $order->update($request->all());

        $orderId = json_decode($request->product)->id;
        $order = Order::find($orderId);

        $order->update([
            'qls_shipping_product_id' => $request->product_id,
            'qls_shipping_product_combination_id' => $request->product_combi_id
        ]);

        return redirect()->route('orders.index');
    }

    /**
     * Downloads the label for the order.
     *
     * @param  Order  $order
     * @return StreamedResponse
     */
    public function label(Order $order)
    {
        return (new QLSService())->getShippingLabel($order);
    }

    public function pdf(Order $order)
    {
        // Make sure the label is fetched before attempting to
        // create the slip.
        (new QLSService())->getShippingLabel($order);
        return LabelService::downloadPackingSlip($order);
    }
}
