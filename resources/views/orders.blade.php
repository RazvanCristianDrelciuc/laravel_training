@extends('layouts.app')
@section('content')

    <h1>Orders</h1>
    <div class="container">
        <?php $total=0; ?>
        @forelse($orders as $order)
            <?php $total += $order['price'];?>
            <ul>
                <li>{{ ucfirst($order->user_name) }}</li>
                <li>{{ ucfirst($order->details) }}</li>
                <li>{{ ucfirst($order->price) }}</li>
                <div class="removebutton">
                    <a href="{{ route('order',['order' => $order->id])  }}"  name="remove">View Order</a>
                </div>
            </ul>
        @empty
        @endforelse
    </div>

@endsection
