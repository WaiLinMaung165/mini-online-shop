<?php

namespace App\Http\Controllers\Admin;

use App\Exports\OrdersExport;
use App\Http\Controllers\Controller;
use App\Mail\SendInvoiceMail;
use App\Models\Inventory;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class OrderStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with('user', 'orderItems.product', 'payment.paymentMethod')
            ->latest()
            ->paginate(7);
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load('user', 'orderItems.product', 'payment.paymentMethod');
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {

        $request->validate([
            'status' => 'required|in:Pending,Approved,Shipped,Completed,Cancelled'
        ]);

        $oldStatus = $order->status;
        $newStatus = $request->status;

        DB::transaction(function () use ($order, $oldStatus, $newStatus) {

            if ($oldStatus !== 'Cancelled' && $newStatus === 'Cancelled') {
                foreach ($order->orderItems as $item) {
                    $inventory = Inventory::where('product_id', $item->product_id)->first();
                    if ($inventory) {
                        $inventory->increment('stock_quantity', $item->quantity);
                    }
                }
            }

            if ($oldStatus === 'Cancelled' && $newStatus !== 'Cancelled') {
                foreach ($order->orderItems as $item) {
                    $inventory = Inventory::where('product_id', $item->product_id)->first();
                    if ($inventory) {
                        $inventory->decrement('stock_quantity', $item->quantity);
                    }
                }
            }

            // Order Status Update
            $order->update([
                'status' => $newStatus
            ]);

            // Payment status
            if ($order->payment) {
                if ($newStatus === 'Approved' || $newStatus === 'Completed') {
                    $order->payment->update(['status' => 'Approved']);
                } elseif ($newStatus === 'Cancelled') {
                    $order->payment->update(['status' => 'Cancelled']);
                } else {
                    $order->payment->update(['status' => 'Pending']);
                }
            }
        });

        if ($order->status == 'Approved' && $order->user && $order->user->email) {
    try {
        Mail::to($order->user->email)->send(new SendInvoiceMail($order));
    } catch (\Exception $e) {
        Log::error('Invoice Email sending failed for order ' . $order->order_code . ': ' . $e->getMessage());
    }
}

        return redirect()->back()->with('success', 'Order status updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function exportExcel(){
        return Excel::download(new OrdersExport, 'customer_orders_' . now()->format('Y_m_d_His') . '.xlsx');
    }
}
