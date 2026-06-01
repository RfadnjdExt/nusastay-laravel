@extends('layouts.app')

@section('title', 'Detail Pembayaran {{ $booking->booking_code }} | Nusa Stay')

@push('styles')
<style>
.receipt-wrapper {
    max-width: 720px;
    margin: 0 auto;
}
.receipt-card {
    background: var(--color-card-bg);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-soft);
    overflow: hidden;
}
.receipt-header {
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
    padding: 36px 40px;
    color: var(--color-light);
    text-align: center;
}
.receipt-body {
    padding: 36px 40px;
}
.receipt-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid var(--color-gray-light);
    font-size: 0.95rem;
}
.receipt-row:last-child {
    border-bottom: none;
}
.receipt-row-label {
    color: var(--color-gray);
}
.receipt-row-value {
    font-weight: 600;
    color: var(--color-dark);
    text-align: right;
}
.receipt-total-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 18px 0 8px;
}
.divider-dashed {
    border: none;
    border-top: 2px dashed var(--color-gray-light);
    margin: 20px 0;
}
.section-title {
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: var(--color-gray);
    font-weight: 700;
    margin-bottom: 8px;
    margin-top: 24px;
}
.status-pill-lg {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 20px;
    border-radius: var(--radius-pill);
    font-size: 0.95rem;
    font-weight: 700;
    margin-top: 12px;
}
@media print {
    nav, footer, .no-print { display: none !important; }
    main { padding-top: 0 !important; }
    .receipt-card { box-shadow: none; }
}
</style>
@endpush

@section('content')
<section style="padding: 48px 0 80px;">
    <div class="container">

        {{-- Back link --}}
        <a href="{{ route('payment.index') }}"
           class="no-print"
           style="display: inline-flex; align-items: center; gap: 8px; color: var(--color-primary); font-weight: 600; margin-bottom: 32px;">
            ← Kembali ke Riwayat Pembayaran
        </a>

        <div class="receipt-wrapper">

            @php
                $methodLabel = match($booking->payment_method) {
                    'gopay'         => ['icon' => '📱', 'label' => 'GoPay'],
                    'dana'          => ['icon' => '📱', 'label' => 'DANA'],
                    default         => ['icon' => '💰', 'label' => ucfirst($booking->payment_method)],
                };
                $statusColor = match($booking->payment_status) {
                    'completed' => '#10B981',
                    'pending'   => '#F5C842',
                    'failed'    => '#EF4444',
                    default     => '#6B7280',
                };
                $statusLabel = match($booking->payment_status) {
                    'completed' => '✅ Pembayaran Selesai',
                    'pending'   => '⏳ Menunggu Pembayaran',
                    'failed'    => '❌ Pembayaran Gagal',
                    default     => ucfirst($booking->payment_status),
                };
            @endphp

            <div class="receipt-card">

                {{-- Receipt header --}}
                <div class="receipt-header">
                    <div style="font-size: 2rem; margin-bottom: 8px;">🏝️</div>
                    <div style="font-size: 1.25rem; font-weight: 800; margin-bottom: 4px; font-family: var(--font-display);">Nusa Stay</div>
                    <div style="font-size: 0.875rem; opacity: 0.75; margin-bottom: 24px;">Bukti Pembayaran</div>

                    <div style="font-size: 2.25rem; font-weight: 800; font-family: var(--font-display); letter-spacing: 0.02em;">
                        Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                    </div>

                    <div class="status-pill-lg" style="background: {{ $statusColor }}25; color: white; border: 1px solid {{ $statusColor }}60; margin: 0 auto;">
                        {{ $statusLabel }}
                    </div>

                    <div style="margin-top: 20px; font-size: 0.875rem; opacity: 0.7;">
                        {{ $booking->created_at->format('d F Y, H:i') }} WIB
                    </div>
                </div>

                {{-- Receipt body --}}
                <div class="receipt-body">

                    {{-- Booking code --}}
                    <div style="text-align: center; padding: 20px; background: var(--color-bg); border-radius: var(--radius-md); margin-bottom: 28px;">
                        <p style="font-size: 0.8rem; color: var(--color-gray); text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 6px;">Kode Booking</p>
                        <p style="font-size: 1.75rem; font-weight: 800; color: var(--color-primary); font-family: var(--font-display); letter-spacing: 0.08em;">
                            {{ $booking->booking_code }}
                        </p>
                    </div>

                    {{-- Hotel info --}}
                    <div class="section-title">Informasi Hotel</div>
                    <div style="display: flex; gap: 16px; align-items: center; padding: 16px; background: var(--color-bg); border-radius: var(--radius-md); margin-bottom: 8px;">
                        <img src="{{ asset('images/' . $booking->hotel->image) }}"
                             alt="{{ $booking->hotel->name }}"
                             style="width: 72px; height: 72px; object-fit: cover; border-radius: var(--radius-sm); flex-shrink: 0;">
                        <div>
                            <h3 style="font-size: 1.1rem; margin-bottom: 4px;">{{ $booking->hotel->name }}</h3>
                            <p style="color: var(--color-gray); font-size: 0.875rem;">📍 {{ $booking->hotel->location }}</p>
                            @if($booking->hotel->rating)
                                <p style="color: var(--color-gold); font-size: 0.875rem; margin-top: 4px;">⭐ {{ $booking->hotel->rating }}</p>
                            @endif
                        </div>
                    </div>

                    {{-- Stay details --}}
                    <div class="section-title">Detail Menginap</div>

                    <div class="receipt-row">
                        <span class="receipt-row-label">Check-in</span>
                        <span class="receipt-row-value">{{ $booking->check_in->format('l, d F Y') }}</span>
                    </div>
                    <div class="receipt-row">
                        <span class="receipt-row-label">Check-out</span>
                        <span class="receipt-row-value">{{ $booking->check_out->format('l, d F Y') }}</span>
                    </div>
                    <div class="receipt-row">
                        <span class="receipt-row-label">Durasi</span>
                        <span class="receipt-row-value">{{ $booking->nights }} malam</span>
                    </div>
                    <div class="receipt-row">
                        <span class="receipt-row-label">Jumlah Tamu</span>
                        <span class="receipt-row-value">{{ $booking->guests }} tamu</span>
                    </div>
                    <div class="receipt-row">
                        <span class="receipt-row-label">Tipe Kamar</span>
                        <span class="receipt-row-value">{{ $booking->room_type }}</span>
                    </div>
                    @if($booking->special_requests)
                        <div class="receipt-row">
                            <span class="receipt-row-label">Permintaan Khusus</span>
                            <span class="receipt-row-value" style="max-width: 260px;">{{ $booking->special_requests }}</span>
                        </div>
                    @endif

                    {{-- Price breakdown --}}
                    <div class="section-title">Rincian Pembayaran</div>

                    <div class="receipt-row">
                        <span class="receipt-row-label">
                            Harga Kamar × {{ $booking->nights }} malam
                        </span>
                        <span class="receipt-row-value">Rp {{ number_format($booking->base_price, 0, ',', '.') }}</span>
                    </div>

                    @if($booking->discount > 0)
                        <div class="receipt-row">
                            <span class="receipt-row-label" style="color: var(--color-success);">
                                🏷️ Diskon ({{ $booking->discount }}%)
                            </span>
                            <span class="receipt-row-value" style="color: var(--color-success);">
                                - Rp {{ number_format($booking->discount_amount, 0, ',', '.') }}
                            </span>
                        </div>
                    @endif

                    <div class="receipt-row">
                        <span class="receipt-row-label">Pajak (11%)</span>
                        <span class="receipt-row-value">Rp {{ number_format($booking->tax, 0, ',', '.') }}</span>
                    </div>
                    <div class="receipt-row">
                        <span class="receipt-row-label">Biaya Layanan</span>
                        <span class="receipt-row-value">Rp {{ number_format($booking->service_fee, 0, ',', '.') }}</span>
                    </div>

                    <hr class="divider-dashed">

                    <div class="receipt-total-row">
                        <span style="font-size: 1.1rem; font-weight: 700;">Total Pembayaran</span>
                        <span style="font-size: 1.75rem; font-weight: 800; color: var(--color-primary);">
                            Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                        </span>
                    </div>

                    {{-- Payment method --}}
                    <div class="section-title">Metode Pembayaran</div>
                    <div class="receipt-row">
                        <span class="receipt-row-label">Metode</span>
                        <span class="receipt-row-value">
                            {{ $methodLabel['icon'] }} {{ $methodLabel['label'] }}
                        </span>
                    </div>
                    <div class="receipt-row">
                        <span class="receipt-row-label">Status Pembayaran</span>
                        <span class="receipt-row-value" style="color: {{ $statusColor }};">
                            {{ $statusLabel }}
                        </span>
                    </div>
                    <div class="receipt-row">
                        <span class="receipt-row-label">Status Booking</span>
                        <span class="receipt-row-value">{{ ucfirst($booking->booking_status) }}</span>
                    </div>
                    <div class="receipt-row">
                        <span class="receipt-row-label">Tanggal Transaksi</span>
                        <span class="receipt-row-value">{{ $booking->created_at->format('d M Y, H:i') }} WIB</span>
                    </div>

                    {{-- Footer note --}}
                    <div style="text-align: center; margin-top: 28px; padding: 16px; background: var(--color-bg); border-radius: var(--radius-md); color: var(--color-gray); font-size: 0.8rem; line-height: 1.6;">
                        Terima kasih telah memesan melalui <strong>Nusa Stay</strong>.<br>
                        Simpan kode booking <strong>{{ $booking->booking_code }}</strong> sebagai bukti reservasi Anda.<br>
                        Butuh bantuan? Hubungi kami di <strong>info@nusastay.com</strong>
                    </div>

                    {{-- Action buttons --}}
                    <div class="no-print" style="display: flex; gap: 12px; margin-top: 28px; justify-content: center; flex-wrap: wrap;">
                        <button onclick="window.print()"
                                class="btn btn-outline"
                                style="padding: 12px 24px;">
                            🖨️ Cetak Bukti
                        </button>
                        <a href="{{ route('payment.index') }}"
                           class="btn"
                           style="background: var(--color-primary); color: white; padding: 12px 24px;">
                            ← Kembali
                        </a>
                    </div>

                </div>{{-- /receipt-body --}}
            </div>{{-- /receipt-card --}}
        </div>{{-- /receipt-wrapper --}}
    </div>
</section>
@endsection
