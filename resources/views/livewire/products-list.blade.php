<div class="p-6 max-w-7xl mx-auto">

    <div class="flex justify-between mb-4">
        <h1 class="text-2xl font-bold">Products</h1>

        <div class="space-x-2">
            <button wire:click="sortBy('created_at')" class="px-3 py-1 bg-gray-200 rounded">
                Date
            </button>
            <button wire:click="sortBy('price')" class="px-3 py-1 bg-gray-200 rounded">
                Price
            </button>
            <button wire:click="sortBy('title')" class="px-3 py-1 bg-gray-200 rounded">
                Title
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
        @foreach($products as $product)
            <div class="border rounded shadow p-3 bg-white">

                <img
                    src="{{ optional($product->images->first())->url }}"
                    class="w-full h-48 object-cover rounded mb-2"
                />

                <h2 class="font-semibold">{{ $product->title }}</h2>

                <p class="text-sm text-gray-600">
                    {{ $product->category }}
                </p>

                <p class="mt-2 font-bold text-green-600">
                    € {{ number_format($product->price, 2) }}
                </p>

                <p class="text-sm text-gray-500 mt-2">
                    {{ Str::limit($product->description, 100) }}
                </p>
            </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $products->links() }}
    </div>

</div>

