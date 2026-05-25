<x-filament-panels::page>
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    @php
        $frontBg = asset('images/LNB_Brgy_ID_Front_Blank.png');
        $backBg = asset('images/LNB_Brgy_ID_Back_Blank.png');
        $name = $this->fullName();
        $position = 'PUNONG BARANGAY';
        $mockQrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=170x170&data=' . urlencode((string) $record->id);
    @endphp

    <style>
        @font-face {
            font-family: 'Galvji';
            src: url('{{ asset('fonts/Galvji.ttc') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        .id-print-wrapper {
            display: grid;
            gap: 18px;
        }

        .id-card {
            position: relative;
            width: 1000px;
            height: 620px;
            overflow: hidden;
            font-family: 'Galvji', Arial, sans-serif;
            color: #101010;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            border: 1px solid #d8d8d8;
        }

        .front .photo {
            position: absolute;
            left: 56px;
            top: 154px;
            width: 238px;
            height: 268px;
            object-fit: cover;
            background: #f2f2f2;
        }

        .front .signature {
            position: absolute;
            left: 44px;
            top: 444px;
            width: 262px;
            height: 90px;
            object-fit: contain;
        }

        .front .signature-label {
            position: absolute;
            left: 44px;
            top: 529px;
            width: 262px;
            text-align: center;
            font-size: 15px;
            color: #2a2a2a;
            font-weight: 600;
        }

        .front .field {
            position: absolute;
            font-size: 16px;
            line-height: 1.22;
        }

        .front .value-strong {
            font-weight: 700;
            font-size: 28px;
            line-height: 1;
        }

        .front .name { left: 338px; top: 160px; width: 604px; }
        .front .position { left: 338px; top: 226px; width: 290px; }
        .front .idno { left: 650px; top: 226px; width: 200px; }
        .front .barangay { left: 338px; top: 278px; width: 290px; }
        .front .city { left: 650px; top: 278px; width: 290px; }
        .front .region { left: 338px; top: 330px; width: 290px; }
        .front .province { left: 650px; top: 330px; width: 290px; }
        .front .address { left: 338px; top: 382px; width: 405px; }
        .front .validity { left: 338px; top: 465px; width: 430px; }
        .front .birthdate { left: 338px; top: 518px; width: 240px; }
        .front .gender { left: 650px; top: 518px; width: 240px; }

        .front .qr {
            position: absolute;
            left: 764px;
            top: 382px;
            width: 172px;
            height: 172px;
            background: #fff;
            padding: 1px;
            box-sizing: border-box;
            border: none;
        }

        .front .qr img {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: contain;
        }

        .back .emergency {
            position: absolute;
            left: 190px;
            top: 410px;
            width: 640px;
            text-align: center;
            font-size: 28px;
            line-height: 1.15;
        }

        @media print {
            @page { size: auto; margin: 0; }
            body * { visibility: hidden; }
            .id-print-wrapper, .id-print-wrapper * { visibility: visible; }
            .id-print-wrapper { position: absolute; left: 0; top: 0; }
            .id-card { border: none; page-break-inside: avoid; margin-bottom: 14px; }
        }
    </style>

    <div class="id-print-wrapper" x-data x-on:print-page.window="window.print()">
        @if($this->shouldShowDebugInfo())
            <div style="font-size:12px; background:#fffbe6; border:1px solid #e7d58a; padding:8px; margin-bottom:8px;">
                <strong>Debug:</strong><br>
                Photo DB value: {{ $record->photo ?: '[empty]' }}<br>
                Signature DB value: {{ $record->signature ?: '[empty]' }}<br>
                Photo resolved path: {{ $this->photoResolvedPath ?: '[none]' }}<br>
                Signature resolved path: {{ $this->signatureResolvedPath ?: '[none]' }}<br>
                Photo loaded: {{ $this->photoDataUri ? 'yes' : 'no' }}<br>
                Signature loaded: {{ $this->signatureDataUri ? 'yes' : 'no' }}
            </div>
        @endif

        <div class="id-card front" style="background-image: url('{{ $frontBg }}')">
            @if($this->photoDataUri)
                <img class="photo" src="{{ $this->photoDataUri }}" alt="Photo">
            @else
                <div class="photo" style="display:flex; align-items:center; justify-content:center; color:#666; font-weight:700;">NO PHOTO</div>
            @endif

            @if($this->signatureDataUri)
                <img class="signature" src="{{ $this->signatureDataUri }}" alt="Signature">
            @else
                <div class="signature" style="display:flex; align-items:center; justify-content:center; color:#666; font-size:12px; font-weight:700;">NO SIGNATURE</div>
            @endif

            <div class="field name">
                <div style="font-size: 18px; color: #2a2a2a;">Last Name, First Name, Middle Name</div>
                <div class="value-strong" style="font-size: 24px;">{{ $name }}</div>
            </div>

            <div class="field position">
                <div style="font-size: 18px; color: #2a2a2a;">Position</div>
                <div style="font-size: 21px; font-weight: 700; line-height:1.05;">{{ $position }}</div>
            </div>

            <div class="field idno">
                <div style="font-size: 18px; color: #2a2a2a;">ID No.</div>
                <div style="font-size: 21px; font-weight: 700; line-height:1.05;">{{ $record->id }}</div>
            </div>

            <div class="field barangay"><div style="font-size: 16px; color: #2a2a2a;">Barangay</div><div style="font-size:{{ $this->placeFontSize($record->barangay) }}px; font-weight:700; line-height:1.1;">{{ $this->titleCase($record->barangay) }}</div></div>
            <div class="field city"><div style="font-size: 16px; color: #2a2a2a;">Municipality/City</div><div style="font-size:{{ $this->placeFontSize($record->city) }}px; font-weight:700; line-height:1.1;">{{ $this->titleCase($record->city) }}</div></div>
            <div class="field region"><div style="font-size: 16px; color: #2a2a2a;">Region</div><div style="font-size:{{ $this->placeFontSize($record->region) }}px; font-weight:700; line-height:1.1;">{{ $this->titleCase($record->region) }}</div></div>
            <div class="field province"><div style="font-size: 16px; color: #2a2a2a;">Province</div><div style="font-size:{{ $this->placeFontSize($record->province) }}px; font-weight:700; line-height:1.1;">{{ $this->titleCase($record->province) }}</div></div>
            <div class="field address">
                <div style="font-size: 16px; color: #2a2a2a;">Address</div>
                <div style="font-size: {{ $this->addressFontSize($record->home_address) }}px; font-weight:700; line-height:1.18; overflow-wrap:anywhere; word-break:break-word; max-height:78px; overflow:hidden;">
                    {{ $this->titleCase($record->home_address) }}
                </div>
            </div>
            <div class="field validity"><div style="font-size: 16px; color: #2a2a2a;">Validity Period</div><div style="font-size:21px; font-weight:700; line-height:1.1;">{{ $this->validityPeriod() }}</div></div>
            <div class="field birthdate"><div style="font-size: 16px; color: #2a2a2a;">Date of Birth</div><div style="font-size:21px; font-weight:700; line-height:1.1;">{{ $this->birthdate() }}</div></div>
            <div class="field gender"><div style="font-size: 16px; color: #2a2a2a;">Gender</div><div style="font-size:21px; font-weight:700; line-height:1.1;">{{ $this->titleCase($record->gender) }}</div></div>

            <div class="qr" aria-label="QR">
                <img src="{{ $mockQrUrl }}" alt="QR Code">
            </div>
            <div class="signature-label">Signature</div>
        </div>

        <div class="id-card back" style="background-image: url('{{ $backBg }}')">
            <div class="emergency">
                <div style="font-size: 22px; font-weight: 700;">EMERGENCY CONTACT</div>
                <div style="font-size: 31px;">{{ $this->titleCase($record->emergency_contact_person) }}</div>
                <div style="font-size: 33px;">{{ $this->normalizePhone($record->emergency_contact_number) }}</div>
            </div>
        </div>
    </div>
</x-filament-panels::page>
