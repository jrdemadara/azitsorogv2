<x-filament-panels::page>
    <div class="mx-auto max-w-4xl bg-white p-8 print:p-0 print:max-w-none" style="font-family: 'Times New Roman', serif; color: #111;">
        <!-- Header -->
        <div class="mb-4">
            <div class="flex items-start justify-between">
                <div class="w-1/4 text-left text-xs">
                    <div class="flex flex-col gap-2 pt-6">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" {{ $record->type === 'cash' ? 'checked' : '' }} disabled class="w-4 h-4">
                            <span class="font-semibold">CASH SALES</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" {{ $record->type === 'charge' ? 'checked' : '' }} disabled class="w-4 h-4">
                            <span class="font-semibold">CHARGE SALES</span>
                        </label>
                    </div>
                </div>
                <div class="w-1/2 text-center">
                    <div class="flex items-center justify-center gap-3">
                        <img src="{{ asset('images/logo.png') }}" alt="Azitsorog Logo" class="h-10 w-auto">
                        <h1 class="text-2xl font-bold">azitsorog, inc.</h1>
                    </div>
                    <div class="text-[11px] leading-tight mt-1">
                        <p><strong>VAT Reg TIN:</strong> 215-398-290-00000</p>
                        <p>103 Gloria St., Ortigas Ext., Santo Domingo 1900, Cainta, Rizal, Philippines</p>
                        <p><strong>Tel. Nos.:</strong> (02) 89351542, 86565899, 84044187, 84044834, 89902306 / <strong>Telefax No.:</strong> (02) 8938-7214</p>
                        <p><strong>PRODUCTS OFFERED:</strong> CARD PRINTER, RFID CARD, ID HOLDER NECKLACE, CORPORATE GIVE AWAYS</p>
                    </div>
                </div>
                <div class="w-1/4 text-right text-sm">
                    <div class="pt-4">
                        <div class="text-sm font-semibold">SALES</div>
                        <div class="text-xl font-semibold">INVOICE</div>
                        <div class="text-2xl font-bold text-red-600">{{ $record->si_number }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sold To / Date / Terms -->
        <div class="text-xs mb-3">
            <div class="flex items-center gap-2">
                <span class="w-20 font-semibold">SOLD TO:</span>
                <div class="flex-1 border-b border-gray-900 h-4">{{ $record->client->name ?? '—' }}</div>
                <span class="w-12 text-right">Date:</span>
                <div class="w-40 border-b border-gray-900 h-4 text-right">{{ $record->date ? $record->date->format('F d, Y') : '—' }}</div>
            </div>
            <div class="flex items-center gap-2 mt-2">
                <span class="w-20 font-semibold">TIN:</span>
                <div class="flex-1 border-b border-gray-900 h-4">{{ $record->client->tin ?? '—' }}</div>
                <span class="w-12 text-right">Terms:</span>
                <div class="w-40 border-b border-gray-900 h-4 text-right">{{ $record->terms ?? '—' }}</div>
            </div>
            <div class="flex items-center gap-2 mt-2">
                <span class="w-20 font-semibold">Address:</span>
                <div class="flex-1 border-b border-gray-900 h-4">{{ $record->client->address ?? '—' }}</div>
            </div>
        </div>

        <!-- Items Table -->
        <div class="mb-6">
            <table class="w-full border-collapse border-2 border-gray-900 text-xs">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-900 px-2 py-1 text-left font-semibold">ITEM DESCRIPTION / NATURE OF SERVICE</th>
                        <th class="border border-gray-900 px-2 py-1 text-center font-semibold">QUANTITY</th>
                        <th class="border border-gray-900 px-2 py-1 text-center font-semibold">UNIT COST</th>
                        <th class="border border-gray-900 px-2 py-1 text-right font-semibold">AMOUNT</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($record->items as $item)
                        <tr>
                            <td class="border border-gray-900 px-2 py-1 text-sm">{{ $item->item_name }}</td>
                            <td class="border border-gray-900 px-2 py-1 text-center">{{ number_format($item->quantity, 2) }}</td>
                            <td class="border border-gray-900 px-2 py-1 text-center">₱{{ number_format($item->unit_cost, 2) }}</td>
                            <td class="border border-gray-900 px-2 py-1 text-right">₱{{ number_format($item->amount, 2) }}</td>
                        </tr>
                    @empty
                        @for($i = 0; $i < 10; $i++)
                            <tr>
                                <td class="border border-gray-900 px-2 py-1">&nbsp;</td>
                                <td class="border border-gray-900 px-2 py-1">&nbsp;</td>
                                <td class="border border-gray-900 px-2 py-1">&nbsp;</td>
                                <td class="border border-gray-900 px-2 py-1">&nbsp;</td>
                            </tr>
                        @endfor
                    @endforelse
                    @if($record->items->count() < 10)
                        @for($i = $record->items->count(); $i < 10; $i++)
                            <tr>
                                <td class="border border-gray-900 px-2 py-1">&nbsp;</td>
                                <td class="border border-gray-900 px-2 py-1">&nbsp;</td>
                                <td class="border border-gray-900 px-2 py-1">&nbsp;</td>
                                <td class="border border-gray-900 px-2 py-1">&nbsp;</td>
                            </tr>
                        @endfor
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Summary Section -->
        <div class="grid grid-cols-2 gap-6 mb-6 text-xs">
            <div>
                <div class="grid grid-cols-2 border border-gray-900">
                    <div class="border-b border-r border-gray-900 px-2 py-1 font-semibold">VATable Sales</div>
                    <div class="border-b border-gray-900 px-2 py-1 text-right">₱{{ number_format($record->vatable_sales ?? 0, 2) }}</div>
                    <div class="border-r border-gray-900 px-2 py-1 font-semibold">VAT</div>
                    <div class="px-2 py-1 text-right">₱{{ number_format($record->vat ?? 0, 2) }}</div>
                </div>
                <div class="mt-3">
                    <div class="border-b border-gray-900 h-5 text-[11px]">SC/PWD/NAAC/MOV/SP ID No.: </div>
                    <div class="border-b border-gray-900 h-5 text-[11px]">SC/PWD/NAAC/MOV/SP Signature: </div>
                </div>
            </div>
            <div>
                <div class="border border-gray-900">
                    <div class="flex justify-between border-b border-gray-900 px-2 py-1">
                        <span class="font-semibold">Gross Amount</span>
                        <span>₱{{ number_format($record->total_amount ?? 0, 2) }}</span>
                    </div>
                    <div class="flex justify-between px-2 py-1 font-bold">
                        <span>TOTAL AMOUNT DUE</span>
                        <span>₱{{ number_format($record->total_amount ?? 0, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="border-t border-gray-900 pt-3 mt-6 text-[10px] text-gray-700 grid grid-cols-2 gap-6">
            <div>
                <p><strong>BIR Authority to Print No.:</strong> 046AU20240000014722</p>
                <p><strong>Date Issued:</strong> 10-04-2024</p>
                <p><strong>Approved Series:</strong> 32001-34500 50 BKLTS. (50X3)</p>
                <p><strong>AFPG Printing Services & Supplies</strong></p>
                <p><strong>Non VAT Reg. TIN:</strong> 126-712-714-00000</p>
                <p>113 - J. National Rd., Putatan, Muntinlupa City</p>
            </div>
            <div>
                <p><strong>Printer's Accreditation No.:</strong> 53BMP20240000000009</p>
                <p><strong>Date of Accreditation:</strong> 01-16-2024</p>
                <p><strong>Expiry Date:</strong> 01-15-2029</p>
            </div>
        </div>

        <!-- Signature Line -->
        <div class="mt-6 text-xs">
            <p>Received the amount of: ________________________________________</p>
            <p class="mt-3">Received the above goods and services in good order & condition.</p>
            <div class="mt-6 text-right">
                <div class="border-t border-gray-900 inline-block min-w-[260px] pt-1">
                    Printed Name & Signature / Authorized Representative
                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            .print\:p-0 {
                padding: 0 !important;
            }
            .print\:max-w-none {
                max-width: none !important;
            }
        }
    </style>

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('print-page', () => {
                window.print();
            });
        });
    </script>
</x-filament-panels::page>
