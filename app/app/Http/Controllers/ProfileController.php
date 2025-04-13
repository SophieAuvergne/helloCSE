<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfileRequest;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function store(StoreProfileRequest $request)
    {
        $path = is_null($request->file('image')) ? null : $request->file('image')->store('images', 'public');

        $profile = Profile::create([
            'name' => $request->get('name'),
            'firstname' => $request->get('firstname'),
            'status' => $request->get('status'),
            'image_path' => $path,
            'admin_id' => auth()->id(),
        ]);

        return response()->json([$profile, 201]);
    }

    public function indexPublic()
    {
        return Profile::where('status', 'active')
            ->select('id', 'name', 'image_path')
            ->get();
    }
}
