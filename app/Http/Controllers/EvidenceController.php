<?php

namespace App\Http\Controllers;

use App\Http\Requests\DelegationRequest;

class EvidenceController extends Controller
{
    public function index(DelegationRequest $request)
    {
        return view('delegation', [
            'delegation' => $request->delegation(),
        ]);
    }
}
