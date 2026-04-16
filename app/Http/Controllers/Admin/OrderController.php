<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lunar\Models\Order;

class OrderController extends Controller
{
    protected array $statuses = [
        'awaiting-payment' => 'Pendiente pago',
        'payment-offline' => 'Pago offline',
        'payment-received' => 'Pagado',
        'dispatched' => 'Enviado',
        'cancelled' => 'Cancelado',
        'refunded' => 'Reembolsado',
    ];

    public function index(Request $request)
    {
        $q = $request->string('q')->toString();
        $status = $request->string('status')->toString();

        $query = Order::query()->with('customer');

        if ($q) {
            $query->where(function ($qq) use ($q) {
                $qq->where('reference', 'like', "%{$q}%")
                   ->orWhereHas('customer', fn ($c) => $c->where('first_name', 'like', "%{$q}%")->orWhere('last_name', 'like', "%{$q}%"));
            });
        }
        if ($status) {
            $query->where('status', $status);
        }

        $orders = $query->orderByDesc('placed_at')->paginate(30)->withQueryString();

        return view('admin.orders.index', [
            'orders' => $orders,
            'statuses' => $this->statuses,
            'q' => $q,
            'status' => $status,
        ]);
    }

    public function show(Order $order)
    {
        $order->load(['lines.purchasable.product.media', 'billingAddress', 'shippingAddress', 'customer']);

        return view('admin.orders.show', [
            'order' => $order,
            'statuses' => $this->statuses,
        ]);
    }

    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => 'required|in:'.implode(',', array_keys($this->statuses)),
        ]);
        $order->update($data);

        return back()->with('status', 'Estado actualizado a '.$this->statuses[$data['status']]);
    }
}
