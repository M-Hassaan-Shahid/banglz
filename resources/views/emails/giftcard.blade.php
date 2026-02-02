<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Gift Card Email</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f9f9f9; padding: 20px; }
        .card { background: #fff; padding: 20px; border-radius: 8px; margin-bottom: 15px; border: 1px solid #eee; }
        .code { font-size: 20px; font-weight: bold; color: #2c3e50; }
        .amount { font-size: 16px; color: #27ae60; }
    </style>
</head>
<body>
    <h2>🎁 Your Gift Cards (Order {{ $orderId }})</h2>

    @foreach($cards as $card)
        <div class="card">
            <p class="code">Code: {{ $card->code }}</p>
            <p class="amount">Amount: {{ number_format($card->amount, 2) }}</p>
            <p>Status: {{ ucfirst($card->status) }}</p>
        </div>
    @endforeach

    <p><a href="{{ url('/') }}">Click here to redeem</a></p>

    <p>Thanks,<br>{{ config('app.name') }}</p>
</body>
</html>
