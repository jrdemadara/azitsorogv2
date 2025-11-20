<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $record->si_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .header-left {
            flex: 1;
        }
        .header-right {
            text-align: right;
        }
        .logo {
            height: 48px;
            width: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 2px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .border-t-2 {
            border-top: 2px solid #000;
        }
        .font-bold {
            font-weight: bold;
        }
        .text-red {
            color: #dc2626;
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <div class="header">
        <div class="header-left">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px;">
                <h1 style="font-size: 24px; font-weight: bold; margin: 0;">azitsorog, inc.</h1>
            </div>
            <div style="font-size: 11px; line-height: 1.6;">
                <p style="margin: 2px 0;"><strong>VAT Reg TIN:</strong> 215-398-290-00000</p>
                <p style="margin: 2px 0;">103 Gloria St., Ortigas Ext., Santo Domingo 1900, Cainta, Rizal, Philippines</p>
                <p style="margin: 2px 0;"><strong>Tel. Nos.:</strong> (02) 89351542, 86565899, 84044187, 84044834, 89902306 / <strong>Telefax No.:</strong> (02) 8938-7214</p>
                <p style="margin: 2px 0;"><strong>PRODUCTS OFFERED:</strong> CARD PRINTER, RFID CARD, ID HOLDER NECKLACE, CORPORATE GIVE AWAYS</p>
            </div>
        </div>
        <div class="header-right">
            <p style="font-size: 24px; font-weight: bold; margin-bottom: 8px; writing-mode: vertical-rl; text-orientation: mixed;">SALES INVOICE</p>
            <div style="margin-top: 16px;">
                <p style="font-size: 11px; margin: 2px 0;">INVOICE</p>
                <p style="font-size: 36px; font-weight: bold; color: #dc2626; margin: 0;">{{ $record->si_number }}</p>
            </div>
        </div>
    </div>

    <!-- Sales Type and Customer Info -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px;">
        <div>
            <div style="margin-bottom: 16px;">
                <label style="display: flex; align-items: center; gap: 8px; font-size: 11px; font-weight: bold;">
                    <span style="width: 16px; height: 16px; border: 2px solid #000; display: inline-block;">{{ $record->type === 'cash' ? '✓' : '' }}</span>
                    <span>CASH SALES</span>
                </label>
                <label style="display: flex; align-items: center; gap: 8px; font-size: 11px; font-weight: bold;">
                    <span style="width: 16px; height: 16px; border: 2px solid #000; display: inline-block;">{{ $record->type === 'charge' ? '✓' : '' }}</span>
                    <span>CHARGE SALES</span>
                </label>
            </div>
            <div style="border-top: 2px solid #000; padding-top: 8px;">
                <p style="font-size: 11px; font-weight: bold; margin-bottom: 8px;">SOLD TO:</p>
                <p style="font-size: 11px; margin: 2px 0;"><strong>Registered Name:</strong> {{ $record->client->name ?? '—' }}</p>
                <p style="font-size: 11px; margin: 2px 0;"><strong>TIN:</strong> {{ $record->client->tin ?? '—' }}</p>
                <p style="font-size: 11px; margin: 2px 0;"><strong>Address:</strong> {{ $record->client->address ?? '—' }}</p>
            </div>
        </div>
        <div style="text-align: right;">
            <div style="margin-bottom: 16px;">
                <p style="font-size: 11px; margin: 4px 0;"><strong>Date:</strong> {{ $record->date ? $record->date->format('F d, Y') : '—' }}</p>
                <p style="font-size: 11px; margin: 4px 0;"><strong>Terms:</strong> {{ $record->terms ?? '—' }}</p>
            </div>
        </div>
    </div>

    <!-- Items Table -->
    <table>
        <thead>
            <tr>
                <th style="text-align: left;">ITEM DESCRIPTION / NATURE OF SERVICE</th>
                <th style="text-align: center;">QUANTITY</th>
                <th style="text-align: center;">UNIT COST</th>
                <th style="text-align: right;">AMOUNT</th>
            </tr>
        </thead>
        <tbody>
            @forelse($record->items as $item)
                <tr>
                    <td>{{ $item->item_name }}</td>
                    <td style="text-align: center;">{{ number_format($item->quantity, 2) }}</td>
                    <td style="text-align: center;">₱{{ number_format($item->unit_cost, 2) }}</td>
                    <td style="text-align: right;">₱{{ number_format($item->amount, 2) }}</td>
                </tr>
            @empty
                @for($i = 0; $i < 10; $i++)
                    <tr>
                        <td>&nbsp;</td>
                        <td style="text-align: center;">&nbsp;</td>
                        <td style="text-align: center;">&nbsp;</td>
                        <td style="text-align: right;">&nbsp;</td>
                    </tr>
                @endfor
            @endforelse
            @if($record->items->count() < 10)
                @for($i = $record->items->count(); $i < 10; $i++)
                    <tr>
                        <td>&nbsp;</td>
                        <td style="text-align: center;">&nbsp;</td>
                        <td style="text-align: center;">&nbsp;</td>
                        <td style="text-align: right;">&nbsp;</td>
                    </tr>
                @endfor
            @endif
        </tbody>
    </table>

    <!-- Summary Section -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px;">
        <div>
            <table>
                <tr>
                    <td style="font-weight: bold;">VATable Sales</td>
                    <td style="text-align: right;">₱{{ number_format($record->vatable_sales ?? 0, 2) }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">VAT</td>
                    <td style="text-align: right;">₱{{ number_format($record->vat ?? 0, 2) }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Zero-Rated Sales</td>
                    <td style="text-align: right;">₱{{ number_format($record->zero_rated_sales ?? 0, 2) }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">VAT-Exempt Sales</td>
                    <td style="text-align: right;">₱{{ number_format($record->vat_exempt_sales ?? 0, 2) }}</td>
                </tr>
            </table>
            <div style="margin-top: 16px; font-size: 11px;">
                <p style="margin: 4px 0;"><strong>SC/PWD/NAAC/MOV/Solo Parent ID No.:</strong> {{ $record->discount_id_number ?? '—' }}</p>
                <p style="margin: 4px 0;"><strong>SC/PWD/NAAC/MOV/SP Signature:</strong> _________________________</p>
            </div>
        </div>
        <div>
            <div style="text-align: right; font-size: 11px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                    <span>Total Sales (VAT Inclusive)</span>
                    <span style="font-weight: bold;">₱{{ number_format($record->total_sales_vat_inclusive ?? 0, 2) }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                    <span>Less: VAT</span>
                    <span>₱{{ number_format($record->less_vat ?? 0, 2) }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                    <span>Amount: Net of VAT</span>
                    <span>₱{{ number_format($record->amount_net_of_vat ?? 0, 2) }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                    <span>Less: Discount (SC/PWD/NAAC/MOV/SP)</span>
                    <span>₱{{ number_format($record->discount ?? 0, 2) }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                    <span>Add: VAT</span>
                    <span>₱{{ number_format($record->add_vat ?? 0, 2) }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                    <span>Less: Withholding Tax</span>
                    <span>₱{{ number_format($record->withholding_tax ?? 0, 2) }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; border-top: 2px solid #000; padding-top: 8px; margin-top: 8px;">
                    <span style="font-weight: bold; font-size: 14px;">TOTAL AMOUNT DUE</span>
                    <span style="font-weight: bold; font-size: 14px;">₱{{ number_format($record->total_amount_due ?? 0, 2) }}</span>
                </div>
            </div>
            <div style="margin-top: 16px; font-size: 11px;">
                <p style="margin-bottom: 8px;"><strong>Received the amount of:</strong> ________________________________</p>
                <p style="margin-top: 16px;">Received the above goods and services in good order & condition.</p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-top: 32px; font-size: 10px;">
        <div>
            <p style="margin: 2px 0;"><strong>BIR AUTHORITY TO PRINT NO:</strong> 046AU20240000014722</p>
            <p style="margin: 2px 0;"><strong>DATE ISSUED:</strong> 10-04-2024</p>
            <p style="margin: 2px 0;"><strong>APPROVED SERIES:</strong> 32001-34500 50 BKLTS. (50X3)</p>
            <p style="margin: 2px 0;"><strong>AFPG PRINTING SERVICES & SUPPLIES</strong></p>
            <p style="margin: 2px 0;"><strong>NON VAT REG. TIN:</strong> 126-712-714-00000</p>
            <p style="margin: 2px 0;">113 - J. NATIONAL RD., PUTATAN, MUNTINLUPA CITY</p>
        </div>
        <div>
            <p style="margin: 2px 0;"><strong>PRINTER'S ACCREDITATION NO.</strong> 53BMP20240000000009</p>
            <p style="margin: 2px 0;"><strong>DATE OF ACCREDITATION:</strong> 01-16-2024 <strong>EXPIRY DATE:</strong> 01-15-2029</p>
        </div>
    </div>

    <!-- Signature Line -->
    <div style="margin-top: 32px; text-align: right;">
        <p style="font-size: 11px; border-top: 2px solid #000; padding-top: 8px; display: inline-block;">
            <strong>Printed Name & Signature / Authorized Representative:</strong> {{ $record->printed_name ?? '_________________________' }}
        </p>
    </div>
</body>
</html>

