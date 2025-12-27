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
    'plaintiffName' => 'nullable|string|max:255',
    'plaintiffMiddleName' => 'nullable|string|max:255',
    'plaintiffLastName' => 'nullable|string|max:255',
    'plaintiffAddress' => 'nullable|string|max:255',
    'plaintiffContactNumber' => 'nullable|digits:11',
    'plaintiffAge' => 'nullable|integer|min:1|max:120',

   'defendantName' => 'required|string|max:255',
    'defendantMiddleName' => 'nullable|string|max:255',
    'defendantLastName' => 'required|string|max:255',
    'defendantAddress' => 'nullable|string|max:255',
    'defendantContactNumber' => 'nullable|digits:11',
    'defendantAge' => 'nullable|integer|min:1|max:120',

    'witnessName' => 'nullable|string|max:255',
    'witnessContactNumber' => 'nullable|digits:11',

    'proof' => 'nullable|image|mimes:jpg,png,jpeg|max:4096',
    'blotterDescription' => 'required|string|min:10',
]);

    $user = Auth::user();

    $proofPath = null;
    if ($request->hasFile('proof')) {
        $proofPath = $request->file('proof')->store('photos', 'public');
    }

    $plaintiff_data= [
        'plaintiffId' => $user->id ?? "",
        'plaintiffAddress' => "123abaca",
        'plaintiffContactNumber' => $user->contactNumber ?? $request->plaintiffContactNumber,
        'plaintiffName' => $user->firstName ?? $request->plaintiffName,
        'plaintiffMiddleName' => $user->middleName ?? $request->plaintiffMiddleName,
        'plaintiffLastName' => $user->lastName ?? $request->plaintiffLastName,
        'plaintiffAge' => "121",
    ];

    Blotter::create(array_merge($plaintiff_data,[
        
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
    ]));

    return redirect()->back()->with('success', 'Blotter submitted successfully!');
}
public function showBlotterRequests()
    {
        $blotters = Blotter::with('user')->orderByDesc('created_at')->get();
        return view('admin.blotterRequest', compact('blotters'));
    }
}