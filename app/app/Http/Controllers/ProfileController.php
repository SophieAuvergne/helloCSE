<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function store(StoreProfileRequest $request): JsonResponse
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

    public function update(UpdateProfileRequest $request, Profile $profile): JsonResponse
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('profiles', 'public');
            $data['image_path'] = $path;
        }
        $profile->update($data);

        return response()->json(['profile' => $profile], 200);
    }

    public function destroy(Profile $profile): JsonResponse
    {
        $profile->delete();

        return response()->json(['message' => 'Profile deleted'], 200);
    }

    public function indexPublic(): JsonResponse
    {
        $profiles = Profile::where('status', 'active')
            ->select('id', 'name', 'image_path')
            ->get()
        ;

        return response()->json($profiles, 200);
    }
}
