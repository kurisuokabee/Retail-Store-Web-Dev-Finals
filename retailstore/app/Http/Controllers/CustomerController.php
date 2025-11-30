<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Quesry Using Eloquent ORM
        $customers = Customer::all(); //all records from customer table
        return view('customers.index', ['customers' => $customers]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customers.create'); //form to create a new customer
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //click submit in create form
        $validatedData = $request->validate([
            'username' => 'required|max:50|unique:customers,username',
            'email' => 'required|email|unique:customers,email',
            'password' => 'required|min:8',
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable',
            'phone' => 'nullable|max:20',
        ]);

        // Hash incoming password and map to the DB column `password_hash`.
        $validatedData['password'] = Hash::make($validatedData['password']);
        unset($validatedData['password']);

        $customer = Customer::create($validatedData); //insert into customer table

        // Log the new customer in
        Auth::login($customer);

        return redirect()->route('customers.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $customer = Customer::find($id);
        return view('customers.show', ['customer' => $customer]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $customer = Customer::find($id);
        return view('customers.edit', ['customer' => $customer]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'username' => 'required|max:50|unique:customers,username,' . $id . ',customer_id',
            'email' => 'required|email|unique:customers,email,' . $id . ',customer_id',
            'password' => 'nullable|string',
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable',
            'phone' => 'nullable|max:20',
        ]);

        $customer = Customer::findOrFail($id);

        // Hash password correctly
        if (!empty($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']); // leave old password unchanged
        }

        $customer->update($validatedData);

        return redirect()->route('customers.show',  $customer->customer_id)->with('success', 'Info updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = Customer::find($id);
        $customer->delete();
        return redirect()->route('customers.index');
    }
}
