@extends('layouts.email')

@section('title', $title)

@section('style')
    <style>
        /* Add your custom CSS styles here to enhance the email design */
        /* For example, you can style the container, product list, and individual product elements */
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }

        h1 {
            color: #333333;
            text-align: center;
            margin-top: 0;
        }

        p {
            color: #666666;
            line-height: 1.6;
        }

        ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        li {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .product-image {
            flex: 0 0 100px;
            margin-right: 20px;
        }

        .product-image img {
            max-width: 100%;
        }

        .product-details {
            flex: 1;
        }

        .product-title {
            font-weight: bold;
            margin: 0 0 5px;
        }

        .product-price {
            margin: 0;
        }

        .product-discount {
            color: #999999;
            margin: 0;
        }

        .checkout-button {
            display: block;
            text-align: center;
            margin-top: 20px;
            background-color: #ff6600;
            color: #ffffff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
        }

        .checkout-button:hover {
            background-color: #e65c00;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <h1>Checkout Your Cart Now</h1>

        <p>Dear Customer,</p>

        <p>It looks like you left some items in your cart. Don't miss out on these great products! Here is a list of the items you selected:</p>

        <ul>
            @foreach($products as $product)
                <li>
                    <div class="product-image">
                        <img src="{{ $product['thumbnail'] }}" alt="{{ $product['title'] }}">
                    </div>
                    <div class="product-details">
                        <h3 class="product-title">{{ $product['title'] }}</h3>
                        <p class="product-price">Price: ${{ $product['price'] }}</p>
                        <p class="product-discount">Discount: {{ $product['discount'] }}%</p>
                    </div>
                </li>
            @endforeach
        </ul>

        <p>Click on the button below to quickly complete your purchase:</p>

        <a href="#" class="checkout-button">Complete Checkout</a>

        <p>Thank you for choosing our ecommerce platform!</p>

        <p>Sincerely,</p>
        <p>Your Ecommerce Team</p>
    </div>
@endsection
