@extends('layouts.app')

@section('title', 'Order ' . $order->order_number)

@section('content')
<div class="container" style="padding-top:3rem; padding-bottom:5rem;">

    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('orders.index') }}"
           style="font-size:12px; color:var(--noctra-gray); letter-spacing:.06em; text-transform:uppercase;">
            ← Orders
        </a>
        <span style="color:var(--noctra-border);">›</span>
        <p style="font-size:13px; font-weight:700; color:var(--noctra-white); margin:0;">
            {{ $order->order_number }}
        </p>
    </div>

    <div class="row g-4">

        {{-- Order Items --}}
        <div class="col-lg-8">

            {{-- Status Banner --}}
            <div style="padding:1rem 1.25rem; margin-bottom:1.5rem;
                        background:var(--noctra-card); border:1px solid var(--noctra-border);
                        display:flex; align-items:center; justify-content:space-between;">
                <div>
                    <p class="noctra-label mb-1">Order Status</p>
                    <span class="badge-status badge-{{ str_replace(['_',' '],'-',$order->status) }}"
                          style="font-size:12px; padding:5px 12px;">
                        {{ $order->status_label }}
                    </span>
                </div>
                @if($order->payment && $order->payment->snap_token && $order->status === 'pending')
                <button id="payBtn" class="btn-noctra"
                        style="font-size:11px; padding:.6rem 1.25rem;">
                    Pay Now
                </button>
                @endif
            </div>

            {{-- Items --}}
            <div style="background:var(--noctra-card); border:1px solid var(--noctra-border);
                        padding:1.5rem; margin-bottom:1rem;">
                <h4 style="font-size:13px; font-weight:800; letter-spacing:.08em;
                           text-transform:uppercase; margin-bottom:1.25rem;">
                    Items Ordered
                </h4>
                @foreach($order->items as $item)
                <div style="display:flex; gap:1rem; padding-bottom:1rem;
                            border-bottom:1px solid var(--noctra-border);
                            margin-bottom:1rem; align-items:center;">
                    <div style="width:70px; height:85px; background:var(--noctra-muted);
                                overflow:hidden; flex-shrink:0;">
                        @if($item->product && $item->product->primaryImage)
                        <img src="{{ asset('storage/' . $item->product->primaryImage->image_path) }}"
                             alt="{{ $item->product_name }}"
                             style="width:100%; height:100%; object-fit:cover;">
                        @endif
                    </div>
                    <div style="flex:1;">
                        <p style="font-size:14px; font-weight:700; color:var(--noctra-white); margin:0 0 .25rem;">
                            {{ $item->product_name }}
                        </p>
                        <p style="font-size:12px; color:var(--noctra-gray); margin:0;">
                            Size: {{ $item->size ?? '-' }} · Qty: {{ $item->quantity }}
                        </p>
                    </div>
                    <div style="text-align:right; flex-shrink:0;">
                        <p style="font-size:14px; font-weight:800; color:var(--noctra-white); margin:0;">
                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                        </p>
                        <p style="font-size:12px; color:var(--noctra-gray); margin:0;">
                            @Rp {{ number_format($item->price, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Shipping Address --}}
            @if($order->shippingAddress)
            <div style="background:var(--noctra-card); border:1px solid var(--noctra-border); padding:1.5rem;">
                <h4 style="font-size:13px; font-weight:800; letter-spacing:.08em;
                           text-transform:uppercase; margin-bottom:1rem;">
                    Shipping Address
                </h4>
                <p style="font-size:14px; font-weight:700; color:var(--noctra-white); margin:0 0 .25rem;">
                    {{ $order->shippingAddress->recipient_name }}
                </p>
                <p style="font-size:13px; color:var(--noctra-silver); margin:0 0 .25rem;">
                    {{ $order->shippingAddress->phone }}
                </p>
                <p style="font-size:13px; color:var(--noctra-silver); margin:0; line-height:1.7;">
                    {{ $order->shippingAddress->full_address }}
                </p>
            </div>
            @endif
        </div>

        {{-- Summary --}}
        <div class="col-lg-4">
            <div style="background:var(--noctra-card); border:1px solid var(--noctra-border);
                        padding:1.5rem; position:sticky; top:5rem;">
                <h4 style="font-size:13px; font-weight:800; letter-spacing:.08em;
                           text-transform:uppercase; margin-bottom:1.25rem;">
                    Payment Summary
                </h4>

                <div style="display:flex; justify-content:space-between; margin-bottom:.75rem;">
                    <span style="font-size:13px; color:var(--noctra-gray);">Subtotal</span>
                    <span style="font-size:13px; color:var(--noctra-white); font-weight:600;">
                        Rp {{ number_format($order->subtotal, 0, ',', '.') }}
                    </span>
                </div>
                <div style="display:flex; justify-content:space-between; margin-bottom:.75rem;">
                    <span style="font-size:13px; color:var(--noctra-gray);">
                        Shipping ({{ strtoupper($order->courier ?? '-') }})
                    </span>
                    <span style="font-size:13px; color:var(--noctra-white); font-weight:600;">
                        Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}
                    </span>
                </div>

                <hr style="border-color:var(--noctra-border); margin:1rem 0;">

                <div style="display:flex; justify-content:space-between; margin-bottom:1.5rem;">
                    <span style="font-size:14px; font-weight:700; color:var(--noctra-white);">Total</span>
                    <span style="font-size:18px; font-weight:900; color:var(--noctra-white);">
                        {{ $order->formatted_total }}
                    </span>
                </div>

                @if($order->payment)
                <div style="padding:.875rem; background:rgba(255,255,255,.03);
                            border:1px solid var(--noctra-border);">
                    <p class="noctra-label mb-2">Payment</p>
                    <p style="font-size:13px; color:var(--noctra-silver); margin:0 0 .25rem;">
                        Method: {{ strtoupper($order->payment->payment_type ?? 'Pending') }}
                    </p>
                    <p style="font-size:13px; margin:0;">
                        Status: <span class="badge-status badge-{{ $order->payment->status }}">
                            {{ $order->payment->status_label }}
                        </span>
                    </p>
                </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
@if($order->payment && $order->payment->snap_token && $order->status === 'pending')
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
document.getElementById('payBtn')?.addEventListener('click', function() {
    snap.pay('{{ $order->payment->snap_token }}', {
        onSuccess: function(result) {
            window.location.reload();
        },
        onPending: function(result) {
            window.location.reload();
        },
        onError: function(result) {
            alert('Pembayaran gagal. Silakan coba lagi.');
        },
        onClose: function() {
            console.log('Payment popup closed.');
        }
    });
});
</script>
@endif
@endpush