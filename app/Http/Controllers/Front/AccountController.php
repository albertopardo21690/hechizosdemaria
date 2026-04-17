<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Lunar\Models\Order;

class AccountController extends Controller
{
    public function showLogin()
    {
        if (Auth::guard('customer')->check()) {
            return redirect()->route('account.dashboard');
        }

        return view('front.account.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('customer')->attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('account.dashboard'));
        }

        return back()->withErrors(['email' => 'Credenciales incorrectas.'])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('front.account.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $customer = Customer::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        Auth::guard('customer')->login($customer);

        return redirect()->route('account.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    public function dashboard()
    {
        $customer = Auth::guard('customer')->user();
        $orders = Order::where('meta->customer_email', $customer->email)
            ->orderByDesc('placed_at')
            ->limit(10)
            ->get();

        return view('front.account.dashboard', compact('customer', 'orders'));
    }

    public function orders()
    {
        $customer = Auth::guard('customer')->user();
        $orders = Order::where('meta->customer_email', $customer->email)
            ->orderByDesc('placed_at')
            ->paginate(15);

        return view('front.account.orders', compact('customer', 'orders'));
    }

    public function orderDetail(string $reference)
    {
        $customer = Auth::guard('customer')->user();
        $order = Order::where('reference', $reference)
            ->where('meta->customer_email', $customer->email)
            ->firstOrFail();

        return view('front.account.order-detail', compact('customer', 'order'));
    }

    public function profile()
    {
        $customer = Auth::guard('customer')->user();

        return view('front.account.profile', compact('customer'));
    }

    public function updateProfile(Request $request)
    {
        $customer = Auth::guard('customer')->user();
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:40',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'postcode' => 'nullable|string|max:20',
        ]);
        $customer->update($data);

        return back()->with('status', 'Perfil actualizado.');
    }
}
