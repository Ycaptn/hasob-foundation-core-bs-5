<?php
namespace Hasob\FoundationCore;

use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Hasob\FoundationCore\Models\User;
use Hasob\FoundationCore\Models\Site;
use Hasob\FoundationCore\Models\Ledger;
use Hasob\FoundationCore\Models\Department;
use Hasob\FoundationCore\Models\Organization;

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

    public function has_feature($feature, Organization $org){

        if ($org != null){       
            $features = $org->get_features();
            if (isset($features[$feature])){
                return $features[$feature]==true;
            }
        }

        return false;
    }

    public function api_routes()
    {

    }

    public function api_public_routes()
    {

    }

    public function public_routes()
    {
        //Site Display
        Route::get('/public/{id}', [SiteDisplayController::class, 'index'])->name('fc.site-display.index');
        Route::get('/phpinfo', function () { phpinfo(); })->name('fc.php-info');
    }

    public function routes()
    {

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
            Route::resource('pages', PageController::class);
            Route::resource('sites', SiteController::class);
            Route::resource('tags', TagController::class);
            Route::resource('socials', SocialController::class);

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


            //Multi Tenancy
            Route::get('/org-detect',[OrganizationController::class,'detect'])->name('org-detect');

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

            Route::get('/clear-cache', function() {
                Artisan::call('cache:clear');
                Artisan::call('config:cache');
                Artisan::call('clear-compiled');
                Artisan::call('optimize');
                return "Cache is cleared ... Check again";
            })->name('clear-cache');

        });

    }


}