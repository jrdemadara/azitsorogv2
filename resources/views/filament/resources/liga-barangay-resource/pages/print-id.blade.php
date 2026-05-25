<x-filament-panels::page>
    @php
        $frontBg = asset('id-assets/LNB_Brgy ID_Front_Format.png');
        $backBg = asset('id-assets/LNB_Brgy ID_Back_Format.png');
        $name = $this->fullName();
        $signatureName = strtoupper(trim(($record->firstname ?? '') . ' ' . ($record->lastname ?? '')));
        $position = strtoupper((string)($record->term ?? 'PUNONG BARANGAY'));
    @endphp

    <style>
        @font-face {
            font-family: 'Galvji';
            src: url('{{ asset('id-assets/Galvji.ttc') }}') format('truetype');
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
            top: 188px;
            width: 238px;
            height: 268px;
            object-fit: cover;
            background: #f2f2f2;
        }

        .front .signature {
            position: absolute;
            left: 64px;
            top: 472px;
            width: 220px;
            height: 64px;
            object-fit: contain;
        }

        .front .field {
            position: absolute;
            font-size: 23px;
            line-height: 1.18;
        }

        .front .value-strong {
            font-weight: 700;
            font-size: 40px;
            line-height: 1;
        }

        .front .name { left: 338px; top: 186px; width: 604px; }
        .front .position { left: 338px; top: 244px; width: 290px; }
        .front .idno { left: 650px; top: 244px; width: 200px; }
        .front .barangay { left: 338px; top: 304px; width: 290px; }
        .front .city { left: 650px; top: 304px; width: 290px; }
        .front .region { left: 338px; top: 365px; width: 290px; }
        .front .province { left: 650px; top: 365px; width: 290px; }
        .front .address { left: 338px; top: 427px; width: 590px; }
        .front .validity { left: 338px; top: 516px; width: 430px; }
        .front .birthdate { left: 338px; top: 581px; width: 200px; }
        .front .gender { left: 650px; top: 581px; width: 200px; }

        .front .qr {
            position: absolute;
            left: 764px;
            top: 424px;
            width: 172px;
            height: 172px;
            background: #fff;
            padding: 6px;
            box-sizing: border-box;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            text-align: center;
            border: 2px solid #111;
        }

        .back .signatory-sign {
            position: absolute;
            left: 425px;
            top: 136px;
            width: 150px;
            height: 72px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 54px;
            font-style: italic;
        }

        .back .signatory-name {
            position: absolute;
            left: 192px;
            top: 220px;
            width: 640px;
            text-align: center;
            font-size: 45px;
            font-weight: 700;
            line-height: 1;
        }

        .back .emergency {
            position: absolute;
            left: 190px;
            top: 392px;
            width: 640px;
            text-align: center;
            font-size: 52px;
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
        <div class="id-card front" style="background-image: url('{{ $frontBg }}')">
            @if($this->photoDataUri)
                <img class="photo" src="{{ $this->photoDataUri }}" alt="Photo">
            @endif

            @if($this->signatureDataUri)
                <img class="signature" src="{{ $this->signatureDataUri }}" alt="Signature">
            @endif

            <div class="field name">
                <div style="font-size: 18px; color: #2a2a2a;">Last Name, First Name, Middle Name</div>
                <div class="value-strong">{{ $name }}</div>
            </div>

            <div class="field position">
                <div style="font-size: 18px; color: #2a2a2a;">Position</div>
                <div style="font-size: 39px; font-weight: 700; line-height:1;">{{ $position }}</div>
            </div>

            <div class="field idno">
                <div style="font-size: 18px; color: #2a2a2a;">ID No.</div>
                <div style="font-size: 39px; font-weight: 700; line-height:1;">{{ $record->id }}</div>
            </div>

            <div class="field barangay"><div style="font-size: 18px; color: #2a2a2a;">Barangay</div><div style="font-size:45px; font-weight:700; line-height:1;">{{ $record->barangay ?: 'N/A' }}</div></div>
            <div class="field city"><div style="font-size: 18px; color: #2a2a2a;">Municipality/City</div><div style="font-size:45px; font-weight:700; line-height:1;">{{ $record->city ?: 'N/A' }}</div></div>
            <div class="field region"><div style="font-size: 18px; color: #2a2a2a;">Region</div><div style="font-size:45px; font-weight:700; line-height:1;">{{ $record->region ?: 'N/A' }}</div></div>
            <div class="field province"><div style="font-size: 18px; color: #2a2a2a;">Province</div><div style="font-size:45px; font-weight:700; line-height:1;">{{ $record->province ?: 'N/A' }}</div></div>
            <div class="field address"><div style="font-size: 18px; color: #2a2a2a;">Address</div><div style="font-size: 40px; font-weight:700; line-height:1.05;">{{ $record->home_address ?: 'N/A' }}</div></div>
            <div class="field validity"><div style="font-size: 18px; color: #2a2a2a;">Validity Period</div><div style="font-size:46px; font-weight:700; line-height:1;">{{ $this->validityPeriod() }}</div></div>
            <div class="field birthdate"><div style="font-size: 18px; color: #2a2a2a;">Date of Birth</div><div style="font-size:52px; font-weight:700; line-height:1;">{{ $this->birthdate() }}</div></div>
            <div class="field gender"><div style="font-size: 18px; color: #2a2a2a;">Gender</div><div style="font-size:52px; font-weight:700; line-height:1;">{{ $record->gender ?: 'N/A' }}</div></div>

            <div class="qr">
                <div>
                    <strong>QR</strong><br>
                    ID: {{ $record->id }}
                </div>
            </div>
        </div>

        <div class="id-card back" style="background-image: url('{{ $backBg }}')">
            <div class="signatory-sign">/s/</div>
            <div class="signatory-name">HON. MARIA KATRINA JESSICA G. DY</div>

            <div class="emergency">
                <div style="font-size: 24px; font-weight: 700;">EMERGENCY CONTACT</div>
                <div style="font-size: 44px;">{{ $record->emergency_contact_person ?: 'N/A' }}</div>
                <div style="font-size: 52px;">{{ $record->emergency_contact_number ?: 'N/A' }}</div>
            </div>
        </div>
    </div>
</x-filament-panels::page>
