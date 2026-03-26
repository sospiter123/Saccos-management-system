<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    // 1. Validate request
    $validated = $request->validate([
        'member_id' => 'required|exists:members,id',
        'principal' => 'required|numeric',
        'interest_rate' => 'required|numeric',
        'duration_months' => 'required|integer'
    ]);

    // 2. Extract values
    $principal = $validated['principal'];
    $rate = $validated['interest_rate'] / 100;
    $duration = $validated['duration_months'];

    // 3. Calculate total repayment
    $total = $principal + ($principal * $rate * ($duration / 12));

    // 4. Create loan (include calculated fields)
    $loan = Loan::create([
        'member_id' => $validated['member_id'],
        'principal' => $principal,
        'interest_rate' => $validated['interest_rate'],
        'duration_months' => $duration,
        'total_amount' => $total,
        'remaining_balance' => $total,
        'status' => 'Active'
    ]);

    // 5. Return response
    return response()->json([
        'message' => 'Loan created successfully',
        'loan' => $loan
    ], 201);
}

    /**
     * Display the specified resource.
     */
    public function show(Loan $loan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Loan $loan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Loan $loan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Loan $loan)
    {
        //
    }
}
