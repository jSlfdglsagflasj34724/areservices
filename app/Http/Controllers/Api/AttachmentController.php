<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JobFiles;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class AttachmentController extends Controller
{
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobFiles $file)
    {
        Gate::authorize('update', $file->job);

        $file->delete();

        return response()->json(null, Response::HTTP_ACCEPTED);
    }
}
