@extends('pdfs.layout')

<!-- Document title -->
@section('title')
<span style="color: rgb(28, 118, 220); font-size: 18px; font-weight: bold;">
    {{ $product->title }}
</span>
@endsection

<!-- Barcode -->
@section('barcode')
    {!! DNS2D::getBarcodeHtml($product->id, 'QRCODE', 3, 3) !!}
@endsection

<!-- Content -->
@section('content')
    <div style="margin-top: 15px">
        <p>
            <strong>{{ __('pdf.number') }}</strong>
            {{ $product->number }}
        </p>
        <p>
            <strong>{{ __('pdf.name') }}</strong>
            {{ $product->name }}
        </p>
        <p>
            <strong>{{ __('pdf.buy_price') }}</strong>
            {{ formatMoney($product->buy_price, $settings['default_currency']) }}
        </p>
        <p>
            <strong>{{ __('pdf.sell_price') }}</strong>
            {{ formatMoney($product->sell_price, $settings['default_currency']) }}
        </p>
        <p>
        <strong>{{ __('pdf.product_type') }}</strong>
            {{ $product->type == 'service' ? __('pdf.service') : __('pdf.product') }}
        </p>

        <p>
            <strong>{{ __('pdf.stock') }}</strong>
            @if ($product->type == 'service' || $product->type == null)
                N/A
            @else
                {{ $product->stock }} {{ $product->unit }}
            @endif
        </p>

        <p>
            <strong>{{ __('pdf.stock_status') }}</strong>
            @if ($product->stock_status == null)
                N/A
            @else
                {{ __('pdf.' . $product->stock_status) }}
            @endif
        </p>

        @if ($product->category)
            <p>
                <strong>{{ __('pdf.category') }}</strong>
                {{ $product->category->name }}
            </p>
        @endif

        <p>
            <strong>{{ __('pdf.tax') }}</strong>
            {{ $product->tax }}%
        </p>
</div>

    <!-- Product Content -->
    <div style="margin-top: 15px">
        <strong>{{ __('pdf.description') }}</strong>
    </div>
    <div style="margin-top: 5px">
        {!! $product->description !!}
    </div>

    <!-- Product barcode -->
    <div>
        <strong style="margin-top: 15px; display: block;">{{ __('pdf.barcode') }}</strong>
        <div style="margin-top: 5px;">
            {!! DNS1D::getBarcodeHTML($product->barcode, 'C128', 2, 60) !!}
            <p>{{ $product->barcode }}</p>
        </div>
    </div>

@endsection
