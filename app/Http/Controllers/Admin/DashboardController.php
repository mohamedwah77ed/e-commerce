<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\Products;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $startDate = Carbon::today()->subDays(6)->startOfDay();
        $endDate   = Carbon::today()->endOfDay();

        $usersData  = $this->getChartData('user',  $startDate, $endDate);
        $adminsData = $this->getChartData('admin', $startDate, $endDate);

        return view('backend.dashboard', [
            'labels'           => $usersData['labels'],
            'usersData'        => $usersData['data'],
            'adminsData'       => $adminsData['data'],
            'totalUsers'       => $this->totalUsers(),
            'totalAdmins'      => $this->totalAdmins(),
            'newUsersToday'    => $this->newUsersToday(),
            'users'            => $this->getUsers($request),

            // Real counts from database
            'usersCount'       => $this->totalUsers(),
            'ordersCount'      => $this->totalOrders(),
            'productsCount'    => Products::count(),
            'revenue'          => $this->totalRevenue(),
            'pendingOrders'    => $this->pendingOrders(),
            'paidOrdersCount'  => $this->paidOrdersCount(),
        ]);
    }

    // ───────────────────────────────────────────
    // Users
    // ───────────────────────────────────────────

    private function totalUsers(): int
    {
        return User::where('role', 'user')->count();
    }

    private function totalAdmins(): int
    {
        return User::where('role', 'admin')->count();
    }

    private function newUsersToday(): int
    {
        return User::where('role', 'user')
            ->whereDate('created_at', Carbon::today())
            ->count();
    }

    private function getUsers(Request $request)
    {
        $query = User::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($role = $request->input('role')) {
            $query->where('role', $role);
        }

        return $query->latest()->paginate(15)->withQueryString();
    }

    // ───────────────────────────────────────────
    // Orders & Revenue
    // ───────────────────────────────────────────

    /**
     */
    private function totalOrders(): int
    {
        return Order::count();
    }

    /**
     */
    private function paidOrdersCount(): int
    {
        return Order::where('status', 'paid')
                    ->orWhere('payment_status', 'paid')
                    ->count();
    }

    /**
     */
    private function pendingOrders(): int
    {
        return Order::where(function ($query) {
                $query->where('status', 'pending')
                      ->orWhere('status', 'unpaid')
                      ->orWhere('payment_status', 'pending')
                      ->orWhere('payment_status', 'unpaid');
            })
            ->count();
    }

    /**
     */
    private function totalRevenue(): float
    {
        return Order::where(function ($query) {
                $query->where('status', 'paid')
                      ->orWhere('payment_status', 'paid');
            })
            ->sum('total_amount') ?? 0;
    }

    // ───────────────────────────────────────────
    // Chart Data
    // ───────────────────────────────────────────

    private function getChartData($role, $startDate, $endDate): array
    {
        $rows = User::where('role', $role)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date');

        $labels = [];
        $data   = [];

        for ($i = 6; $i >= 0; $i--) {
            $date     = Carbon::today()->subDays($i)->toDateString();
            $labels[] = Carbon::parse($date)->format('M d');
            $data[]   = (int) ($rows[$date] ?? 0);
        }

        return compact('labels', 'data');
    }
}
