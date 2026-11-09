<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalUsers = User::count();
        $totalSales = Order::where('status', 'Completed')->sum('total_amount');

        $filter = $request->get('filter', 'monthly');
        $chartLabels = [];
        $chartData = [];

        if ($filter == 'daily') {
            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i);
                $chartLabels[] = $date->format('D (d M)');
                $chartData[] = Order::whereDate('created_at', $date->toDateString())
                    ->where('status', '!=', 'Cancelled')
                    ->sum('total_amount');
            }
        } elseif ($filter == 'weekly') {
            for ($i = 3; $i >= 0; $i--) {
                $startOfWeek = Carbon::now()->subWeeks($i)->startOfWeek();
                $endOfWeek = Carbon::now()->subWeeks($i)->endOfWeek();
                $chartLabels[] = 'Week ' . (4 - $i);
                $chartData[] = Order::whereBetween('created_at', [$startOfWeek, $endOfWeek])
                    ->where('status', '!=', 'Cancelled')
                    ->sum('total_amount');
            }
        } elseif ($filter == 'yearly') {
            for ($i = 4; $i >= 0; $i--) {
                $year = Carbon::now()->subYears($i)->year;
                $chartLabels[] = (string) $year;
                $chartData[] = Order::whereYear('created_at', $year)
                    ->where('status', '!=', 'Cancelled')
                    ->sum('total_amount');
            }
        } else {
            $chartLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            for ($m = 1; $m <= 12; $m++) {
                $chartData[] = Order::whereYear('created_at', Carbon::now()->year)
                    ->whereMonth('created_at', $m)
                    ->where('status', '!=', 'Cancelled')
                    ->sum('total_amount');
            }
        }

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalOrders',
            'totalUsers',
            'totalSales',
            'chartLabels',
            'chartData',
            'filter'
        ));
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
    public function show(string $id)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
