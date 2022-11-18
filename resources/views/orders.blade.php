@extends('layouts.app')
@section('content')

    <h1>{{ __('Orders') }}</h1>
    <div class="container">
        @forelse($orders as $order)
            <h2>{{ __('Order nr') }}</h2>
            <ul>
                <li>{{ $order->user_name }}</li>
                <li>{{ $order->details }}</li>
                <li>{{ $order->price }}</li>

                <a href="{{ route('order.show', $order->id) }}">{{ __('View Order') }}</a>
            </ul>
        @empty
            <p>{{ __('There are no orders') }}</p>
        @endforelse
    </div>

@endsection
