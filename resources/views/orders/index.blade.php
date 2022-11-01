<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-xl font-semibold text-gray-900">Orders</h1>
                <p class="mt-2 text-sm text-gray-700">A list of all the orders currently stored in the database.</p>
            </div>
            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                <form action="{{ route('orders.create') }}">
                    <button type="submit"
                            class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">
                        Create new order
                    </button>
                </form>
            </div>
        </div>
        <div class="mt-8 flex flex-col">
            <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">ID
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Address
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Product
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Product status
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Downloads
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white">
                            <!-- Odd row -->
                            @foreach($orders as $order)
                                <tr>
                                    <td class="whitespace-nowrap text-sm sm:pl-6">
                                        <div class="flex items-center">
                                            <div>
                                                <div class="font-medium text-gray-900">
                                                    Webshop: {{$order->order_number}}</div>
                                                <div class="text-gray-500">ID: {{$order->id}}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        <div class="text-gray-900">{{ $order->receiver_name }}</div>
                                        <div class="text-gray-500">{{ $order->receiver_street . ' ' . $order->receiver_housenumber }}</div>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        @if($order->qls_shipping_product_id === null || $order->qls_shipping_product_combination_id === null)
                                            <span class="inline-flex rounded-full bg-red-100 px-2 text-xs font-semibold leading-5 text-red-800">No Shipping Product</span>
                                        @else
                                            <span class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">Product ID: {{ $order->qls_shipping_product_id }}</span>
                                        @endif
                                    </td>
                                    <td class="items-end px-3 py-4 relative whitespace-nowrap text-sm font-medium ">
                                        @if($order->qls_shipping_product_id === null || $order->qls_shipping_product_combination_id === null)
                                            <a href="{{ route('orders.product', $order) }}"
                                               class="text-indigo-600 hover:text-indigo-900">Select Product</a>
                                        @else
                                            <span class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">Selected</span>
                                        @endif
                                    </td>
                                    <td class="items-end px-3 py-4 relative whitespace-nowrap text-sm font-medium ">
                                        @if($order->qls_shipping_product_id || $order->qls_shipping_product_combination_id)
                                            <a href="{{ route('orders.label', $order) }}"
                                               class="text-indigo-600 hover:text-indigo-900">Label</a> |
                                            <a href="{{ route('orders.pdf', $order) }}"
                                               class="text-indigo-600 hover:text-indigo-900">Slip</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
