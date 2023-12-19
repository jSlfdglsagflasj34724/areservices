<?php

namespace App\Http\Controllers\Api;

use App\Enums\AssetStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\AssetResource;
use App\Models\Asset;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DeviceDetail;
use App\Models\Assets;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;
use Symfony\Component\HttpFoundation\Response;

class AssetsController extends Controller
{
	public function index()
	{
		$query = QueryBuilder::for(Asset::class)
					->allowedIncludes([AllowedInclude::relationship('asset-type', 'assetType')])
					->allowedFilters([AllowedFilter::exact('tag', 'asset_tag')])
					->allowedSorts(['created_at', 'updated_at'])
					->defaultSort('-updated_at')
					->visibleTo(Auth::user())
					->paginate();
		
		return AssetResource::collection($query);
	}

	public function store(Request $request, Asset $asset)
	{
		$request->validate([
			'asset_type_id' => ['sometimes', 'required', Rule::exists('asset_types', 'id')],
			'brand_name' => ['required', 'max:255'],
			'other_asset_type' => ['sometimes', 'max:255'],
			'company_name' => ['required', 'max:255'],
			'location' => ['required', 'max:255'],
			'landmark' => ['required', 'max:255'],
		]);

		try {
			$asset->fill($request->all());
			$asset->user_id = Auth::id();
			$asset->check = AssetStatus::MANUALLY->value;
			$asset->save();

			return new AssetResource($asset);
		} catch (Exception $ex) {
			return response()->json(null, Response::HTTP_INTERNAL_SERVER_ERROR);
		}
	}

	public function show(Asset $asset)
	{
		$asset->load(['assetType']);

		return new AssetResource($asset);
	}
	public function update(Request $request, Asset $asset)

	{
		$request->validate([
			'asset_type_id' => ['sometimes', 'required', Rule::exists('asset_types', 'id')],
			'brand_name' => ['required', 'max:255'],
			'other_asset_type' => ['sometimes', 'max:255'],
			'company_name' => ['required', 'max:255'],
			'location' => ['required', 'max:255'],
			'landmark' => ['required', 'max:255'],
		]);

		try {
			$asset->fill($request->all());
			if (!empty($request['other_asset_type'])) $asset->asset_type_id = null;
			if (!empty($request['asset_type_id'])) $asset->other_asset_type = null;
			$asset->update();

			return response()->json(null, Response::HTTP_NO_CONTENT);
		} catch (Exception $ex) {
			return response()->json(null, Response::HTTP_INTERNAL_SERVER_ERROR);
		}
	}
}