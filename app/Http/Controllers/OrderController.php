<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::query();

        // Date range filter
        if ($from = $request->input('from_date')) {
            $query->where('order_date', '>=', $from);
        }
        if ($to = $request->input('to_date')) {
            $query->where('order_date', '<=', $to);
        }

        //Category filter
        if ($category = $request->input('category')) {
            $query->where('item_category', $category);
        }

        // Source filter
        if ($source = $request->input('source')) {
            $query->where('source', $source);
        }

        // Location filter
        if ($geo = $request->input('geo')) {
            $query->where('geo_location', $geo);
        }
        // Search filter
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('customer', 'like', "%{$search}%")
                    ->orWhere('item_category', 'like', "%{$search}%")
                    ->orWhere('geo_location', 'like', "%{$search}%");
            });
        }

        $page  = (int) $request->input('page', 1);
        $limit = (int) $request->input('limit', 10);

        $total = $query->count();

        $orders = $query
            ->orderBy('id', 'desc')
            ->skip(($page - 1) * $limit)
            ->take($limit)
            ->get()
            ->map(function ($order) {
                return [
                    'id'       => $order->id,
                    'customer' => $order->customer,
                    'category' => $order->item_category, // rename
                    'date'     => $order->order_date,
                    'source'   => $order->source,
                    'geo'      => $order->geo_location,
                ];
            });

        return response()->json([
            'data' => $orders,
            'total' => $total,
            'page' => $page,
            'limit' => $limit,
        ]);
    }

    public function locations()
    {
        $locations = ['New York', 'Los Angeles', 'Chicago', 'Houston', 'Miami', 'San Francisco', 'Dallas'];
        return response()->json($locations);
    }

    public function summary(Request $request)
    {
       $query = Order::query();

        if ($search = $request->input('search')) {
            $query->where(function ($x) use ($search) {
                $x->where('customer', 'like', "%{$search}%")
                    ->orWhere('item_category', 'like', "%{$search}%")
                    ->orWhere('geo_location', 'like', "%{$search}%");
            });
        }
        if ($from = $request->input('from_date')) $query->where('order_date', '>=', $from);
        if ($to   = $request->input('to_date'))   $query->where('order_date', '<=', $to);
        if ($cat  = $request->input('category'))  $query->where('item_category', $cat);
        if ($src  = $request->input('source'))    $query->where('source', $src);
        if ($geo  = $request->input('geo'))       $query->where('geo_location', $geo);

        // Clone base query for each aggregation to preserve filters
        $byCategory = (clone $query)
            ->selectRaw('item_category as name, COUNT(*) as count')
            ->groupBy('item_category')
            ->orderByDesc('count')
            ->get();

        $byDate = (clone $query)
            ->selectRaw('DATE(order_date) as date, COUNT(*) as count')
            ->groupByRaw('DATE(order_date)')
            ->orderBy('date')
            ->get();

        $bySource = (clone $query)
            ->selectRaw('source as name, COUNT(*) as count')
            ->groupBy('source')
            ->orderByDesc('count')
            ->get();

        $byGeo = (clone $query)
            ->selectRaw('geo_location as name, COUNT(*) as count')
            ->groupBy('geo_location')
            ->orderByDesc('count')
            ->get();

        return response()->json([
            'byCategory' => $byCategory,
            'byDate'     => $byDate,
            'bySource'   => $bySource,
            'byGeo'      => $byGeo,
        ]);
    }
}
