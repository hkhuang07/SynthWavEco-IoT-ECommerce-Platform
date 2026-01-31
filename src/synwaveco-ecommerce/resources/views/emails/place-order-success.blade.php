<x-mail::message>
# Order Confirmation - {{ config('app.name', 'GreenTech') }}

Hello {{ Auth::user()->name }}!

Thank you for placing your order with **{{ config('app.name', 'GreenTech') }}**. Your order has been successfully received and is being processed.

## Shipping Information:
**Phone:** {{ $order->shipping_phone ?? 'Not provided' }}  
**Shipping Address:** {{ $order->shipping_address ?? 'Not provided' }}  
**Order Date:** {{ $order->created_at->format('F j, Y g:i A') }}  
**Order ID:** #{{ $order->id }}

## Order Details:
<x-mail::table>
| # | Product | Qty | Unit Price | Total |
|:-----|:-------------------------------|:-----:|----------:|------------:|
@php $subtotal = 0; @endphp
@foreach($order->orderDetails as $detail)
| {{ $loop->iteration }} | {{ $detail->product->name ?? 'Product not found' }} | {{ $detail->quantity }} | ${{ number_format($detail->unit_price, 2) }} | ${{ number_format($detail->quantity * $detail->unit_price, 2) }} |
@php $subtotal += $detail->quantity * $detail->unit_price; @endphp
@endforeach
| | | | **Subtotal:** | **${{ number_format($subtotal, 2) }}** |
@if($order->shipping_fee > 0)
| | | | **Shipping:** | **${{ number_format($order->shipping_fee, 2) }}** |
@endif
@if($order->tax_amount > 0)
| | | | **Tax:** | **${{ number_format($order->tax_amount, 2) }}** |
@endif
| | | | **Grand Total:** | **${{ number_format($order->total_amount, 2) }}** |
</x-mail::table>

## Order Status Timeline:
<x-mail::table>
| Status | Date | Description |
|:-------|:-----|:------------|
| Order Placed | {{ $order->created_at->format('M j, Y g:i A') }} | Your order has been received |
| Processing | {{ $order->created_at->addMinutes(30)->format('M j, Y g:i A') }} | We are preparing your items |
| Shipped | {{ $order->estimated_ship_date ?? 'TBD' }} | Your order is on the way |
| Delivered | {{ $order->estimated_delivery_date ?? 'TBD' }} | Expected delivery date |
</x-mail::table>

## What's Next?
1. **Order Processing:** We'll prepare your items within 1-2 business days
2. **Shipping Notification:** You'll receive tracking information once shipped
3. **Delivery:** Your order will be delivered to the address provided
4. **Support:** Contact us if you have any questions about your order

## Customer Support:
- **Email:** support@greentech.com
- **Phone:** +84 (0) 296 xxxx xxx
- **Live Chat:** Available on our website

## Important Notes:
- Please keep this email for your records
- You can track your order status in your account dashboard
- Contact us immediately if you need to modify or cancel your order

Thank you for choosing **{{ config('app.name', 'GreenTech') }}** for your agricultural technology needs!

Best regards,  
**{{ config('app.name', 'GreenTech') }} Team**  
*Smart IoT Solutions for Modern Agriculture*

---

<x-mail::subcopy>
**Need to make changes to your order?**  
Visit your account dashboard or contact our customer service team immediately.

**Questions about delivery?**  
Track your order using the tracking number that will be sent to your email once shipped.

**Want to track other orders?**  
Log in to your account to view your complete order history and status updates.
</x-mail::subcopy>
</x-mail::message>