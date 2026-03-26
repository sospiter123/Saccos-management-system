<?php

namespace App\Http\Controllers;

use App\Models\Repayment;
use Illuminate\Http\Request;

class RepaymentController extends Controller
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
        'loan_id' => 'required|exists:loans,id',
        'amount_paid' => 'required|numeric',
        'payment_date' => 'required|date',
    ]);

    // 2. Extract values
    $loan = Loan::find($validated['loan_id']);
    $amount = $validated['amount_paid'];

    // 3. Check if loan is active
    if ($loan->status === 'Completed') {
        return response()->json([
            'message' => 'Loan is already completed'
        ], 400);
    }

    // 4. Check overpayment
    if ($amount > $loan->remaining_balance) {
        return response()->json([
            'message' => 'Payment exceeds remaining balance'
        ], 400);
    }

    // 5. Update remaining balance
    $loan->remaining_balance -= $amount;

    // 6. Check if loan is fully paid
    if ($loan->remaining_balance == 0) {
        $loan->status = 'Completed';
    }

    $loan->save();

    // 7. Save repayment
    $repayment = Repayment::create([
        'loan_id' => $loan->id,
        'amount_paid' => $amount,
        'payment_date' => $validated['payment_date']
    ]);

    // 8. Return response
    return response()->json([
        'message' => 'Repayment recorded successfully',
        'repayment' => $repayment,
        'loan' => $loan
    ], 201);
}

    /**
     * Display the specified resource.
     */
    public function show(Repayment $repayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Repayment $repayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Repayment $repayment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Repayment $repayment)
    {
        //
    }
}
