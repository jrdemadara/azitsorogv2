<x-filament-panels::page>
    <div class="mx-auto max-w-4xl bg-white p-8 print:p-0 print:max-w-none" style="font-family: Arial, sans-serif;">
        <!-- Header Section -->
        <div class="flex justify-between items-start mb-6">
            <div class="flex-1">
                <div class="flex items-center gap-3 mb-2">
                    <img src="{{ asset('images/logo.png') }}" alt="Azitsorog Logo" class="h-12 w-auto">
                    <h1 class="text-2xl font-bold text-gray-900">azitsorog, inc.</h1>
                </div>
                <div class="text-sm text-gray-700 space-y-1">
                    <p><strong>VAT Reg TIN:</strong> 215-398-290-00000</p>
                    <p>103 Gloria St., Ortigas Ext., Santo Domingo 1900, Cainta, Rizal, Philippines</p>
                    <p><strong>Tel. Nos.:</strong> (02) 89351542, 86565899, 84044187, 84044834, 89902306 / <strong>Telefax No.:</strong> (02) 8938-7214</p>
                    <p><strong>PRODUCTS OFFERED:</strong> CARD PRINTER, RFID CARD, ID HOLDER NECKLACE, CORPORATE GIVE AWAYS</p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-2xl font-bold text-gray-900 mb-2" style="writing-mode: vertical-rl; text-orientation: mixed;">SALES INVOICE</p>
                <div class="mt-4">
                    <p class="text-sm text-gray-700">INVOICE</p>
                    <p class="text-3xl font-bold text-red-600">{{ $record->si_number }}</p>
                </div>
            </div>
        </div>

        <!-- Sales Type and Customer Info -->
        <div class="grid grid-cols-2 gap-6 mb-6">
            <div>
                <div class="mb-4">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" {{ $record->type === 'cash' ? 'checked' : '' }} disabled class="w-4 h-4">
                        <span class="text-sm font-semibold">CASH SALES</span>
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" {{ $record->type === 'charge' ? 'checked' : '' }} disabled class="w-4 h-4">
                        <span class="text-sm font-semibold">CHARGE SALES</span>
                    </label>
                </div>
                <div class="border-t-2 border-gray-900 pt-2">
                    <p class="text-sm font-semibold mb-2">SOLD TO:</p>
                    <p class="text-sm"><strong>Registered Name:</strong> {{ $record->client->name ?? '—' }}</p>
                    <p class="text-sm"><strong>TIN:</strong> {{ $record->client->tin ?? '—' }}</p>
                    <p class="text-sm"><strong>Address:</strong> {{ $record->client->address ?? '—' }}</p>
                </div>
            </div>
            <div class="text-right">
                <div class="space-y-2 mb-4">
                    <p class="text-sm"><strong>Date:</strong> {{ $record->date ? $record->date->format('F d, Y') : '—' }}</p>
                    <p class="text-sm"><strong>Terms:</strong> {{ $record->terms ?? '—' }}</p>
                </div>
            </div>
        </div>

        <!-- Items Table -->
        <div class="mb-6">
            <table class="w-full border-collapse border-2 border-gray-900">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border-2 border-gray-900 px-3 py-2 text-left text-sm font-semibold">ITEM DESCRIPTION / NATURE OF SERVICE</th>
                        <th class="border-2 border-gray-900 px-3 py-2 text-center text-sm font-semibold">QUANTITY</th>
                        <th class="border-2 border-gray-900 px-3 py-2 text-center text-sm font-semibold">UNIT COST</th>
                        <th class="border-2 border-gray-900 px-3 py-2 text-right text-sm font-semibold">AMOUNT</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($record->items as $item)
                        <tr>
                            <td class="border-2 border-gray-900 px-3 py-2 text-sm">{{ $item->item_name }}</td>
                            <td class="border-2 border-gray-900 px-3 py-2 text-center text-sm">{{ number_format($item->quantity, 2) }}</td>
                            <td class="border-2 border-gray-900 px-3 py-2 text-center text-sm">₱{{ number_format($item->unit_cost, 2) }}</td>
                            <td class="border-2 border-gray-900 px-3 py-2 text-right text-sm">₱{{ number_format($item->amount, 2) }}</td>
                        </tr>
                    @empty
                        @for($i = 0; $i < 10; $i++)
                            <tr>
                                <td class="border-2 border-gray-900 px-3 py-2 text-sm">&nbsp;</td>
                                <td class="border-2 border-gray-900 px-3 py-2 text-center text-sm">&nbsp;</td>
                                <td class="border-2 border-gray-900 px-3 py-2 text-center text-sm">&nbsp;</td>
                                <td class="border-2 border-gray-900 px-3 py-2 text-right text-sm">&nbsp;</td>
                            </tr>
                        @endfor
                    @endforelse
                    @if($record->items->count() < 10)
                        @for($i = $record->items->count(); $i < 10; $i++)
                            <tr>
                                <td class="border-2 border-gray-900 px-3 py-2 text-sm">&nbsp;</td>
                                <td class="border-2 border-gray-900 px-3 py-2 text-center text-sm">&nbsp;</td>
                                <td class="border-2 border-gray-900 px-3 py-2 text-center text-sm">&nbsp;</td>
                                <td class="border-2 border-gray-900 px-3 py-2 text-right text-sm">&nbsp;</td>
                            </tr>
                        @endfor
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Summary Section -->
        <div class="grid grid-cols-2 gap-6 mb-6">
            <div>
                <table class="w-full border-collapse border-2 border-gray-900">
                    <tr>
                        <td class="border-2 border-gray-900 px-3 py-2 text-sm font-semibold">VATable Sales</td>
                        <td class="border-2 border-gray-900 px-3 py-2 text-right text-sm">₱{{ number_format($record->vatable_sales ?? 0, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="border-2 border-gray-900 px-3 py-2 text-sm font-semibold">VAT</td>
                        <td class="border-2 border-gray-900 px-3 py-2 text-right text-sm">₱{{ number_format($record->vat ?? 0, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="border-2 border-gray-900 px-3 py-2 text-sm font-semibold">Zero-Rated Sales</td>
                        <td class="border-2 border-gray-900 px-3 py-2 text-right text-sm">₱{{ number_format($record->zero_rated_sales ?? 0, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="border-2 border-gray-900 px-3 py-2 text-sm font-semibold">VAT-Exempt Sales</td>
                        <td class="border-2 border-gray-900 px-3 py-2 text-right text-sm">₱{{ number_format($record->vat_exempt_sales ?? 0, 2) }}</td>
                    </tr>
                </table>
                <div class="mt-4 space-y-2 text-sm">
                    <p><strong>SC/PWD/NAAC/MOV/Solo Parent ID No.:</strong> {{ $record->discount_id_number ?? '—' }}</p>
                    <p><strong>SC/PWD/NAAC/MOV/SP Signature:</strong> _________________________</p>
                </div>
            </div>
            <div>
                <div class="space-y-2 text-sm text-right">
                    <div class="flex justify-between">
                        <span>Total Sales (VAT Inclusive)</span>
                        <span class="font-semibold">₱{{ number_format($record->total_sales_vat_inclusive ?? 0, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Less: VAT</span>
                        <span>₱{{ number_format($record->less_vat ?? 0, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Amount: Net of VAT</span>
                        <span>₱{{ number_format($record->amount_net_of_vat ?? 0, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Less: Discount (SC/PWD/NAAC/MOV/SP)</span>
                        <span>₱{{ number_format($record->discount ?? 0, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Add: VAT</span>
                        <span>₱{{ number_format($record->add_vat ?? 0, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Less: Withholding Tax</span>
                        <span>₱{{ number_format($record->withholding_tax ?? 0, 2) }}</span>
                    </div>
                    <div class="flex justify-between border-t-2 border-gray-900 pt-2 mt-2">
                        <span class="font-bold text-lg">TOTAL AMOUNT DUE</span>
                        <span class="font-bold text-lg">₱{{ number_format($record->total_amount_due ?? 0, 2) }}</span>
                    </div>
                </div>
                <div class="mt-4 text-sm">
                    <p class="mb-2"><strong>Received the amount of:</strong> ________________________________</p>
                    <p class="mt-4">Received the above goods and services in good order & condition.</p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="grid grid-cols-2 gap-6 mt-8 text-xs text-gray-700">
            <div>
                <p><strong>BIR AUTHORITY TO PRINT NO:</strong> 046AU20240000014722</p>
                <p><strong>DATE ISSUED:</strong> 10-04-2024</p>
                <p><strong>APPROVED SERIES:</strong> 32001-34500 50 BKLTS. (50X3)</p>
                <p><strong>AFPG PRINTING SERVICES & SUPPLIES</strong></p>
                <p><strong>NON VAT REG. TIN:</strong> 126-712-714-00000</p>
                <p>113 - J. NATIONAL RD., PUTATAN, MUNTINLUPA CITY</p>
            </div>
            <div>
                <p><strong>PRINTER'S ACCREDITATION NO.</strong> 53BMP20240000000009</p>
                <p><strong>DATE OF ACCREDITATION:</strong> 01-16-2024 <strong>EXPIRY DATE:</strong> 01-15-2029</p>
            </div>
        </div>

        <!-- Signature Line -->
        <div class="mt-8 text-right">
            <p class="text-sm border-t-2 border-gray-900 pt-2 inline-block">
                <strong>Printed Name & Signature / Authorized Representative:</strong> {{ $record->printed_name ?? '_________________________' }}
            </p>
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
</x-filament-panels::page>

