<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class ProfileController extends Controller
{
    public function store(StoreProfileRequest $request): JsonResponse
    {
        //on détermine le chemin ou sera stocker le fichier sachant que ce champ peut être vide
        $file = $request->file('image');
        $path = $file instanceof UploadedFile ? $file->store('images', 'public') : null;

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
        //on récupère les information validés
        $data = $request->validated();

        //cas particulier du gestion de l'upload de fichier
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file instanceof UploadedFile ? $file->store('images', 'public') : null;
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
        //on ne met pas status dans le select car il s'agit d'un endpoint public et que l'information status est restreinte aux admin
        $profiles = Profile::where('status', 'active')
            ->select('id', 'name', 'image_path')
            ->get()
        ;

        return response()->json($profiles, 200);
    }
}
