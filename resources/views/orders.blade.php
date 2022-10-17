@extends('layouts.app')
@section('content')

    <div class="container">
        <?php $total=0; ?>
        @forelse($orders as $order)
            <?php $total += $order['price'];?>
            <div class="proditem">
                <div class="prodimage">
                    <img src="{{ asset('/images/'.$order->image) }}">
                </div>
            </div>
            <ul>
                <li>{{ ucfirst($order->user_name) }}</li>
                <li>{{ ucfirst($order->details) }}</li>
                <li>{{ ucfirst($order->price) }}</li>
                <li>{{ ucfirst($order->image) }}</li>
                <div class="removebutton">
                    <a href="{{ route('deleteProduct',['id' => $order->id])  }}"  name="remove">Remove Product</a>
                </div>
            </ul>
        @empty
        @endforelse
    </div>
@endsection
