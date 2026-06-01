@extends('layouts.app')

@section('title', 'Checkout | ' . $hotel->name)

@push('styles')
<style>
.checkout-shell {
    display: grid;
    grid-template-columns: minmax(0, 1.2fr) minmax(320px, 420px);
    gap: 32px;
}
.checkout-card {
    background: var(--color-card-bg);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-soft);
    padding: 32px;
}
.field-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 16px;
}
.checkout-input,
.checkout-select,
.checkout-textarea {
    width: 100%;
    padding: 12px 14px;
    border: 1px solid var(--color-gray-light);
    border-radius: var(--radius-sm);
    background: var(--color-bg);
    font-family: var(--font-body);
    font-size: 1rem;
    color: var(--color-dark);
}
.checkout-textarea {
    min-height: 120px;
    resize: vertical;
}
.helper-chip {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 12px;
    border-radius: var(--radius-pill);
    background: rgba(13, 110, 110, 0.08);
    color: var(--color-primary);
    font-weight: 600;
    font-size: 0.875rem;
}
.payment-option-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 12px;
}
.payment-option {
    border: 1px solid var(--color-gray-light);
    border-radius: var(--radius-md);
    padding: 14px;
    background: var(--color-bg);
    cursor: pointer;
}
.payment-option input {
    margin-right: 8px;
}
.payment-option img {
    width: 24px;
    height: 24px;
    vertical-align: middle;
    margin-right: 8px;
}
@media (max-width: 980px) {
    .checkout-shell { grid-template-columns: 1fr; }
}
@media (max-width: 640px) {
    .field-grid,
    .payment-option-grid { grid-template-columns: 1fr; }
}
</style>
@endpush

@section('content')
<section style="padding: 56px 0 80px;">
    <div class="container">
        <div style="margin-bottom: 24px;">
            <a href="{{ route('hotels.show', $hotel->id) }}" style="color: var(--color-primary); font-weight: 600;">← Kembali ke detail hotel</a>
        </div>

        <div class="checkout-shell">
            <div class="checkout-card">
                <div style="margin-bottom: 24px;">
                    <div class="helper-chip">1 kamar • maksimal {{ $maxGuests }} tamu</div>
                    <h1 style="font-size: 2rem; margin: 14px 0 8px;">Booking Detail</h1>
                    <p style="color: var(--color-gray);">Isi nama dan biodata tamu, lalu pilih pembayaran GoPay atau DANA.</p>
                </div>

                <form action="{{ route('checkout.process') }}" method="POST" style="display: grid; gap: 20px;">
                    @csrf
                    <input type="hidden" name="hotel_id" value="{{ $hotel->id }}">

                    <div class="field-grid">
                        <div>
                            <label for="guest_name" style="display:block; margin-bottom:8px; font-weight:600;">Nama Pemesan</label>
                            <input id="guest_name" name="guest_name" class="checkout-input" value="{{ old('guest_name', auth()->user()->name) }}" required>
                        </div>
                        <div>
                            <label for="guests" style="display:block; margin-bottom:8px; font-weight:600;">Jumlah Tamu</label>
                            <select id="guests" name="guests" class="checkout-select" required>
                                @for($i = 1; $i <= $maxGuests; $i++)
                                    <option value="{{ $i }}" {{ old('guests', 1) == $i ? 'selected' : '' }}>{{ $i }} tamu</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="guest_bio" style="display:block; margin-bottom:8px; font-weight:600;">Nama & Biodata Tamu</label>
                        <textarea id="guest_bio" name="guest_bio" class="checkout-textarea" placeholder="Contoh: Rani, 28 tahun, Jakarta, tujuan staycation dan business trip." required>{{ old('guest_bio') }}</textarea>
                    </div>

                    <div class="field-grid">
                        <div>
                            <label for="check_in" style="display:block; margin-bottom:8px; font-weight:600;">Check-in</label>
                            <input type="date" id="check_in" name="check_in" class="checkout-input" value="{{ old('check_in') }}" required>
                        </div>
                        <div>
                            <label for="check_out" style="display:block; margin-bottom:8px; font-weight:600;">Check-out</label>
                            <input type="date" id="check_out" name="check_out" class="checkout-input" value="{{ old('check_out') }}" required>
                        </div>
                    </div>

                    <div class="field-grid">
                        <div>
                            <label for="room_type" style="display:block; margin-bottom:8px; font-weight:600;">Tipe Kamar</label>
                            <select id="room_type" name="room_type" class="checkout-select" required>
                                <option value="Standard Room" {{ old('room_type') == 'Standard Room' ? 'selected' : '' }}>Standard Room</option>
                                <option value="Deluxe Room" {{ old('room_type') == 'Deluxe Room' ? 'selected' : '' }}>Deluxe Room</option>
                                <option value="Suite Room" {{ old('room_type') == 'Suite Room' ? 'selected' : '' }}>Suite Room</option>
                            </select>
                        </div>
                        <div>
                            <label for="special_requests" style="display:block; margin-bottom:8px; font-weight:600;">Catatan Tambahan</label>
                            <input id="special_requests" name="special_requests" class="checkout-input" value="{{ old('special_requests') }}" placeholder="Misalnya late check-in atau preferensi kamar">
                        </div>
                    </div>

                    <div>
                        <label style="display:block; margin-bottom:10px; font-weight:600;">Metode Pembayaran</label>
                        <div class="payment-option-grid">
                            @foreach($paymentMethods as $key => $pm)
                                <label class="payment-option">
                                    <input type="radio" name="payment_method" value="{{ $key }}" {{ old('payment_method', $defaultPayment) === $key ? 'checked' : '' }}>
                                    <img src="{{ asset($pm['file']) }}" alt="{{ $pm['label'] }}" onerror="this.src='{{ asset(str_replace('.svg', '.png', $pm['file'])) }}'">
                                    {{ $pm['label'] }}
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary" style="padding: 16px; font-size: 1.05rem;">
                        Book Now
                    </button>
                </form>
            </div>

            <aside class="checkout-card" style="position: sticky; top: 100px; height: fit-content;">
                <div style="display:flex; gap:16px; margin-bottom:24px; align-items:center;">
                    <img src="{{ asset('images/' . $hotel->image) }}" alt="{{ $hotel->name }}" style="width:96px; height:96px; object-fit:cover; border-radius: var(--radius-md);">
                    <div>
                        <h2 style="font-size: 1.35rem; margin-bottom: 6px;">{{ $hotel->name }}</h2>
                        <p style="color: var(--color-gray); font-size: 0.9rem; margin-bottom: 6px;">📍 {{ $hotel->location }}</p>
                        <p style="font-weight: 700; color: var(--color-primary); font-size: 1.15rem;">Rp {{ number_format($hotel->discounted_price, 0, ',', '.') }} / night</p>
                    </div>
                </div>

                <div style="padding: 18px; background: var(--color-bg); border-radius: var(--radius-md); margin-bottom: 20px;">
                    <div style="display:flex; justify-content:space-between; margin-bottom:10px;">
                        <span style="color: var(--color-gray);">Max tamu</span>
                        <strong>{{ $hotel->max_guests }}</strong>
                    </div>
                    <div style="display:flex; justify-content:space-between; margin-bottom:10px;">
                        <span style="color: var(--color-gray);">Kamar</span>
                        <strong>1 kamar</strong>
                    </div>
                    <div style="display:flex; justify-content:space-between;">
                        <span style="color: var(--color-gray);">Harga dasar</span>
                        <strong>Rp {{ number_format($hotel->price, 0, ',', '.') }} / night</strong>
                    </div>
                </div>

                <p style="color: var(--color-gray); line-height: 1.7; font-size: 0.95rem;">
                    Pembayaran akan diproses setelah data booking dikirim. Gunakan GoPay atau DANA untuk menyelesaikan transaksi.
                </p>
            </aside>
        </div>
    </div>
</section>
@endsection