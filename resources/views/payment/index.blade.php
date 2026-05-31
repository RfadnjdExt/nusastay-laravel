@extends('layouts.app')

@section('title', 'Riwayat Pembayaran | Nusa Stay')

@push('styles')
<style>
.payment-sidebar-link {
    display: block;
    padding: 12px 16px;
    border-radius: var(--radius-sm);
    color: var(--color-gray);
    font-weight: 500;
    transition: var(--transition);
}
.payment-sidebar-link:hover {
    background: var(--color-bg);
    color: var(--color-dark);
}
.payment-sidebar-link.active {
    background: var(--color-primary);
    color: var(--color-light);
    font-weight: 600;
}
.stat-card {
    background: var(--color-card-bg);
    border-radius: var(--radius-lg);
    padding: 24px;
    box-shadow: var(--shadow-soft);
    display: flex;
    align-items: center;
    gap: 16px;
}
.stat-icon {
    width: 52px;
    height: 52px;
    border-radius: var(--radius-md);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    flex-shrink: 0;
}
.payment-card {
    background: var(--color-card-bg);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-soft);
    overflow: hidden;
    transition: var(--transition);
    margin-bottom: 16px;
}
.payment-card:hover {
    box-shadow: var(--shadow-hover);
    transform: translateY(-2px);
}
.method-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 5px 12px;
    border-radius: var(--radius-pill);
    font-size: 0.8rem;
    font-weight: 600;
}
.filter-bar {
    background: var(--color-card-bg);
    border-radius: var(--radius-lg);
    padding: 20px 24px;
    box-shadow: var(--shadow-soft);
    margin-bottom: 24px;
    display: flex;
    gap: 16px;
    align-items: center;
    flex-wrap: wrap;
}
.filter-select {
    padding: 10px 14px;
    border: 1px solid var(--color-gray-light);
    border-radius: var(--radius-sm);
    font-family: var(--font-body);
    font-size: 0.9rem;
    background: var(--color-bg);
    color: var(--color-dark);
    cursor: pointer;
    outline: none;
    transition: var(--transition);
}
.filter-select:focus {
    border-color: var(--color-primary);
}
.empty-state {
    text-align: center;
    padding: 80px 0;
}
</style>
@endpush

@section('content')

{{-- Hero --}}
<section style="padding: 48px 0; background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%); color: var(--color-light);">
    <div class="container">
        <h1 style="font-size: 2.5rem; margin-bottom: 12px;">Riwayat Pembayaran</h1>
        <p style="font-size: 1.125rem; opacity: 0.85;">Pantau semua transaksi dan status pembayaran Anda</p>
    </div>
</section>

<section style="padding: 64px 0;">
    <div class="container">
        <div style="display: flex; gap: 32px; align-items: flex-start;">

            {{-- Sidebar --}}
            <div style="flex: 0 0 280px;">
                <div style="background: var(--color-card-bg); padding: 24px; border-radius: var(--radius-lg); box-shadow: var(--shadow-soft);">
                    <h3 style="font-size: 1.25rem; margin-bottom: 20px;">Akun</h3>
                    <nav style="display: flex; flex-direction: column; gap: 6px;">
                        <a href="{{ route('profile.index') }}" class="payment-sidebar-link">📋 My Bookings</a>
                        <a href="{{ route('payment.index') }}" class="payment-sidebar-link active">💳 Pembayaran</a>
                        <a href="{{ route('profile.settings') }}" class="payment-sidebar-link">⚙️ Settings</a>
                    </nav>
                </div>

                {{-- Quick Stats (sidebar) --}}
                <div style="background: var(--color-card-bg); padding: 24px; border-radius: var(--radius-lg); box-shadow: var(--shadow-soft); margin-top: 20px;">
                    <h4 style="margin-bottom: 16px; font-size: 1rem;">Ringkasan</h4>
                    <div style="display: flex; flex-direction: column; gap: 14px;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="color: var(--color-gray); font-size: 0.9rem;">Total Transaksi</span>
                            <span style="font-weight: 700; color: var(--color-dark);">{{ $totalBookings }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="color: var(--color-gray); font-size: 0.9rem;">Selesai</span>
                            <span style="font-weight: 700; color: var(--color-success);">{{ $completed }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="color: var(--color-gray); font-size: 0.9rem;">Menunggu</span>
                            <span style="font-weight: 700; color: var(--color-gold);">{{ $pending }}</span>
                        </div>
                        <div style="border-top: 1px solid var(--color-gray-light); padding-top: 14px;">
                            <span style="color: var(--color-gray); font-size: 0.85rem; display: block; margin-bottom: 4px;">Total Pengeluaran</span>
                            <span style="font-size: 1.2rem; font-weight: 700; color: var(--color-primary);">
                                Rp {{ number_format($totalSpent, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Main content --}}
            <div style="flex: 1; min-width: 0;">

                {{-- Stat cards row --}}
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 32px;">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: rgba(13,110,110,0.12);">💳</div>
                        <div>
                            <p style="color: var(--color-gray); font-size: 0.85rem; margin-bottom: 4px;">Total Transaksi</p>
                            <p style="font-size: 1.75rem; font-weight: 700; color: var(--color-dark);">{{ $totalBookings }}</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon" style="background: rgba(16,185,129,0.12);">✅</div>
                        <div>
                            <p style="color: var(--color-gray); font-size: 0.85rem; margin-bottom: 4px;">Pembayaran Selesai</p>
                            <p style="font-size: 1.75rem; font-weight: 700; color: var(--color-success);">{{ $completed }}</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon" style="background: rgba(245,200,66,0.15);">⏳</div>
                        <div>
                            <p style="color: var(--color-gray); font-size: 0.85rem; margin-bottom: 4px;">Menunggu Bayar</p>
                            <p style="font-size: 1.75rem; font-weight: 700; color: var(--color-gold);">{{ $pending }}</p>
                        </div>
                    </div>
                </div>

                {{-- Filter bar --}}
                <form method="GET" action="{{ route('payment.index') }}" class="filter-bar">
                    <span style="font-weight: 600; color: var(--color-dark); flex-shrink: 0;">Filter:</span>

                    <select name="status" class="filter-select" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>✅ Selesai</option>
                        <option value="pending"   {{ request('status') == 'pending'   ? 'selected' : '' }}>⏳ Menunggu</option>
                        <option value="failed"    {{ request('status') == 'failed'    ? 'selected' : '' }}>❌ Gagal</option>
                    </select>

                    <select name="method" class="filter-select" onchange="this.form.submit()">
                        <option value="">Semua Metode</option>
                        <option value="credit_card"    {{ request('method') == 'credit_card'    ? 'selected' : '' }}>💳 Kartu Kredit</option>
                        <option value="debit_card"     {{ request('method') == 'debit_card'     ? 'selected' : '' }}>💳 Kartu Debit</option>
                        <option value="bank_transfer"  {{ request('method') == 'bank_transfer'  ? 'selected' : '' }}>🏦 Transfer Bank</option>
                        <option value="e_wallet"       {{ request('method') == 'e_wallet'       ? 'selected' : '' }}>📱 E-Wallet</option>
                    </select>

                    @if(request('status') || request('method'))
                        <a href="{{ route('payment.index') }}" style="color: var(--color-accent); font-size: 0.875rem; font-weight: 600; white-space: nowrap;">✕ Reset</a>
                    @endif

                    <span style="margin-left: auto; color: var(--color-gray); font-size: 0.875rem;">
                        {{ $bookings->count() }} transaksi ditemukan
                    </span>
                </form>

                {{-- Payment list --}}
                @forelse($bookings as $booking)
                    @php
                        $methodLabel = match($booking->payment_method) {
                            'credit_card'   => ['icon' => '💳', 'label' => 'Kartu Kredit'],
                            'debit_card'    => ['icon' => '💳', 'label' => 'Kartu Debit'],
                            'bank_transfer' => ['icon' => '🏦', 'label' => 'Transfer Bank'],
                            'e_wallet'      => ['icon' => '📱', 'label' => 'E-Wallet'],
                            default         => ['icon' => '💰', 'label' => ucfirst($booking->payment_method)],
                        };
                        $statusColor = match($booking->payment_status) {
                            'completed' => '#10B981',
                            'pending'   => '#F5C842',
                            'failed'    => '#EF4444',
                            default     => '#6B7280',
                        };
                        $statusLabel = match($booking->payment_status) {
                            'completed' => 'Selesai',
                            'pending'   => 'Menunggu',
                            'failed'    => 'Gagal',
                            default     => ucfirst($booking->payment_status),
                        };
                    @endphp

                    <div class="payment-card">
                        <div style="display: flex; align-items: stretch;">
                            {{-- Hotel image --}}
                            <div style="flex: 0 0 160px;">
                                <img src="{{ asset('images/' . $booking->hotel->image) }}"
                                     alt="{{ $booking->hotel->name }}"
                                     style="width: 100%; height: 100%; object-fit: cover; min-height: 140px;">
                            </div>

                            {{-- Payment info --}}
                            <div style="flex: 1; padding: 20px 24px; display: flex; flex-direction: column; justify-content: space-between;">
                                <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 12px;">
                                    <div>
                                        <h3 style="font-size: 1.2rem; margin-bottom: 4px;">{{ $booking->hotel->name }}</h3>
                                        <p style="color: var(--color-gray); font-size: 0.85rem;">
                                            📍 {{ $booking->hotel->location }}
                                        </p>
                                    </div>
                                    <span style="background: {{ $statusColor }}20; color: {{ $statusColor }}; padding: 5px 14px; border-radius: var(--radius-pill); font-size: 0.8rem; font-weight: 700; white-space: nowrap;">
                                        {{ $statusLabel }}
                                    </span>
                                </div>

                                <div style="display: flex; gap: 24px; flex-wrap: wrap; margin-top: 12px;">
                                    <div>
                                        <p style="color: var(--color-gray); font-size: 0.8rem; margin-bottom: 2px;">Kode Booking</p>
                                        <p style="font-weight: 700; color: var(--color-primary); font-size: 0.95rem;">{{ $booking->booking_code }}</p>
                                    </div>
                                    <div>
                                        <p style="color: var(--color-gray); font-size: 0.8rem; margin-bottom: 2px;">Tanggal Bayar</p>
                                        <p style="font-weight: 600; font-size: 0.9rem;">{{ $booking->created_at->format('d M Y') }}</p>
                                    </div>
                                    <div>
                                        <p style="color: var(--color-gray); font-size: 0.8rem; margin-bottom: 2px;">Check-in → Check-out</p>
                                        <p style="font-weight: 600; font-size: 0.9rem;">
                                            {{ $booking->check_in->format('d M') }} → {{ $booking->check_out->format('d M Y') }}
                                        </p>
                                    </div>
                                    <div>
                                        <p style="color: var(--color-gray); font-size: 0.8rem; margin-bottom: 2px;">Metode</p>
                                        <p style="font-weight: 600; font-size: 0.9rem;">
                                            {{ $methodLabel['icon'] }} {{ $methodLabel['label'] }}
                                        </p>
                                    </div>
                                </div>

                                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 16px; padding-top: 16px; border-top: 1px solid var(--color-gray-light);">
                                    <div>
                                        <p style="color: var(--color-gray); font-size: 0.8rem;">Total Pembayaran</p>
                                        <p style="font-size: 1.5rem; font-weight: 700; color: var(--color-primary);">
                                            Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                        </p>
                                    </div>
                                    <a href="{{ route('payment.show', $booking->booking_code) }}"
                                       class="btn btn-outline"
                                       style="padding: 10px 20px; font-size: 0.875rem;">
                                        Lihat Detail →
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <div style="font-size: 4rem; margin-bottom: 16px;">💳</div>
                        <h3 style="font-size: 1.5rem; margin-bottom: 10px;">Belum ada transaksi</h3>
                        <p style="color: var(--color-gray); margin-bottom: 28px;">Mulai pesan hotel favoritmu sekarang!</p>
                        <a href="{{ route('hotels.search') }}" class="btn btn-primary">Cari Hotel</a>
                    </div>
                @endforelse

            </div>{{-- /main content --}}
        </div>{{-- /flex --}}
    </div>
</section>
@endsection
