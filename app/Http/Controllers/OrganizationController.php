<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organization;
use Illuminate\Support\Facades\Hash;

class OrganizationController extends Controller
{
    public function store(Request $request)
    {
        // Cek apakah pengguna terautentikasi
        if (!$request->user()) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        // Cek apakah user sudah memiliki organisasi
        if (Organization::where('user_id', $request->user()->id)->exists()) {
            return response()->json([
                'message' => 'You have already registered an organization.'
            ], 400); 
        }

        // Validasi data
        $validatedData = $request->validate([
            'category' => 'required|string|max:255',
            'organization_name' => 'required|string|max:255',
            'email' => 'required|email|unique:organizations,email',
            'password' => 'required|string|min:8', 
        ]);

        // Simpan data ke database dengan user_id dari pengguna yang login
        $organization = Organization::create([
            'category' => $validatedData['category'],
            'organization_name' => $validatedData['organization_name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'user_id' => auth()->id(),
        ]);

        // Kembalikan respons sukses
        return response()->json([
            'message' => 'Organization registered successfully',
            'organization' => $organization
        ], 201);
    }
}