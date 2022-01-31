<?php
namespace Hasob\FoundationCore;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

use Hasob\FoundationCore\Models\Site;
use Hasob\FoundationCore\Models\User;
use Hasob\FoundationCore\Models\Ledger;
use Hasob\FoundationCore\Models\Setting;
use Hasob\FoundationCore\Models\Department;
use Hasob\FoundationCore\Models\Organization;

use Hasob\FoundationCore\Managers\OrganizationManager;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Exceptions\RoleDoesNotExist;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;

use Hasob\FoundationCore\Controllers\TagController;
use Hasob\FoundationCore\Controllers\PageController;
use Hasob\FoundationCore\Controllers\SiteController;
use Hasob\FoundationCore\Controllers\UserController;
use Hasob\FoundationCore\Controllers\RoleController;
use Hasob\FoundationCore\Controllers\SocialController;
use Hasob\FoundationCore\Controllers\LedgerController;
use Hasob\FoundationCore\Controllers\SettingController;
use Hasob\FoundationCore\Controllers\CommentController;
use Hasob\FoundationCore\Controllers\ChecklistController;
use Hasob\FoundationCore\Controllers\DepartmentController;
use Hasob\FoundationCore\Controllers\AttachmentController;
use Hasob\FoundationCore\Controllers\SiteDisplayController;
use Hasob\FoundationCore\Controllers\OrganizationController;

class FoundationCore
{

    public function all_users(Organization $org = null){
        return User::all_users($org);
    }

    public function all_departments(Organization $org = null){
        return Department::all_departments($org);
    }

    public function all_ledgers(Organization $org = null){
        return Ledger::all_ledgers($org);
    }

    public function all_sites(Organization $org = null){
        return Site::all_sites($org);
    }

    public function enabled_features(Organization $org){

        $enabled = [];
        if ($org != null){       
            $features = $org->get_features();
            foreach($features as $key=>$feature){
                if ($feature){
                    $enabled[]=$key;
                }
            }
        }

        return $enabled;
    }

    public function has_feature($feature, Organization $org){

        if ($org != null){       
            $features = $org->get_features();
            if (isset($features[$feature])){
                return $features[$feature]==true;
            }
        }

        return false;
    }

    public function get_setting(Organization $org, $key){

        if (Schema::hasTable('fc_settings')){    
            if ($org != null){
                $record = Setting::where(['organization_id'=>$org->id,'key'=>$key])->first();
                if ($record != null){
                    return $record;
                }
            }
        }
        return null;
    }

    public function register_setting(Organization $org, $key, $group_name, $display_type, $display_name, $owner_feature, $display_ordinal=1){

        if (Schema::hasTable('fc_settings')){    
            if ($org != null){
                $record = Setting::where(['organization_id'=>$org->id,'key'=>$key])->first();
                if ($record == null){
                    Setting::create([
                        'organization_id'=>$org->id,
                        'display_ordinal'=>$display_ordinal,
                        'group_name'=>$group_name,
                        'display_name'=>$display_name,
                        'display_type'=>$display_type,
                        'owner_feature'=>$owner_feature,
                        'key'=>$key
                    ]);
                }
            }
        }

    }

    public function register_roles($roles_list){

        if (Schema::hasTable('roles')){    
            app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
            
            foreach ($roles_list as $role=>$permissions) {
                try{
                    $dbRole = Role::findByName($role);
                }catch(RoleDoesNotExist $e) {
                    $dbRole = Role::create(['name'=>$role]);
                }
                foreach ($permissions as $permission){
                    try{
                        $dbPerm = Permission::findByName($permission);
                    }catch(PermissionDoesNotExist $e) {
                        $dbPerm = Permission::create(['name'=>$permission]);
                    }
                    $dbRole->givePermissionTo($permission);
                }
            }
        }
    }

    public function api_routes(){
        Route::name('fc-api.')->prefix('fc-api')->group(function(){
            Route::resource('settings', \Hasob\FoundationCore\Controllers\API\SettingAPIController::class);
            Route::resource('sites', \Hasob\FoundationCore\Controllers\API\SiteAPIController::class);
            Route::resource('pages', \Hasob\FoundationCore\Controllers\API\PageAPIController::class);
            Route::resource('siteArtifacts', \Hasob\FoundationCore\Controllers\API\SiteArtifactAPIController::class);
        });
    }

    public function api_public_routes(){

        //Multi Tenancy
        Route::get('/org-detect',[OrganizationController::class,'detect'])->name('fc.org-detect');

        //Settings
        Route::get('/app-settings',[OrganizationController::class,'app_settings'])->name('fc.app-settings');

    }

    public function public_routes(){
        //Site Display
        Route::get('/public/{id}', [SiteDisplayController::class, 'index'])->name('fc.site-display.index');
        Route::get('/phpinfo', function () { phpinfo(); })->name('fc.php-info');

        Route::get('/clear-cache', function() {
            \Artisan::call('cache:clear');
            \Artisan::call('config:cache');
            \Artisan::call('clear-compiled');
            \Artisan::call('optimize');
            return "Cache is cleared ... Check again";
        })->name('fc.clear-cache');

        //Multi Tenancy
        Route::get('/org-detect',[OrganizationController::class,'detect'])->name('fc.org-detect');

        //Settings
        Route::get('/app-settings',[OrganizationController::class,'app_settings'])->name('fc.app-settings');
    }

    public function routes(){

        Route::name('fc.')->prefix('fc')->group(function(){

            //Attachment Management
            Route::get('/attachment/{id}', [AttachmentController::class, 'show'])->name('attachment.show');
            Route::post('/attachment', [AttachmentController::class, 'update'])->name('attachment.store');

            //Comments
            Route::post('/comment/add', [CommentController::class, 'update'])->name('comment-add');

            //Checklist
            Route::get('/checklists', [ChecklistController::class, 'index'])->name('checklists.index');
            Route::get('/checklist/{id}', [ChecklistController::class, 'index'])->name('checklist.show');
            Route::get('/checklist/{id}/edit', [ChecklistController::class, 'index'])->name('checklist.edit');
            Route::post('/checklist/{id}/edit', [ChecklistController::class, 'index'])->name('checklist.store');
            Route::post('/checklist/{id}/delete', [ChecklistController::class, 'index'])->name('checklist.delete');
            Route::post('/checklist-template', [ChecklistController::class, 'updateTemplate'])->name('checklist-template.store');
            Route::post('/checklist-template-item', [ChecklistController::class, 'updateTemplateItem'])->name('checklist-template-item.store');

            //Resource Routes
            Route::resource('departments', DepartmentController::class);
            Route::resource('ledgers', LedgerController::class);
            Route::resource('sites', SiteController::class);
            Route::resource('tags', TagController::class);
            Route::resource('socials', SocialController::class);
            Route::resource('settings', \Hasob\FoundationCore\Controllers\SettingController::class);
            Route::resource('pages', \Hasob\FoundationCore\Controllers\PageController::class);
            Route::resource('siteArtifacts', \Hasob\FoundationCore\Controllers\SiteArtifactController::class);

            //User Management
            Route::get('/profile', [UserController::class, 'profile'])->name('users.profile');
            Route::get('/users', [UserController::class, 'index'])->name('users.index');
            Route::get('/user/{id}', [UserController::class, 'show'])->name('user.show');
            Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
            Route::get('/user/{id}/delete', [UserController::class, 'delete'])->name('user.delete');
            Route::post('/user/{id}', [UserController::class, 'update'])->name('user.store');

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
            Route::get('/org-domains',[OrganizationController::class,'displayDomains'])->name('org-domains');
            Route::get('/org-settings',[OrganizationController::class,'displaySettings'])->name('org-settings');
            Route::get('/org-features',[OrganizationController::class,'displayFeatures'])->name('org-features');
            Route::post('/org-features',[OrganizationController::class,'processFeatures'])->name('org-features-process');


            Route::get('/user/{id}/avatar', function ($id) {
                $user = \Hasob\FoundationCore\Models\User::find($id);
                $content_type = (new \finfo(FILEINFO_MIME))->buffer($user->profile_image);
                $response = response(trim($user->profile_image))->header('Content-Type', $content_type);
                ob_end_clean();
                return $response;
            })->name('get-profile-picture');
                
            Route::get('/dept/{id}/avatar', function ($id) {
                $dept = \Hasob\FoundationCore\Models\Department::find($id);
                $content_type = (new \finfo(FILEINFO_MIME))->buffer($dept->logo_image);
                $response = response(trim($dept->logo_image))->header('Content-Type', $content_type);
                ob_end_clean();
                return $response;
            })->name('get-dept-picture');

        });

    }

}