<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blotter;
use Illuminate\Support\Facades\Auth;

class BlotterController extends Controller
{

public function submitBlotter(Request $request)
{
    $validated = $request->validate([
        // Defendant
        "defendantAddress" => "nullable|string|max:255",
        "defendantContactNumber" => "nullable|digits:11",
        "defendantName" => "required|string|max:255",
        "defendantMiddleName" => "nullable|string|max:255",
        "defendantLastName" => "required|string|max:255",
        "defendantAge" => "nullable|integer|min:1|max:120",

        // Witness
        "witnessName" => "nullable|string|max:255",
        "witnessContactNumber" => "nullable|digits:11",

        // Case
        "proof" => "nullable|image|mimes:jpg,png,jpeg|max:4096",
        "blotterDescription" => "required|string|min:10",
    ]);

    $user = Auth::user();

    $proofPath = null;
    if ($request->hasFile('proof')) {
        $proofPath = $request->file('proof')->store('photos', 'public');
    }

    Blotter::create([
        // ✅ PLAINTIFF (FROM AUTH, NOT FORM)
        'plaintiffId' => $user->id,
        'plaintiffAddress' => "123abaca",
        'plaintiffContactNumber' => $user->contactNumber ?? null,
        'plaintiffName' => $user->firstName ?? null,
        'plaintiffMiddleName' => $user->middleName ?? null,
        'plaintiffLastName' => $user->lastName ?? null,
        'plaintiffAge' => "121",

        // ✅ DEFENDANT
        'defendantAddress' => $request->defendantAddress,
        'defendantContactNumber' => $request->defendantContactNumber,
        'defendantName' => $request->defendantName,
        'defendantMiddleName' => $request->defendantMiddleName,
        'defendantLastName' => $request->defendantLastName,
        'defendantAge' => $request->defendantAge,

        // ✅ WITNESS
        'witnessName' => $request->witnessName,
        'witnessContactNumber' => $request->witnessContactNumber,

        // ✅ CASE
        'proof' => $proofPath,
        'blotterDescription' => $request->blotterDescription,

        'status' => 'PENDING',
        'encodedBy' => null,
        'action' => null,
        'statusDescription' => null,
    ]);

    return redirect()->back()->with('success', 'Blotter submitted successfully!');
}
public function showBlotterRequests()
    {
        $blotters = Blotter::with('user')->orderByDesc('created_at')->get();
        return view('admin.blotterRequest', compact('blotters'));
    }
}