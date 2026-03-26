<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $member = Member::all();
        return response()->json([
            'members' => $member
        ]);
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
    $validated = $request->validate([
        'member_number' => 'required|unique:members,member_number',
        'first_name' => 'required|string',
        'last_name' => 'required|string',
        'phone' => 'required|string|max:15',
        'email' => 'required|email',
        'national_id' => 'required|string',
        'address' => 'required|string'
    ]);

    $member = Member::create($validated);

    return response()->json([
        'message' => 'Member created successfully',
        'member' => $member
    ], 201);
}

    /**
     * Display the specified resource.
     */
    public function show(Member $id)
    {
        $member = Member::find($id);

        if(!$member) {
            return response()->json([
                'message' => 'Member not found'
            ], 404);
        }

        return response()->json([
            'member' => $member
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    // 1. Find member
    $member = Member::find($id);

    // 2. Check if exists
    if (!$member) {
        return response()->json([
            'message' => 'Member not found'
        ], 404);
    }

    // 3. Validate input
    $validated = $request->validate([
        'phone' => 'required|string|max:15',
        'address' => 'sometimes|string',
        'email' => 'sometimes|email'
    ]);

    // 4. Update member
    $member->update($validated);

    // 5. Return response
    return response()->json([
        'message' => 'Member updated successfully',
        'member' => $member
    ]);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        //1. Delete member
        $member->delete();

        //2. Return response
        return response()->json([
            'message' => 'Member deleted successfully'
        ]);
    }
}
