<!-- resources/views/invoice.blade.php -->
<!DOCTYPE html>
<div class="mx-auto bg-cover bg-no-repeat bg-center" style="background-image: url('{{ asset('storage/invoice.jpg') }}');">
    <h2 class="text-2xl font-bold text-center text-gray-800">Invoice #{{ $record->si_number }}</h2>
    <div class="mt-4 border-b pb-4">
        <p class="text-gray-700"><strong>Client:</strong> <span class="capitalize">{{ $record->client->name }}</span>
        </p>
        <p class="text-gray-700"><strong>Type:</strong><span class="capitalize">{{ $record->type }}</span></p>
        <p class="text-gray-700"><strong>Date Created:</strong> {{ $record->created_at->format('Y-m-d H:i') }}</p>
    </div>

    <h3 class="text-xl font-semibold text-gray-700 mt-4">Items</h3>
    <div class="overflow-x-auto">
        <table class="w-full mt-3 border border-gray-200">
            <thead>
                <tr class="bg-gray-200 text-gray-700">
                    <th class="px-4 py-2 text-left border border-gray-300">Item Name</th>
                    <th class="px-4 py-2 text-left border border-gray-300">Quantity</th>
                    <th class="px-4 py-2 text-left border border-gray-300">Unit Cost</th>
                    <th class="px-4 py-2 text-left border border-gray-300">Total Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($record->items as $item)
                    <tr class="border-b">
                        <td class="px-4 py-2 border border-gray-300 capitalize">{{ $item->item_name }}</td>
                        <td class="px-4 py-2 border border-gray-300 capitalize">{{ $item->quantity }}</td>
                        <td class="px-4 py-2 border border-gray-300 capitalize">PHP {{ number_format($item->unit_cost, 2) }}
                        </td>
                        <td class="px-4 py-2 border border-gray-300 capitalize">PHP {{ number_format($item->amount, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <p class="text-lg font-semibold mt-4 text-gray-800">Total Amount: PHP {{ number_format($record->total_amount, 2) }}</p>
</div>

</html>
