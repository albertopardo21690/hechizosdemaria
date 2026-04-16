<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lunar\Models\Customer;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->string('q')->toString();

        $query = Customer::query()->withCount('orders');

        if ($q) {
            $query->where(function ($qq) use ($q) {
                $qq->where('first_name', 'like', "%{$q}%")
                   ->orWhere('last_name', 'like', "%{$q}%")
                   ->orWhere('account_ref', 'like', "%{$q}%")
                   ->orWhereRaw("JSON_EXTRACT(meta, '$.email') LIKE ?", ['%'.$q.'%']);
            });
        }

        $customers = $query->orderByDesc('id')->paginate(30)->withQueryString();

        return view('admin.customers.index', compact('customers', 'q'));
    }

    public function show(Customer $customer)
    {
        $customer->load(['orders' => fn ($q) => $q->latest('placed_at')]);

        return view('admin.customers.show', compact('customer'));
    }
}
