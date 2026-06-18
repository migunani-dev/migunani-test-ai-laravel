<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::latest()->get();
        return view('customerview', compact('customers'));
    }

    public function search(Request $request)
    {
        $keyword = $request->input('search');
        $customer = Customer::where('userId', $keyword)->first();

        if ($customer) {
            return redirect('/transaction')->with([
                'customerId'       => $customer->userId,
                'customerName'     => $customer->nama,
                'customerAddress'  => $customer->alamat,
                'customerProvince' => $customer->provinsi,
                'customerCity'     => $customer->kota,
            ]);
        }

        return redirect()->back()->with('error', 'Customer tidak ditemukan.');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'userId'   => 'required|unique:customers',
            'nama'     => 'required',
            'alamat'   => 'required',
            'provinsi' => 'required',
            'kota'     => 'required',
        ]);

        Customer::create($validated);
        return redirect()->back()->with('success', 'Customer berhasil ditambahkan.');
    }
}
