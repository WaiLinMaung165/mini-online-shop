<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Override;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OrdersExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Order::with(['user','orderItems.product','payment.paymentMethod'])
                   ->latest()
                   ->get();
    }

    #[Override]
    public function headings(): array
    {
        return [
            'Order Code',
            'Customer Name',
            'Customer Email',
            'Phone',
            'Shipping Address',
            'Purchased Items (Qty x Price)',
            'Total Amount ($)',
            'Payment Method',
            'Payment Status',
            'Order Status',
            'Order Date',
        ];
    }

    #[Override]
    public function map($order): array
    {
        $itemsList = $order->orderItems->map(function ($item) {
            $productName = $item->product->name ?? 'Product Deleted';
            return "• {$productName} (Qty: {$item->quantity} | Price: $" . number_format($item->price, 2) . ")";
        })->implode("\n");

        return [
            $order->order_code,
            $order->user->name ?? 'Guest',
            $order->user->email ?? 'N/A',
            $order->phone,
            $order->shipping_address,
            $itemsList,
            number_format($order->total_amount, 2),
            $order->payment->paymentMethod->name ?? 'N/A',
            $order->payment->status ?? 'N/A',
            $order->status,
            $order->created_at->format('d M Y, h:i A'),
        ];
    }
}
