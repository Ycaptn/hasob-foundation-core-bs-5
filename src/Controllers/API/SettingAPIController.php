<?php


namespace Hasob\FoundationCore\Controllers\API;

use Hasob\FoundationCore\Events\SettingCreated;
use Hasob\FoundationCore\Events\SettingUpdated;
use Hasob\FoundationCore\Events\SettingDeleted;

use Hasob\FoundationCore\Requests\API\CreateSettingAPIRequest;
use Hasob\FoundationCore\Requests\API\UpdateSettingAPIRequest;
use Hasob\FoundationCore\Models\Setting;

use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

use Response;

use Hasob\FoundationCore\Models\Organization;

class SettingAPIController extends AppBaseController
{
    public function index(Request $request, Organization $organization)
    {
        $query = Setting::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }
        
        if ($organization != null){
            $query->where('organization_id', $organization->id);
        }

        $settings = $query->get();

        return $this->sendResponse($settings->toArray(), 'Settings retrieved successfully');
    }

    public function store(CreateSettingAPIRequest $request, Organization $organization)
    {
        $input = $request->all();

        /** @var Setting $setting */
        $setting = Setting::create($input);
        
        SettingCreated::dispatch($setting);
        return $this->sendResponse($setting->toArray(), 'Setting saved successfully');
    }

    public function show($id, Organization $organization)
    {
        /** @var Setting $setting */
        $setting = Setting::find($id);

        if (empty($setting)) {
            return $this->sendError('Setting not found');
        }

        return $this->sendResponse($setting->toArray(), 'Setting retrieved successfully');
    }

    public function update($id, UpdateSettingAPIRequest $request, Organization $organization)
    {
        /** @var Setting $setting */
        $setting = Setting::find($id);

        if (empty($setting)) {
            return $this->sendError('Setting not found');
        }

        $setting->fill($request->all());
        $setting->save();
        
        SettingUpdated::dispatch($setting);
        return $this->sendResponse($setting->toArray(), 'Setting updated successfully');
    }

    public function destroy($id, Organization $organization)
    {
        /** @var Setting $setting */
        $setting = Setting::find($id);

        if (empty($setting)) {
            return $this->sendError('Setting not found');
        }

        $setting->delete();
        SettingDeleted::dispatch($setting);
        return $this->sendSuccess('Setting deleted successfully');
    }
}