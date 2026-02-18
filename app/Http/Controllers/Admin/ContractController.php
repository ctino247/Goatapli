<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContractController extends Controller
{
    public function index()
    {
        $contracts = Contract::all();
        return view('admin.contracts.index', compact('contracts'));
    }

    public function create()
    {
        return view('admin.contracts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'benefits' => 'required|string',
            'duration_days' => 'required|integer',
            'contract_file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120',
        ]);

        $filePath = null;
        if ($request->hasFile('contract_file')) {
            $filePath = $request->file('contract_file')->store('contracts', 'public');
        }

        Contract::create([
            'name' => $request->name,
            'price' => $request->price,
            'benefits' => $request->benefits,
            'duration_days' => $request->duration_days,
            'file_path' => $filePath,
        ]);

        return redirect()->route('admin.contracts.index')->with('success', 'Contract created successfully.');
    }

    public function edit(Contract $contract)
    {
        return view('admin.contracts.edit', compact('contract'));
    }

    public function update(Request $request, Contract $contract)
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'benefits' => 'required|string',
            'duration_days' => 'required|integer',
            'contract_file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120',
        ]);

        if ($request->hasFile('contract_file')) {
            if ($contract->file_path) {
                Storage::disk('public')->delete($contract->file_path);
            }
            $contract->file_path = $request->file('contract_file')->store('contracts', 'public');
        }

        $contract->update([
            'name' => $request->name,
            'price' => $request->price,
            'benefits' => $request->benefits,
            'duration_days' => $request->duration_days,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.contracts.index')->with('success', 'Contract updated successfully.');
    }
}
