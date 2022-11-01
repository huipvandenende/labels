<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Selected Order Details</h3>
            </div>
            <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                <dl class="sm:divide-y sm:divide-gray-200">
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Recipient name</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $order->receiver_name }}</dd>
                    </div>
                    @if ($order->receiver_company)
                        <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Recipient company</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $order->receiver_company }}
                            </dd>
                        </div>
                    @endif
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Address</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            {{ $order->receiver_street . ' ' . $order->receiver_housenumber }}</dd>
                    </div>
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Zip/City</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            {{ $order->zip . ' ' . $order->receiver_city }}</dd>
                    </div>

                </dl>

            </div>

        </div>

        @if (!$order->qls_shipping_product_id)
            <div class="overflow-hidden bg-white shadow sm:rounded-lg mt-4 mb-4">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Select Shipping Product</h3>
                </div>
                <fieldset>
                    @foreach ($products as $product)
                        @foreach ($product['pricing'] as $pricing)
                            @if ($pricing['country'] == $order->receiver_country)
                                <div class="relative -space-y-px rounded-md bg-white">
                                    <label
                                        class="rounded-tl-md rounded-tr-md relative border p-4 flex flex-col cursor-pointer md:pl-4 md:pr-6 md:grid md:grid-cols-3 focus:outline-none">
                                        <span class="flex items-center text-sm">
                                            <span id="pricing-plans-0-label"
                                                class="ml-3 font-medium">{{ $product['name'] }}</span>
                                        </span>
                                        <span class="ml-6 pl-1 text-sm md:ml-0 md:pl-0 md:text-center">
                                            <span>€ {{ $pricing['price'] }} </span></span>
                                        <span id="pricing-plans-0-description-1"
                                            class="ml-6 pl-1 text-sm md:ml-0 md:pl-0 md:text-right">{{ $product['specifications'] }}
                                            postings</span>
                                    </label>
                                    @foreach ($product['combinations'] as $combination)
                                        <label
                                            class="rounded-tl-md rounded-tr-md relative border p-4 bg-gray-50  flex-col cursor-pointer md:pl-4 md:pr-6 md:grid md:grid-cols-1 focus:outline-none">
                                            <span class="flex items-center text-sm">
                                                <form action="{{ route('orders.edit') }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="product" value="{{ $order }}">
                                                    <input type="hidden" name="product_id"
                                                        value="{{ $product['id'] }}">
                                                    <input type="hidden" name="product_combi_id"
                                                        value="{{ $combination['id'] }}">
                                                    <button type="submit"
                                                        class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">
                                                        Select
                                                    </button>
                                                </form>
                                                <span
                                                    class="ml-4 inline-flex rounded-full bg-indigo-100 px-2 text-xs font-semibold leading-5 text-indigo-800">Combination</span>
                                                <span class="ml-3 font-small">{{ $combination['name'] }}</span>
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    @endforeach
                </fieldset>
            </div>
        @endif
    </div>
</x-app-layout>
