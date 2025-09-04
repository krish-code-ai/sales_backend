<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // List all customers
    public function index()
    {
        return response()->json(Customer::all());
    }

    // Create a new customer
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
        ]);

        $customer = Customer::create($validated);
        return response()->json($customer, 201);
    }

    // Show a single customer
    public function show($id)
    {
        $customer = Customer::findOrFail($id);
        return response()->json($customer);
    }

    // Update a customer
    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
        ]);

        $customer->update($validated);
        return response()->json($customer);
    }

    // Delete a customer
    public function destroy($id)
    {
        Customer::findOrFail($id)->delete();
        return response()->json(['message' => 'Customer deleted successfully']);
    }
}
