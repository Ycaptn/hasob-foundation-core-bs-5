<?php
namespace Hasob\FoundationCore;

use Hasob\FoundationCore\Controllers\API\AttachmentAPIController;
use Hasob\FoundationCore\Controllers\API\CommentAPIController;
use Hasob\FoundationCore\Controllers\AttachmentController;
use Hasob\FoundationCore\Controllers\ChecklistController;
use Hasob\FoundationCore\Controllers\CommentController;
use Hasob\FoundationCore\Controllers\DepartmentController;
use Hasob\FoundationCore\Controllers\LedgerController;
use Hasob\FoundationCore\Controllers\OrganizationController;
use Hasob\FoundationCore\Controllers\PageController;
use Hasob\FoundationCore\Controllers\RoleController;
use Hasob\FoundationCore\Controllers\SettingController;
use Hasob\FoundationCore\Controllers\SiteController;
use Hasob\FoundationCore\Controllers\SupportController;
use Hasob\FoundationCore\Controllers\AnnouncementController;
use Hasob\FoundationCore\Controllers\SiteDisplayController;
use Hasob\FoundationCore\Controllers\SocialController;
use Hasob\FoundationCore\Controllers\TagController;
use Hasob\FoundationCore\Controllers\UserController;
use Hasob\FoundationCore\Controllers\StaffDirectoryController;
use Hasob\FoundationCore\Managers\OrganizationManager;
use Hasob\FoundationCore\Models\Department;
use Hasob\FoundationCore\Models\Ledger;
use Hasob\FoundationCore\Models\Organization;
use Hasob\FoundationCore\Models\Setting;
use Hasob\FoundationCore\Models\Site;
use Hasob\FoundationCore\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;
use Spatie\Permission\Exceptions\RoleDoesNotExist;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class FoundationCore
{

    public function all_users(Organization $org = null)
    {
        return User::all_users($org);
    }

    public function all_departments(Organization $org = null)
    {
        return Department::all_departments($org);
    }

    public function all_ledgers(Organization $org = null)
    {
        return Ledger::all_ledgers($org);
    }

    public function all_sites(Organization $org = null)
    {
        return Site::all_sites($org);
    }

    public function current_organization()
    {

        $org = null;
        $current_user = null;

        if (Auth::user() != null) {
            $current_user = Auth::user();
            if ($current_user->organization != null) {
                $org = $current_user->organization;
            }
        }

        if ($org == null) {
            $host = request()->getHost();
            $manager = new OrganizationManager();
            $org = $manager->loadTenant($host);
        }

        return $org;
    }

    public function enabled_features(Organization $org)
    {

        $enabled = [];
        if ($org != null) {
            $features = $org->get_features();
            foreach ($features as $key => $feature) {
                if ($feature) {
                    $enabled[] = $key;
                }
            }
        }

        return $enabled;
    }

    public function has_feature($feature, Organization $org = null)
    {
        $organization = $org;
        if ($organization == null) {
            //Get the current organization
            $organization = $this->current_organization();
        }

        if ($organization != null) {
            $features = $organization->get_features();
            if (isset($features[$feature])) {
                return $features[$feature] == true;
            }
        }

        return false;
    }

    public function get_setting(Organization $org, $key)
    {

        if (Schema::hasTable('fc_settings')) {
            if ($org != null) {
                $record = Setting::where(['organization_id' => $org->id, 'key' => $key])->first();
                if ($record != null) {
                    return $record;
                }
            }
        }
        return null;
    }

    public function get_dashboards(Organization $org)
    {
        if (Schema::hasTable('fc_settings')) {
            if ($org != null) {
                return Setting::where([
                    'organization_id' => $org->id,
                    'group_name' => 'dashboards',
                ])->whereIn('owner_feature', $this->enabled_features($org))
                ->orderBy('display_ordinal','ASC')
                ->get();
            }
        }
        return [];
    }

    public function register_dashboard(Organization $org, $feature_name, $name, $include_path, $position)
    {

        if (Schema::hasTable('fc_settings')) {
            if ($org != null) {
                $record = Setting::where(['organization_id' => $org->id, 'key' => $name, 'owner_feature' => $feature_name])->first();
                if ($record == null) {
                    Setting::create([
                        'organization_id' => $org->id,
                        'display_ordinal' => $position,
                        'group_name' => 'dashboards',
                        'display_name' => $name,
                        'display_type' => 'string',
                        'owner_feature' => $feature_name,
                        'key' => $name,
                        'value' => $include_path,
                    ]);
                }
            }
        }

    }

    public function get_user_profile_links(Organization $org)
    {
        if (Schema::hasTable('fc_settings')) {
            if ($org != null) {
                return Setting::where([
                    'organization_id' => $org->id,
                    'group_name' => 'user_profile_links',
                ])->whereIn('owner_feature', $this->enabled_features($org))->get();
            }
        }
        return [];
    }

    public function register_user_profile_links(Organization $org, $feature_name, $link_name, $link_url)
    {

        if (Schema::hasTable('fc_settings')) {
            if ($org != null) {
                $record = Setting::where(['organization_id' => $org->id, 'key' => $link_name, 'owner_feature' => $feature_name])->first();
                if ($record == null) {
                    Setting::create([
                        'organization_id' => $org->id,
                        'display_ordinal' => 0,
                        'group_name' => 'user_profile_links',
                        'display_name' => $link_name,
                        'display_type' => 'string',
                        'owner_feature' => $feature_name,
                        'key' => $link_name,
                        'value' => $link_url,
                    ]);
                }
            }
        }

    }

    public function get_right_panels(Organization $org)
    {
        if (Schema::hasTable('fc_settings')) {
            if ($org != null) {
                return Setting::where([
                    'organization_id' => $org->id,
                    'group_name' => 'right_panels',
                ])->whereIn('owner_feature', $this->enabled_features($org))
                ->orderBy('display_ordinal','ASC')
                ->get();
            }
        }
        return [];
    }

    public function register_right_panel(Organization $org, $feature_name, $name, $include_path, $position)
    {

        if (Schema::hasTable('fc_settings')) {
            if ($org != null) {
                $record = Setting::where(['organization_id' => $org->id, 'key' => $name, 'owner_feature' => $feature_name])->first();
                if ($record == null) {
                    Setting::create([
                        'organization_id' => $org->id,
                        'display_ordinal' => $position,
                        'group_name' => 'right_panels',
                        'display_name' => $name,
                        'display_type' => 'string',
                        'owner_feature' => $feature_name,
                        'key' => $name,
                        'value' => $include_path,
                    ]);
                }
            }
        }

    }

    public function register_setting(Organization $org, $key, $group_name, $display_type, $display_name, $owner_feature, $display_ordinal = 1, $display_type_options = null, $value = null)
    {

        if (Schema::hasTable('fc_settings')) {
            if ($org != null) {
                $record = Setting::where(['organization_id' => $org->id, 'key' => $key])->first();
                if ($record == null) {
                    Setting::create([
                        'organization_id' => $org->id,
                        'display_ordinal' => $display_ordinal,
                        'group_name' => $group_name,
                        'display_name' => $display_name,
                        'display_type' => $display_type,
                        'owner_feature' => $owner_feature,
                        'key' => $key,
                        'display_type_options' => $display_type_options,
                        'value' => $value
                    ]);
                }
            }
        }

    }

    public function register_document_generator_model(Organization $org, $model_names=[]){

        if (Schema::hasTable('fc_settings')) {
            foreach($model_names as $idx=>$model){

                $class = new \ReflectionClass($model);
                $name = $class->getShortName();

                if ($org != null) {
                    $record = Setting::where(['organization_id' => $org->id, 'key' => $name, 'owner_feature' => 'document-generation'])->first();
                    if ($record == null) {
                        Setting::create([
                            'organization_id' => $org->id,
                            'display_ordinal' => $idx,
                            'group_name' => 'document_models',
                            'display_name' => $name,
                            'display_type' => 'string',
                            'owner_feature' => 'document-generation',
                            'key' => $name,
                            'value' => $model,
                        ]);
                    }
                }

            }
        }

    }

    public function register_artifacts_attributes(Organization $org, $owner_name,$model, $artribute_names=[]){
        
        $class = new \ReflectionClass($model);
        $short_class_name = $class->getShortName();
        if (Schema::hasTable('fc_settings')) {

            foreach($artribute_names as $idx=> $name){

                if ($org != null) {
                    $record = Setting::where(['organization_id' => $org->id, 'key' => $name, 'group_name' =>  $model , 'owner_feature' => $owner_name])->first();
                    if ($record == null) {
                        Setting::create([
                            'organization_id' => $org->id,
                            'display_ordinal' => $idx,
                            'group_name' => $model,
                            'display_name' => $short_class_name,
                            'display_type' => 'string',
                            'owner_feature' => $owner_name,
                            'key' => $name,
                            'value' => '',
                        ]);
                    }
                }

            }
        }
    
    }

    public function register_batchable_model(Organization $org, $model_names=[], $batch_item_template=""){

        if (Schema::hasTable('fc_settings')) {
            foreach($model_names as $idx=>$model){

                $class = new \ReflectionClass($model);
                $name = $class->getShortName();

                if ($org != null) {
                    $record = Setting::where(['organization_id' => $org->id, 'key' => $name, 'owner_feature' => 'batching'])->first();
                    if ($record == null) {
                        Setting::create([
                            'organization_id' => $org->id,
                            'display_ordinal' => $idx,
                            'group_name' => 'batchable_models',
                            'display_name' => $name,
                            'display_type' => 'string',
                            'owner_feature' => 'batching',
                            'key' => $name,
                            'value' => $model,
                        ]);
                    }
                }

            }
        }

    } 

    public function register_batch_workable(Organization $org, $model_names=[]){

        if (Schema::hasTable('fc_settings')) {
            foreach($model_names as $idx=>$model){

                $class = new \ReflectionClass($model);
                $name = $class->getShortName();

                if ($org != null) {
                    $record = Setting::where(['organization_id' => $org->id, 'key' => $name, 'owner_feature' => 'batching'])->first();
                    if ($record == null) {
                        Setting::create([
                            'organization_id' => $org->id,
                            'display_ordinal' => $idx,
                            'group_name' => 'batch_workables',
                            'display_name' => $name,
                            'display_type' => 'string',
                            'owner_feature' => 'batching',
                            'key' => $name,
                            'value' => $model,
                        ]);
                    }
                }

            }
        }

    }

    public function get_document_generator_models(Organization $org)
    {
        if (Schema::hasTable('fc_settings')) {
            if ($org != null) {
                return Setting::where([
                    'organization_id' => $org->id,
                    'group_name' => 'document_models',
                ])->whereIn('owner_feature', $this->enabled_features($org))->get();
            }
        }
        return [];
    }

    public function get_batchable_models(Organization $org)
    {
        if (Schema::hasTable('fc_settings')) {
            if ($org != null) {
                return Setting::where([
                    'organization_id' => $org->id,
                    'group_name' => 'batchable_models',
                ])->whereIn('owner_feature', $this->enabled_features($org))->get();
            }
        }
        return [];
    }

    public function get_batch_workables(Organization $org)
    {
        if (Schema::hasTable('fc_settings')) {
            if ($org != null) {
                return Setting::where([
                    'organization_id' => $org->id,
                    'group_name' => 'batch_workables',
                ])->whereIn('owner_feature', $this->enabled_features($org))->get();
            }
        }
        return [];
    }

    public function register_roles($roles_list)
    {

        if (Schema::hasTable('roles')) {
            app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

            foreach ($roles_list as $role => $permissions) {
                try {
                    $dbRole = Role::findByName($role);
                } catch (RoleDoesNotExist $e) {
                    $dbRole = Role::create(['name' => $role]);
                }
                foreach ($permissions as $permission) {
                    try {
                        $dbPerm = Permission::findByName($permission);
                    } catch (PermissionDoesNotExist $e) {
                        $dbPerm = Permission::create(['name' => $permission]);
                    }
                    $dbRole->givePermissionTo($permission);
                }
            }
        }
    }

    public function get_sites_menu_map()
    {

        $current_user = Auth::user();
        if ($current_user != null) {

            $fc_menu = [
                'mnu_fc_public_sites' => [
                    'id' => 'mnu_fc_public_sites', 
                    'label' => 'Sites', 
                    'icon' => 'bx bx-globe-alt', 
                    'path' => '#', 
                    'route-selector' => '', 
                    'is-parent' => true,
                    'children' => [],
                ],
            ];

            if (\FoundationCore::has_feature('sites', $current_user->organization)) {
                foreach($this->all_sites() as $idx=>$site){
                    $fc_menu['mnu_fc_public_sites']['children']["sites{$idx}"] = [
                        'id' => "mnu_fc_public_sites{$idx}", 
                        'label' => \Illuminate\Support\Str::limit("{$site->site_name}",15,'...'),
                        'path' => route('fc.site-display', $site->id), 
                        'route-selector' => '', 
                        'is-parent' => false,
                        'children' => [],
                    ];
                }
            }

            return $fc_menu;
        }

        return [];

    }

    public function get_menu_map_staff_directory(){

        $fc_menu = [];

        $current_user = Auth::user();
        if ($current_user != null) {
                
            if (\FoundationCore::has_feature('staff-directory', $current_user->organization)) {
                $fc_menu = [
                    'mnu_fc_staff_directory' => [
                        'id' => 'mnu_fc_staff_directory',
                        'label' => 'Staff Directory',
                        'icon' => 'bx bx-user-pin',
                        'path' => route('fc.staff-directory'),
                        'route-selector' => 'fc/staff-directory',
                        'is-parent' => true,
                        'children' => []
                    ]
                ];
            }

            if (\FoundationCore::has_feature('batching', $current_user->organization)) {
                $fc_menu['mnu_fc_batching'] = [
                    'id'=>'mnu_fc_batching',
                    'label'=>'Batching',
                    'icon'=>'bx bx-package',
                    'path'=> '#',
                    'route-selector'=>'',
                    'is-parent'=>true,
                    'children' => []
                ];

                $fc_menu['mnu_fc_batching']['children']['mnu_fc_batching_all_batches'] = [
                    'id'=>'mnu_fc_batching_all_batches',
                    'label'=>'All Batches',
                    'icon'=>'bx bx-copy',
                    'path'=> route('fc.batches.index'),
                    'route-selector'=>'fc/batches*',
                    'is-parent'=>false,
                    'children' => []
                ];

            }
        }

        return $fc_menu;
    }

    public function get_menu_map_department_directory(){

        $fc_menu = [];

        $current_user = Auth::user();
        if ($current_user != null) {
                
            if (\FoundationCore::has_feature('departments', $current_user->organization)) {
                $fc_menu = [
                    'mnu_fc_dept_directory' => [
                        'id' => 'mnu_fc_dept_directory',
                        'label' => 'Departments & Units',
                        'icon' =>'bx bx-door-open',
                        'path' =>  route('fc.departments.index'),
                        'route-selector' => 'fc/departments',
                        'is-parent' => true,
                        'children' => []
                    ]
                ];
            }
        }

        return $fc_menu;
    }

    public function get_menu_map()
    {
        $current_user = Auth::user();
        if ($current_user != null) {

            $fc_menu = [];

            if ($current_user->hasRole('admin')) {
                $fc_menu = [
                    'mnu_fc_admin' => ['id' => 'mnu_fc_admin', 'label' => 'Administration', 'icon' => 'bx bx-abacus', 'path' => '#', 'route-selector' => '', 'is-parent' => true,
                        'children' => [],
                    ],
                ];
            }

            if (\FoundationCore::has_feature('sites', $current_user->organization) && $current_user->hasAnyRole(['admin', 'sites-admin'])) {
                $fc_menu['mnu_fc_admin']['children']['sites'] = ['id' => 'mnu_fc_sites', 'label' => 'Sites', 'icon' => 'bx bx-globe-alt', 'path' => route('fc.sites.index'), 'route-selector' => 'fc/sites', 'is-parent' => false,
                    'children' => [],
                ];
            }

            if ($current_user->hasAnyRole(['admin'])) {
                $fc_menu['mnu_fc_admin']['children']['attachments'] = ['id' => 'mnu_fc_sites', 'label' => 'Attachments', 'icon' => 'bx bx-paperclip', 'path' => route('fc.attachment.stats'), 'route-selector' => 'fc/attachment-stats', 'is-parent' => false,
                    'children' => [],
                ];
            }

            if ($current_user->hasAnyRole(['admin']) && Schema::hasTable('personal_access_tokens') && \FoundationCore::has_feature('api_tokens', $current_user->organization)) {
                $fc_menu['mnu_fc_admin']['children']['api_tokens'] = ['id' => 'mnu_fc_api_tokens', 'label' => 'API Tokens', 'icon' => 'bx bx-key', 'path' => route('fc.api_tokens.index'), 'route-selector' => 'fc/api_tokens', 'is-parent' => false,
                    'children' => [],
                ];
            }


            if (\FoundationCore::has_feature('departments', $current_user->organization) && $current_user->hasAnyRole(['admin', 'departments-admin'])) {
                if ($current_user->hasRole('admin')) {
                    $fc_menu['mnu_fc_admin']['children']['depts'] = ['id' => 'mnu_fc_depts', 'label' => 'Departments & Units', 'icon' => 'bx bx-collection', 'path' => route('fc.departments.index'), 'route-selector' => 'fc/departments', 'is-parent' => false,
                        'children' => [],
                    ];
                } else {   
                    
                    $fc_menu = [
                        'mnu_fc_departments-admin'=>[
                            'id'=>'mnu_departments-admin',
                            'label'=>'Departments & Units',
                            'icon'=>'bx bx-collection',
                            'path' => route('fc.departments.index'),
                            'route-selector'=> 'fc/departments',
                            'is-parent'=> true,
                            'children' => []
                        ]
                    ];
                }

            }

            if (\FoundationCore::has_feature('ledgers', $current_user->organization) && $current_user->hasAnyRole(['admin', 'ledgers-admin'])) {
                $fc_menu['mnu_fc_admin']['children']['ledgers'] = ['id' => 'mnu_fc_ledgers', 'label' => 'Ledgers', 'icon' => 'bx bx-wallet-alt', 'path' => route('fc.ledgers.index'), 'route-selector' => 'fc/ledgers', 'is-parent' => false,
                    'children' => [],
                ];
            }

            if (\FoundationCore::has_feature('document-generation', $current_user->organization) && $current_user->hasAnyRole(['admin', 'doc-gen-admin'])) {
                $fc_menu['mnu_fc_admin']['children']['doc_gen'] = ['id' => 'mnu_fc_doc_gen', 'label' => 'Document Generation', 'icon' => 'bx bx-analyse', 'path' => route('fc.documentGenerationTemplates.index'), 'route-selector' => 'fc/documentGenerationTemplates', 'is-parent' => false,
                    'children' => [],
                ];
            }

            if (\FoundationCore::has_feature('signatures', $current_user->organization) && $current_user->hasAnyRole(['admin', 'signatures-admin'])) {
                $fc_menu['mnu_fc_admin']['children']['signatures'] = ['id' => 'mnu_fc_signatures', 'label' => 'User Signatures', 'icon' => 'bx bx-pulse', 'path' => route('fc.signatures.index'), 'route-selector' => 'fc/signatures', 'is-parent' => false,
                    'children' => [],
                ];
            }

            if ($current_user->hasRole('admin')) {

                $fc_menu['mnu_fc_admin']['children']['access'] = ['id' => 'mnu_fc_acl', 'label' => 'Access Control', 'icon' => 'bx bx-briefcase-alt', 'path' => '#', 'route-selector' => null, 'is-parent' => false,
                    'children' => [
                        'users' => ['id' => 'mnu_fc_usr', 'label' => 'Users', 'icon' => 'bx bx-user', 'path' => route('fc.users.index'), 'route-selector' => 'fc/users'],
                        'add-user' => ['id' => 'mnu_fc_ausr', 'label' => 'Add User', 'icon' => 'bx bx-user-plus', 'path' => route('fc.user.show', 0), 'route-selector' => 'fc/user/0'],
                        'roles' => ['id' => 'mnu_fc_roles', 'label' => 'Roles', 'icon' => 'bx bx-user-check', 'path' => route('fc.roles.index'), 'route-selector' => 'fc/roles*'],
                    ],
                ];

                $fc_menu['mnu_fc_admin']['children']['system'] = ['id' => 'mnu_fc_system', 'label' => 'System', 'icon' => 'bx bx-wrench', 'path' => '#', 'route-selector' => null, 'is-parent' => false,
                    'children' => [
                        'settings' => ['id' => 'mnu_fc_org_settings', 'label' => 'Settings', 'icon' => 'bx bx-cog', 'path' => route('fc.org-settings'), 'route-selector' => 'fc/org-settings'],
                        'domains' => ['id' => 'mnu_fc_org_domains', 'label' => 'Domains', 'icon' => 'bx bx-globe', 'path' => route('fc.org-domains'), 'route-selector' => 'fc/org-domains'],
                        'features' => ['id' => 'mnu_fc_org_features', 'label' => 'Features', 'icon' => 'bx bx-slider', 'path' => route('fc.org-features'), 'route-selector' => 'fc/org-features'],
                    ],
                ];
            }

            return $fc_menu;
        }
 
        return [];

    }

    public function api_routes()
    {
        Route::name('fc-api.')->prefix('fc-api')->group(function () {
            Route::resource('settings', \Hasob\FoundationCore\Controllers\API\SettingAPIController::class);
            Route::resource('sites', \Hasob\FoundationCore\Controllers\API\SiteAPIController::class);
            Route::resource('pages', \Hasob\FoundationCore\Controllers\API\PageAPIController::class);
            Route::resource('pageables', \Hasob\FoundationCore\Controllers\API\PageableAPIController::class);
            Route::resource('supports', \Hasob\FoundationCore\Controllers\API\SupportAPIController::class);
            Route::resource('announcements', \Hasob\FoundationCore\Controllers\API\AnnouncementAPIController::class);
            Route::post('announceable-store', [\Hasob\FoundationCore\Controllers\API\AnnouncementAPIController::class, 'createAnnouncement'])->name('announceable.store');
            Route::resource('attributes', \Hasob\FoundationCore\Controllers\API\ModelAttributeAPIController::class);
            Route::put('/attributes/display_ordinal/{id}', [\Hasob\FoundationCore\Controllers\API\ModelAttributeAPIController::class, 'changeDisplayOrdinal'])->name('attributes.changeDisplayOrdinal');

            Route::resource('model_artifacts', \Hasob\FoundationCore\Controllers\API\ModelArtifactAPIController::class);
            Route::resource('siteArtifacts', \Hasob\FoundationCore\Controllers\API\SiteArtifactAPIController::class);

            Route::resource('departments', DepartmentController::class);
            Route::get('get-departments', [DepartmentController::class, 'getAllDepartments'])->name('get-all-departments');
            Route::get('get-department-members/{id}', [DepartmentController::class, 'getSpecificDepartmentMembers'])->name('show-specific-department-members');

            Route::resource('batches', \Hasob\FoundationCore\Controllers\API\BatchAPIController::class);
            Route::post('/batch/preview/{id}', [\Hasob\FoundationCore\Controllers\API\BatchAPIController::class, 'preview'])->name('batch.preview-batch-item');
            Route::post('/batch/remove/{id}', [\Hasob\FoundationCore\Controllers\API\BatchAPIController::class, 'removeBatchItem'])->name('batch.remove-batch-item');
            Route::post('/batch/add/{id}', [\Hasob\FoundationCore\Controllers\API\BatchAPIController::class, 'addBatchItem'])->name('batch.add-batch-item');
            Route::post('/batch/move/{id}', [\Hasob\FoundationCore\Controllers\API\BatchAPIController::class, 'moveBatchItem'])->name('batch.move-batch-item');
           
            Route::resource('addresses', \Hasob\FoundationCore\Controllers\API\AddressAPIController::class);
            Route::resource('api_tokens', \Hasob\FoundationCore\Controllers\API\APITokenAPIController::class);
            Route::resource('batch_items', \Hasob\FoundationCore\Controllers\API\BatchItemAPIController::class);
            Route::resource('payment_details', \Hasob\FoundationCore\Controllers\API\PaymentDetailAPIController::class);

            Route::resource('attachables', \Hasob\FoundationCore\Controllers\API\AttachableAPIController::class);
            Route::resource('comments', \Hasob\FoundationCore\Controllers\API\CommentAPIController::class);

            Route::resource('disabled_items', \Hasob\FoundationCore\Controllers\API\DisabledItemAPIController::class);
            Route::resource('tags', \Hasob\FoundationCore\Controllers\API\TagAPIController::class);
            Route::resource('taggables', \Hasob\FoundationCore\Controllers\API\TaggableAPIController::class);

            Route::resource('relationships', \Hasob\FoundationCore\Controllers\API\RelationshipAPIController::class);

            Route::resource('model_documents', \Hasob\FoundationCore\Controllers\API\ModelDocumentAPIController::class);
            Route::resource('document_generation_templates', \Hasob\FoundationCore\Controllers\API\DocumentGenerationTemplateAPIController::class);
            Route::resource('gate_way_payment_details', \Hasob\FoundationCore\Controllers\API\GateWayPaymentDetailAPIController::class);
            Route::resource('payment_disbursements', \Hasob\FoundationCore\Controllers\API\PaymentDisbursementAPIController::class);
            Route::resource('signatures', \Hasob\FoundationCore\Controllers\API\SignatureAPIController::class);

            Route::get('/attachments/{id}', [AttachmentAPIController::class, 'show'])->name('attachments.show');
            Route::get('/attachments', [AttachmentAPIController::class, 'index'])->name('attachments.index');
            Route::post('/attachments', [AttachmentAPIController::class, 'update'])->name('attachments.store');
            Route::delete('/attachments/{id}', [AttachmentAPIController::class, 'destroy'])->name('attachments.destroy');
            Route::get('/attachment-details/{id}', [AttachmentAPIController::class, 'getAttachmentDetails'])->name('attachment-details');
            Route::post('/attachment/permission/{id}', [AttachmentAPIController::class, 'processAttachmentPermission'])->name('attachment-process-permissions');
            Route::post('/attachment-rename/{id}', [AttachmentAPIController::class, 'renameAttachment'])->name('attachment-rename');

            // users
            Route::get('/users', [UserController::class, 'index'])->name('users.index');
            Route::get('/user/{id}', [UserController::class, 'show'])->name('user.show');
            Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
        });
    }

    public function api_public_routes()
    {
        Route::name('fc-api.')->prefix('fc-api')->group(function () {

            Route::resource('ratings', \Hasob\FoundationCore\Controllers\API\RatingAPIController::class);
            Route::resource('reactions', \Hasob\FoundationCore\Controllers\API\ReactionAPIController::class);

            //Multi Tenancy
            Route::get('/org-detect', [OrganizationController::class, 'detect'])->name('fc.org-detect');

            //Settings
            Route::get('/app-settings', [OrganizationController::class, 'app_settings'])->name('fc.app-settings');

        });

    }

    public function public_routes()
    {

        Route::name('fc.')->prefix('fc')->group(function () {
            Route::resource('ratings', \Hasob\FoundationCore\Controllers\RatingController::class);
            Route::resource('reactions', \Hasob\FoundationCore\Controllers\ReactionController::class);
        });

        //Site Display
        Route::get('/page/{id}', [SiteDisplayController::class, 'displayPublicPage'])->name('fc.site-display.page');
        Route::get('/public/{id}', [SiteDisplayController::class, 'index'])->name('fc.site-display.index');
        Route::get('/pinfo', function () {phpinfo();})->name('fc.php-info');

        Route::get('/clear-cache', function () {
            \Artisan::call('cache:clear');
            \Artisan::call('config:cache');
            \Artisan::call('clear-compiled');
            \Artisan::call('optimize');
            return "Cache is cleared ... Check again";
        })->name('fc.clear-cache');

        //Multi Tenancy
        Route::get('/org-detect', [OrganizationController::class, 'detect'])->name('fc.org-detect');

        //Settings
        Route::get('/app-settings', [OrganizationController::class, 'app_settings'])->name('fc.app-settings');

        Route::get('/user/{id}/avatar', function ($id) {
            $user = \Hasob\FoundationCore\Models\User::find($id);
            $content_type = (new \finfo(FILEINFO_MIME))->buffer($user->profile_image);
            $response = response(trim($user->profile_image))->header('Content-Type', $content_type);
            ob_end_clean();
            return $response;
        })->name('fc.get-profile-picture');

        Route::get('/dept/{id}/avatar', function ($id) {
            $dept = \Hasob\FoundationCore\Models\Department::find($id);
            $content_type = (new \finfo(FILEINFO_MIME))->buffer($dept->logo_image);
            $response = response(trim($dept->logo_image))->header('Content-Type', $content_type);
            ob_end_clean();
            return $response;
        })->name('fc.get-dept-picture');

        Route::get('/attachment/{id}', [AttachmentController::class, 'show'])->name('fc.attachment.show');
    }

    public function routes()
    {
        Route::name('fc.')->prefix('fc')->group(function () {


            Route::get('/staff-directory', [StaffDirectoryController::class,'index'])->name('staff-directory');

            //Attachment Management
            Route::post('/attachment', [AttachmentController::class, 'update'])->name('attachment.store');
            Route::delete('/attachment/{id}', [AttachmentController::class, 'destroy'])->name('attachment.destroy');
            Route::get('/attachment-stats', [AttachmentController::class, 'displayAttachmentStats'])->name('attachment.stats');

            //Comments
            Route::post('/comment/add', [CommentController::class, 'update'])->name('comment-add');

            //Signatures
            Route::resource('signatures', \Hasob\FoundationCore\Controllers\SignatureController::class);
            Route::get('/signature-view/{id}', [\Hasob\FoundationCore\Controllers\SignatureController::class, 'displayUserSignature'])->name('signature.view-item');

            //Checklist
            Route::get('/checklists', [ChecklistController::class, 'index'])->name('checklists.index');
            Route::get('/checklist/{id}', [ChecklistController::class, 'index'])->name('checklist.show');
            Route::get('/checklist/{id}/edit', [ChecklistController::class, 'index'])->name('checklist.edit');
            Route::post('/checklist/{id}/edit', [ChecklistController::class, 'index'])->name('checklist.store');
            Route::post('/checklist/delete/{id}', [ChecklistController::class, 'deleteTemplateItem'])->name('checklist.delete');
            Route::post('/checklist-template', [ChecklistController::class, 'updateTemplate'])->name('checklist-template.store');
            Route::post('/checklist-template-item', [ChecklistController::class, 'updateTemplateItem'])->name('checklist-template-item.store');

            //Resource Routes
            Route::resource('departments', DepartmentController::class);
            Route::post('/department-units', [DepartmentController::class, 'processDepartmentUnitSave'])->name('department.units');
            Route::get('/departments/{id}/settings', [DepartmentController::class, 'show_settings'])->name('departments.settings');
            Route::post('/select/member/{id}', [DepartmentController::class, 'processMemberSelection'])->name('select-members');

            Route::resource('ledgers', LedgerController::class);
            Route::resource('sites', SiteController::class);
            Route::get('/site/{id}', [SiteController::class, 'displaySite'])->name('site-display');
            Route::get('/site/{site_id}/page/{page_id}', [SiteController::class, 'displayPage'])->name('page-display');

            Route::resource('tags', TagController::class);
            Route::resource('supports', SupportController::class);
            Route::resource('announcements', AnnouncementController::class);
            Route::resource('socials', SocialController::class);
            Route::resource('settings', \Hasob\FoundationCore\Controllers\SettingController::class);
            Route::resource('pages', \Hasob\FoundationCore\Controllers\PageController::class);
            Route::resource('siteArtifacts', \Hasob\FoundationCore\Controllers\SiteArtifactController::class);
            Route::resource('addresses', \Hasob\FoundationCore\Controllers\AddressController::class);
            Route::resource('batches', \Hasob\FoundationCore\Controllers\BatchController::class);
            Route::resource('batchItems', \Hasob\FoundationCore\Controllers\BatchItemController::class);
            Route::resource('paymentDetails', \Hasob\FoundationCore\Controllers\PaymentDetailController::class);
            Route::resource('relationships', \Hasob\FoundationCore\Controllers\RelationshipController::class);

            Route::resource('documentGenerationTemplates', \Hasob\FoundationCore\Controllers\DocumentGenerationTemplateController::class);
            Route::resource('modelDocuments', \Hasob\FoundationCore\Controllers\ModelDocumentController::class);

            Route::resource('disabledItems', \Hasob\FoundationCore\Controllers\DisabledItemController::class);
            Route::resource('tags', \Hasob\FoundationCore\Controllers\TagController::class);
            Route::resource('taggables', \Hasob\FoundationCore\Controllers\TaggableController::class);
            Route::resource('api_tokens', \Hasob\FoundationCore\Controllers\APITokenController::class);
            Route::resource('modelArtifacts', \Hasob\FoundationCore\Controllers\ModelArtifactController::class);
            Route::resource('gateWayPaymentDetails', \Hasob\FoundationCore\Controllers\GateWayPaymentDetailController::class);
            Route::resource('paymentDisbursements', \Hasob\FoundationCore\Controllers\PaymentDisbursementController::class);
            //Document Manager 
            Route::get('/dmgr/preview/{template_id}', [\Hasob\FoundationCore\Controllers\DocumentGeneratorController::class, 'processPDFPreview'])->name('dmgr-preview-render');
            Route::post('/dmgr/save/{template_id}', [\Hasob\FoundationCore\Controllers\DocumentGeneratorController::class, 'processFileSave'])->name('dmgr-file-save');


            //User Management
            Route::get('/profile', [UserController::class, 'profile'])->name('users.profile');
            Route::get('/users', [UserController::class, 'index'])->name('users.index');
            Route::get('/user/{id}', [UserController::class, 'show'])->name('user.show');
            Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
            Route::get('/user/{id}/delete', [UserController::class, 'delete'])->name('user.delete');
            Route::post('/user/{id}', [UserController::class, 'update'])->name('user.store');
            Route::put('/user/{id}/disable', [UserController::class, 'disable'])->name('user.disable');
            Route::put('/user/reset-password/{id}', [UserController::class, 'resetPassword'])->name('user.reset-password');

            //Role Management
            Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
            Route::get('/role/{id}', [RoleController::class, 'show'])->name('role.show');
            Route::get('/role/{id}/edit', [RoleController::class, 'edit'])->name('role.edit');
            Route::get('/role/{id}/delete', [RoleController::class, 'delete'])->name('role.delete');
            Route::post('/role/{id}', [RoleController::class, 'update'])->name('role.store');

            //Profile Management
            Route::post('/profile/picture', [UserController::class, 'uploadProfilePicture'])->name('upload-profile-picture');
            Route::post('/profile/availability', [UserController::class, 'modifyUserAvailability'])->name('user-availability');

            //Org settings
            Route::resource('organizations', OrganizationController::class);
            Route::resource('settings', SettingController::class);
            Route::get('/org-domains', [OrganizationController::class, 'displayDomains'])->name('org-domains');
            Route::get('/org-settings', [OrganizationController::class, 'displaySettings'])->name('org-settings');
            Route::get('/org-features', [OrganizationController::class, 'displayFeatures'])->name('org-features');
            Route::post('/org-features', [OrganizationController::class, 'processFeatures'])->name('org-features-process');

        });

    }

}
