<?php
namespace Hasob\FoundationCore;

use Carbon\Carbon;
use Hash;
use Hasob\FoundationCore\Managers\OrganizationManager;
use Hasob\FoundationCore\Models\Department;
use Hasob\FoundationCore\Models\Organization;
use Hasob\FoundationCore\Models\Setting;
use Hasob\FoundationCore\Models\User;
use Hasob\FoundationCore\Providers\FoundationCoreEventServiceProvider;
use Hasob\FoundationCore\Providers\OrganizationServiceProvider;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Publishes configuration file.
     *
     * @return  void
     */
    public function boot()
    {
        $configPath = __DIR__ . '/../config/hasob-foundation-core.php';
        $this->publishes([$configPath => $this->getConfigPath()], 'config');

        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'hasob-foundation-core');

        // Publish view files
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/hasob-foundation-core'),
        ], 'views');

        // Publish assets
        $this->publishes([
            __DIR__ . '/../resources/assets' => public_path('hasob-foundation-core'),
        ], 'assets');

        // Publish view components
        $this->publishes([
            __DIR__ . '/../src/View/Components/' => app_path('View/Components'),
            __DIR__ . '/../resources/views/components/' => resource_path('views/components'),
        ], 'view-components');

        $this->publishes([
            __DIR__ . '/../database/seeders/FoundationCoreSeeder.php' => database_path('seeders/FoundationCoreSeeder.php'),
        ], 'seeders');

        Blade::componentNamespace('Hasob\\FoundationCore\\View\\Components', 'hasob-foundation-core');

        $this->registerSecurityRoles();
        $this->initializeOrganization();
        $this->registerSettings();
    }

    /**
     * Make config publishing optional by merging the config from the package.
     *
     * @return  void
     */
    public function register()
    {
        $configPath = __DIR__ . '/../config/hasob-foundation-core.php';
        $this->mergeConfigFrom($configPath, 'hasob-foundation-core');

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->app->bind('FoundationCore', function ($app) {
            return new FoundationCore();
        });
        $this->app->bind('FoundationCoreUserService', function ($app) {
            return new FoundationCoreUserService();
        });
        $this->app->bind('FoundationCoreSiteManagerService', function ($app) {
            return new FoundationCoreSiteManagerService();
        });

        $this->app->register(OrganizationServiceProvider::class);
        $this->app->register(FoundationCoreEventServiceProvider::class);

    }

    private function initializeOrganization()
    {

        if (Schema::hasTable('fc_organizations')) {

            //Create default organization
            $default_org_id = null;
            if (DB::table('fc_organizations')->count() == 0) {
                $default_org_id = Organization::create([
                    'org' => 'app',
                    'domain' => 'test',
                    'full_url' => 'www.app.test',
                    'subdomain' => 'sub',
                    'is_local_default_organization' => true,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ])->id;
            } else {
                $default_org_id = DB::table('fc_organizations')->where('is_local_default_organization', true)->select('id')->first()->id;
            }

            if (Schema::hasTable('fc_departments')) {
                //Create home department
                if (DB::table('fc_departments')->count() == 0) {
                    $fc_department_id = Department::create([
                        'key' => 'home',
                        'long_name' => 'Home',
                        'email' => 'home@app.com',
                        'telephone' => '07085554141',
                        'physical_location' => 'Ground Floor',
                        'organization_id' => $default_org_id,
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ])->id;
                }
            }

            if (Schema::hasTable('fc_users')) {
                //Create user accounts
                if (DB::table('fc_users')->where('email', 'admin@app.com')->first() == null) {
                    $platform_admin_id = User::create([
                        'email' => 'admin@app.com',
                        'telephone' => '07063321200',
                        'password' => Hash::make('password'),
                        'first_name' => 'Admin',
                        'last_name' => 'Admin',
                        'organization_id' => $default_org_id,
                        'last_loggedin_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ])->id;

                    $usr = User::where('email', 'admin@app.com')->first();
                    if ($usr != null) {$usr->assignRole('admin');}
                }
            }

        }
    }

    public function registerSettings()
    {

        $app_settings = [

            'portal_long_name' => ['group_name' => 'Application', 'display_type' => 'string', 'display_name' => 'Business Name', 'display_ordinal' => 2],
            'portal_short_name' => ['group_name' => 'Application', 'display_type' => 'string', 'display_name' => 'Business Abbreviation', 'display_ordinal' => 3],
            'portal_official_website' => ['group_name' => 'Application', 'display_type' => 'string', 'display_name' => 'Official Business Website', 'display_ordinal' => 4],
            'portal_official_email' => ['group_name' => 'Application', 'display_type' => 'email', 'display_name' => 'Official Business Email', 'display_ordinal' => 5],
            'portal_official_phone' => ['group_name' => 'Application', 'display_type' => 'number', 'display_name' => 'Official Business Phone Number', 'display_ordinal' => 6],
            'portal_official_address' => ['group_name' => 'Application', 'display_type' => 'string', 'display_name' => 'Official Business Address', 'display_ordinal' => 7],

            'portal_app_name' => ['group_name' => 'Portal', 'display_type' => 'string', 'display_name' => 'Application Name', 'display_ordinal' => 1],
            'portal_contact_name' => ['group_name' => 'Portal', 'display_type' => 'string', 'display_name' => 'Contact Name on Portal Support', 'display_ordinal' => 2],
            'portal_contact_phone' => ['group_name' => 'Portal', 'display_type' => 'string', 'display_name' => 'Contact Phone Number on Portal Support', 'display_ordinal' => 3],
            'portal_contact_email' => ['group_name' => 'Portal', 'display_type' => 'string', 'display_name' => 'Contact Email on Portal Support', 'display_ordinal' => 4],
            'portal_theme_color_primary' => ['group_name' => 'Portal', 'display_type' => 'string', 'display_name' => 'Primary color theme for Portal', 'display_ordinal' => 5],
            'portal_theme_color_secondary' => ['group_name' => 'Portal', 'display_type' => 'string', 'display_name' => 'Secondary color theme for Portal', 'display_ordinal' => 6],

            'portal_email_sender_name' => ['group_name' => 'Portal', 'display_type' => 'string', 'display_name' => 'Name for Sending Email', 'display_ordinal' => 7],
            'portal_email_sender_email' => ['group_name' => 'Portal', 'display_type' => 'string', 'display_name' => 'Email Address for Sending Email', 'display_ordinal' => 8],

            'portal_welcome_title' => ['group_name' => 'Portal Text', 'display_type' => 'textarea', 'display_name' => 'Welcome title text on Landing Page of Portal', 'display_ordinal' => 0],
            'portal_welcome_text' => ['group_name' => 'Portal Text', 'display_type' => 'textarea', 'display_name' => 'Welcome text on Landing Page of Portal', 'display_ordinal' => 1],
            'portal_login_text' => ['group_name' => 'Portal Text', 'display_type' => 'textarea', 'display_name' => 'Text on Login Page', 'display_ordinal' => 2],
            'portal_registration_text' => ['group_name' => 'Portal Text', 'display_type' => 'textarea', 'display_name' => 'Text on Registration Page', 'display_ordinal' => 3],
            'portal_footer_title' => ['group_name' => 'Portal Text', 'display_type' => 'textarea', 'display_name' => 'Footer title on Landing Page of Portal', 'display_ordinal' => 4],
            'portal_footer_text' => ['group_name' => 'Portal Text', 'display_type' => 'textarea', 'display_name' => 'Footer text on Landing Page of Portal', 'display_ordinal' => 5],

            'portal_file_high_res_picture' => ['group_name' => 'Portal Graphics', 'display_type' => 'file-select', 'display_name' => 'High Resolution Image of Portal Logo', 'display_ordinal' => 1],
            'portal_file_icon_picture' => ['group_name' => 'Portal Graphics', 'display_type' => 'file-select', 'display_name' => 'Icon Image of Portal', 'display_ordinal' => 2],
            'portal_file_landing_page_picture' => ['group_name' => 'Portal Graphics', 'display_type' => 'file-select', 'display_name' => 'Image on Landing Page of Portal', 'display_ordinal' => 3],

            'portal_seo_description' => ['group_name' => 'Tracking & SEO', 'display_type' => 'string', 'display_name' => 'SEO Description', 'display_ordinal' => 1],
            'portal_seo_keywords' => ['group_name' => 'Tracking & SEO', 'display_type' => 'string', 'display_name' => 'SEO Keywords', 'display_ordinal' => 2],
            'portal_analytics_code' => ['group_name' => 'Tracking & SEO', 'display_type' => 'textarea', 'display_name' => 'Tracking Embed Code', 'display_ordinal' => 3],

            'push_notification_enabled' => ['group_name' => 'Push Notification', 'display_type' => 'boolean', 'display_name' => 'Enable Push Notification', 'display_ordinal' => 0],
            'firebase_messaging_key' => ['group_name' => 'Push Notification', 'display_type' => 'string', 'display_name' => 'Firebase Cloud Messaging Key', 'display_ordinal' => 1],
            'firebase_api_key' => ['group_name' => 'Push Notification', 'display_type' => 'string', 'display_name' => 'API Key', 'display_ordinal' => 2],
            'firebase_auth_domain' => ['group_name' => 'Push Notification', 'display_type' => 'string', 'display_name' => 'Auth Domain', 'display_ordinal' => 3],
            'firebase_database_url' => ['group_name' => 'Push Notification', 'display_type' => 'string', 'display_name' => 'Database URL', 'display_ordinal' => 4],
            'firebase_project_id' => ['group_name' => 'Push Notification', 'display_type' => 'string', 'display_name' => 'Project ID', 'display_ordinal' => 5],
            'firebase_storage_bucket' => ['group_name' => 'Push Notification', 'display_type' => 'string', 'display_name' => 'Storage Bucket', 'display_ordinal' => 6],
            'firebase_sender_id' => ['group_name' => 'Push Notification', 'display_type' => 'string', 'display_name' => 'Sender ID', 'display_ordinal' => 7],
            'firebase_application_id' => ['group_name' => 'Push Notification', 'display_type' => 'string', 'display_name' => 'Application ID', 'display_ordinal' => 8],
            'firebase_measurement_id' => ['group_name' => 'Push Notification', 'display_type' => 'string', 'display_name' => 'Measurement ID', 'display_ordinal' => 9],

            'auth_social_enabled' => ['group_name' => 'Social Authentication', 'display_type' => 'boolean', 'display_name' => 'Enable Social Authentication', 'display_ordinal' => 0],
            'auth_facebook_enabled' => ['group_name' => 'Social Authentication', 'display_type' => 'boolean', 'display_name' => 'Enable Facebook Authentication', 'display_ordinal' => 1],
            'auth_facebook_app_id' => ['group_name' => 'Social Authentication', 'display_type' => 'string', 'display_name' => 'Facebook Application ID', 'display_ordinal' => 2],
            'auth_facebook_secret' => ['group_name' => 'Social Authentication', 'display_type' => 'string', 'display_name' => 'Facebook Application Secret', 'display_ordinal' => 3],
            'auth_twitter_enabled' => ['group_name' => 'Social Authentication', 'display_type' => 'boolean', 'display_name' => 'Enable Twitter Authentication', 'display_ordinal' => 4],
            'auth_twitter_app_id' => ['group_name' => 'Social Authentication', 'display_type' => 'string', 'display_name' => 'Twitter Application ID', 'display_ordinal' => 5],
            'auth_twitter_secret' => ['group_name' => 'Social Authentication', 'display_type' => 'string', 'display_name' => 'Twitter Application Secret', 'display_ordinal' => 6],
            'auth_google_enabled' => ['group_name' => 'Social Authentication', 'display_type' => 'boolean', 'display_name' => 'Enable Google Authentication', 'display_ordinal' => 7],
            'auth_google_app_id' => ['group_name' => 'Social Authentication', 'display_type' => 'string', 'display_name' => 'Google Application ID', 'display_ordinal' => 8],
            'auth_google_secret' => ['group_name' => 'Social Authentication', 'display_type' => 'string', 'display_name' => 'Google Application Secret', 'display_ordinal' => 9],

            'attachment_storage' => ['group_name' => 'Attachment Settings', 'display_type' => 'radio', 'display_name' => 'Attachment Storage', 'display_ordinal' => 0, 'display_type_options' => 'Local,Cloud', 'value' => 'Local'],
            'attachment_cloud_storage_type' => ['group_name' => 'Attachment Settings', 'display_type' => 'option-select', 'display_name' => 'Cloud Storage Type', 'display_ordinal' => 1, 'display_type_options' => 's3,azure,ftp'],
            'attachment_cloud_storage_id' => ['group_name' => 'Attachment Settings', 'display_type' => 'string', 'display_name' => 'Cloud Storage ID', 'display_ordinal' => 2],
            'attachment_cloud_storage_secret' => ['group_name' => 'Attachment Settings', 'display_type' => 'string', 'display_name' => 'Cloud Storage Secret Key', 'display_ordinal' => 3],
            'attachment_cloud_storage_bucket' => ['group_name' => 'Attachment Settings', 'display_type' => 'string', 'display_name' => 'Cloud Storage Bucket', 'display_ordinal' => 4],
            'attachment_cloud_storage_region' => ['group_name' => 'Attachment Settings', 'display_type' => 'string', 'display_name' => 'Cloud Storage Default Region', 'display_ordinal' => 5],
            'attachment_cloud_storage_endpoint' => ['group_name' => 'Attachment Settings', 'display_type' => 'string', 'display_name' => 'Cloud Storage End-Point', 'display_ordinal' => 6],

            'tp_chief_lecturer_dta_amount' => ['group_name' => 'ASTD Settings', 'display_type' => 'string', 'display_name' => 'Teaching Practice Chief Lecturer DTA Amount', 'display_ordinal' => 0],
            'tp_principal_lecturer_dta_amount' => ['group_name' => 'ASTD Settings', 'display_type' => 'string', 'display_name' => 'Teaching Practice Principal Lecturer DTA Amount', 'display_ordinal' => 1],
            'tp_senior_lecturer_dta_amount' => ['group_name' => 'ASTD Settings', 'display_type' => 'string', 'display_name' => 'Teaching Practice Senior Lecturer DTA Amount', 'display_ordinal' => 2],
            'tp_lecturer_1_dta_amount' => ['group_name' => 'ASTD Settings', 'display_type' => 'string', 'display_name' => 'Teaching Practice Lecturer 1 DTA Amount', 'display_ordinal' => 3],
            'tp_lecturer_2_dta_amount' => ['group_name' => 'ASTD Settings', 'display_type' => 'string', 'display_name' => 'Teaching Practice Lecturer 2 DTA Amount', 'display_ordinal' => 4],

            'tp_chief_lecturer_dta_nights_amount' => ['group_name' => 'ASTD Settings', 'display_type' => 'string', 'display_name' => 'Teaching Practice Chief Lecturer DTA Nights Amount', 'display_ordinal' => 0],
            'tp_principal_lecturer_dta_nights_amount' => ['group_name' => 'ASTD Settings', 'display_type' => 'string', 'display_name' => 'Teaching Practice Principal Lecturer DTA Nights Amount', 'display_ordinal' => 1],
            'tp_senior_lecturer_dta_nights_amount' => ['group_name' => 'ASTD Settings', 'display_type' => 'string', 'display_name' => 'Teaching Practice Senior Lecturer DTA Nights Amount', 'display_ordinal' => 2],
            'tp_lecturer_1_dta_nights_amount' => ['group_name' => 'ASTD Settings', 'display_type' => 'string', 'display_name' => 'Teaching Practice Lecturer 1 DTA Nights Amount', 'display_ordinal' => 3],
            'tp_lecturer_2_dta_nights_amount' => ['group_name' => 'ASTD Settings', 'display_type' => 'string', 'display_name' => 'Teaching Practice Lecturer 2 DTA Nights Amount', 'display_ordinal' => 4],

            'tp_chief_lecturer_local_runs_amount' => ['group_name' => 'ASTD Settings', 'display_type' => 'string', 'display_name' => 'Teaching Practice Chief Lecturer Local Running Amount', 'display_ordinal' => 5],
            'tp_principal_lecturer_local_runs_amount' => ['group_name' => 'ASTD Settings', 'display_type' => 'string', 'display_name' => 'Teaching Practice Principal Lecturer Local Running Amount', 'display_ordinal' => 6],
            'tp_senior_lecturer_local_runs_amount' => ['group_name' => 'ASTD Settings', 'display_type' => 'string', 'display_name' => 'Teaching Practice Senior Lecturer Local Running Amount', 'display_ordinal' => 7],
            'tp_lecturer_1_local_runs_amount' => ['group_name' => 'ASTD Settings', 'display_type' => 'string', 'display_name' => 'Teaching Practice Lecturer 1 Local Running Amount', 'display_ordinal' => 8],
            'tp_lecturer_2_local_runs_amount' => ['group_name' => 'ASTD Settings', 'display_type' => 'string', 'display_name' => 'Teaching Practice Lecturer 2 Local Running Amount', 'display_ordinal' => 9],

            'tp_chief_lecturer_taxi_fare_amount' => ['group_name' => 'ASTD Settings', 'display_type' => 'string', 'display_name' => 'Teaching Practice Chief Lecturer Taxi Fare Amount', 'display_ordinal' => 10],
            'tp_principal_lecturer_taxi_fare_amount' => ['group_name' => 'ASTD Settings', 'display_type' => 'string', 'display_name' => 'Teaching Practice Principal Lecturer Taxi Fare Amount', 'display_ordinal' => 11],
            'tp_senior_lecturer_taxi_fare_amount' => ['group_name' => 'ASTD Settings', 'display_type' => 'string', 'display_name' => 'Teaching Practice Senior Lecturer Taxi Fare Amount', 'display_ordinal' => 12],
            'tp_lecturer_1_taxi_fare_amount' => ['group_name' => 'ASTD Settings', 'display_type' => 'string', 'display_name' => 'Teaching Practice Lecturer 1 Taxi Fare Amount', 'display_ordinal' => 13],
            'tp_lecturer_2_taxi_fare_amount' => ['group_name' => 'ASTD Settings', 'display_type' => 'string', 'display_name' => 'Teaching Practice Lecturer 2 Taxi Fare Amount', 'display_ordinal' => 14],
        ];

        if (Schema::hasTable('fc_organizations') && Schema::hasTable('fc_settings')) {

            $host = request()->getHost();
            $manager = new OrganizationManager();
            $org = $manager->loadTenant($host);

            if ($org != null) {

                foreach ($app_settings as $key => $setting) {
                    \FoundationCore::register_setting(
                        $org,
                        $key,
                        $setting['group_name'],
                        $setting['display_type'],
                        $setting['display_name'],
                        "app_settings",
                        $setting['display_ordinal'],
                        isset($setting['display_type_options']) ? $setting['display_type_options'] : null,
                        isset($setting['value']) ? $setting['value'] : null
                    );
                }

                $setting_list = Setting::whereIn('key', array_keys($app_settings))->get();

                $app_setting_values = $setting_list->mapWithKeys(function ($item, $key) {
                    return [$item->key => $item->value];
                });

                $attachment_storage_type = $app_setting_values['attachment_storage'];

                if ($attachment_storage_type != null && $attachment_storage_type == "Cloud") {
                    
                   

                    if ($app_setting_values['attachment_cloud_storage_type'] == 's3') {
                        $no_of_update = 0 ;
                        $access_key = env('AWS_ACCESS_KEY_ID');
                        $access_secret = env('AWS_SECRET_ACCESS_KEY');
                        $storage_bucket = env('AWS_BUCKET');
                        $storage_endpoint_url = env('AWS_ENDPOINT');
                        $storage_region = env('AWS_DEFAULT_REGION');

                        if($access_key == null || $access_secret == null ||  $storage_bucket == null || $storage_endpoint_url == null ){
                            $this->clearConfig();
                        }

                        if ($access_key != $app_setting_values['attachment_cloud_storage_id']) {
                            $this->setEnv('AWS_ACCESS_KEY_ID', $app_setting_values['attachment_cloud_storage_id']);                      
                           // dd($access_key);
                           $no_of_update++;
                        }
                        
                       
                        if ($access_secret != $app_setting_values['attachment_cloud_storage_secret']) {
                            $this->setEnv('AWS_SECRET_ACCESS_KEY', $app_setting_values['attachment_cloud_storage_secret']);
                            $no_of_update++;                     
                        }
                        if ($storage_bucket != $app_setting_values['attachment_cloud_storage_bucket']) {
                            $this->setEnv('AWS_BUCKET', $app_setting_values['attachment_cloud_storage_bucket']);   
                            $no_of_update++;                  
                        }
                        if ($storage_endpoint_url != $app_setting_values['attachment_cloud_storage_endpoint']) {
                            $this->setEnv('AWS_ENDPOINT', $app_setting_values['attachment_cloud_storage_endpoint']); 
                            $no_of_update++;                     
                        }

                        if ($storage_region != $app_setting_values['attachment_cloud_storage_region']) {
                            $this->setEnv('AWS_DEFAULT_REGION', $app_setting_values['attachment_cloud_storage_region']); 
                            $no_of_update++;                     
                        }

                        if( $no_of_update > 0){
                            $this->cacheConfig();
                        }
                        
                    }

                }

                $primary_theme_color = "green";
                $secondary_theme_color = "red";
                if (isset($app_setting_values) && isset($app_setting_values['portal_theme_color_primary']) && !empty($app_setting_values['portal_theme_color_primary'])) {
                    $primary_theme_color = $app_setting_values['portal_theme_color_primary'];
                }
                if (isset($app_setting_values) && isset($app_setting_values['portal_theme_color_secondary']) && !empty($app_setting_values['portal_theme_color_secondary'])) {
                    $secondary_theme_color = $app_setting_values['portal_theme_color_secondary'];
                }
                \View::share('app_settings', $app_setting_values);
                \View::share('secondary_theme_color', $secondary_theme_color);
                \View::share('primary_theme_color', $primary_theme_color);
            }

        }

    }
    public function cacheConfig(){
        \Artisan::call('config:cache');
    }
    public function clearConfig(){
        \Artisan::call('config:clear');
    }
    public function setEnv($key,$value){

        $env_path = app()->environmentFilePath();
        file_put_contents($env_path, str_replace(
            $key . '=' . env($key),
            $key . '=' . $value,
            file_get_contents($env_path)
        ));
    }
    public function registerSecurityRoles()
    {

        //Roles in this application with their roles.
        \FoundationCore::register_roles([
            'admin' => [],
            'doc-gen-admin' => [],
            'departments-admin' => [],
            'department-manager' => [],
            'ledgers-admin' => [],
            'ledger-manager' => [],
            'sites-admin' => [],
            'site-manager' => [],
            'personal-ledger' => [],
            'principal-officer' => [],
        ]);
    }

    /**
     * Get the active router.
     *
     * @return Router
     */
    protected function getRouter()
    {
        return $this->app['router'];
    }

    /**
     * Get the config path
     *
     * @return string
     */
    protected function getConfigPath()
    {
        return config_path('hasob-foundation-core.php');
    }

    /**
     * Publish the config file
     *
     * @param  string $configPath
     */
    protected function publishConfig($configPath)
    {
        $this->publishes([$configPath => config_path('hasob-foundation-core.php')], 'config');
    }

    /**
     * Register a Middleware
     *
     * @param  string $middleware
     */
    protected function registerMiddleware($middleware)
    {
        $kernel = $this->app[Kernel::class];
        $kernel->pushMiddleware($middleware);
    }
}
