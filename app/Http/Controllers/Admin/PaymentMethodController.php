<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $paymentMethods = PaymentMethod::all();
        return view('admin.payment_methods.index', compact('paymentMethods'));
    }

    public function create()
    {
        return view('admin.payment_methods.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
            'instructions' => 'nullable|string',
            'logo' => 'nullable|string|max:50',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        PaymentMethod::create($data);

        return redirect()->route('admin.payment_methods.index')
            ->with('success', 'Metode pembayaran berhasil ditambahkan.');
    }

    public function edit(PaymentMethod $paymentMethod)
    {
        return view('admin.payment_methods.edit', compact('paymentMethod'));
    }

    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
            'instructions' => 'nullable|string',
            'logo' => 'nullable|string|max:50',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        $paymentMethod->update($data);

        return redirect()->route('admin.payment_methods.index')
            ->with('success', 'Metode pembayaran berhasil diperbarui.');
    }

    public function destroy(PaymentMethod $paymentMethod)
    {
        $paymentMethod->delete();

        return redirect()->route('admin.payment_methods.index')
            ->with('success', 'Metode pembayaran berhasil dihapus.');
    }
}
