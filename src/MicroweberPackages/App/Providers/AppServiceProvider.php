<?php

namespace MicroweberPackages\App\Providers;

use AlternativeLaravelCache\Provider\AlternativeCacheStoresServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use MicroweberPackages\App\Managers\Helpers\Lang;
use MicroweberPackages\App\Utils\Parser;
use MicroweberPackages\Cache\TaggableFileCacheServiceProvider;
use MicroweberPackages\Captcha\CaptchaManagerServiceProvider;
use MicroweberPackages\Category\CategoryManagerServiceProvider;
use MicroweberPackages\Config\ConfigSave;
use MicroweberPackages\Content\Content;
use MicroweberPackages\Content\ContentManagerServiceProvider;
use MicroweberPackages\Content\ContentServiceProvider;
use MicroweberPackages\Customer\CustomerServiceProvider;
use MicroweberPackages\Database\DatabaseManagerServiceProvider;
use MicroweberPackages\Event\EventManagerServiceProvider;
use MicroweberPackages\FileManager\FileManagerServiceProvider;
use MicroweberPackages\Form\FormsManagerServiceProvider;
use MicroweberPackages\Helper\Format;
use MicroweberPackages\Helper\HelpersServiceProvider;
use MicroweberPackages\Install\MicroweberMigrator;
use MicroweberPackages\Invoice\InvoicesManagerServiceProvider;
use MicroweberPackages\Media\Media;
use MicroweberPackages\Media\MediaManagerServiceProvider;
use MicroweberPackages\Menu\MenuManagerServiceProvider;
use MicroweberPackages\Module\ModuleServiceProvider;
use MicroweberPackages\Multilanguage\MultilanguageServiceProvider;
use MicroweberPackages\Option\OptionManagerServiceProvider;
use MicroweberPackages\Backup\BackupManagerServiceProvider;

// Shop
use MicroweberPackages\Cart\CartManagerServiceProvider;
use MicroweberPackages\Checkout\CheckoutManagerServiceProvider;
use MicroweberPackages\Client\ClientsManagerServiceProvider;
use MicroweberPackages\Currency\CurrencyServiceProvider;
use MicroweberPackages\Order\OrderManagerServiceProvider;
use MicroweberPackages\Page\PageServiceProvider;
use MicroweberPackages\Payment\PaymentServiceProvider;
use MicroweberPackages\Product\ProductServiceProvider;
use MicroweberPackages\ContentData\ContentDataServiceProvider;
use MicroweberPackages\CustomField\CustomFieldServiceProvider;
use MicroweberPackages\Role\RoleServiceProvider;
use MicroweberPackages\Shop\ShopManagerServiceProvider;
use MicroweberPackages\Tax\TaxManagerServiceProvider;

use MicroweberPackages\Tag\TagsManagerServiceProvider;
use MicroweberPackages\Template\TemplateManagerServiceProvider;
use MicroweberPackages\User\UserManagerServiceProvider;
use MicroweberPackages\Utils\Http\Http;
use MicroweberPackages\Utils\System\ClassLoader;
use Spatie\Permission\PermissionServiceProvider;

if (! defined('MW_VERSION')) {
    include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'functions' . DIRECTORY_SEPARATOR . 'bootstrap.php';
}

class AppServiceProvider extends ServiceProvider {

    protected $aliasInstance;

    /*
    * Application Service Providers...
    */
    public $laravel_providers = [

        /*
          * Laravel Framework Service Providers...
          */
      //  \Illuminate\Session\SessionServiceProvider::class,
      //  \Illuminate\Filesystem\FilesystemServiceProvider::class,
        \Illuminate\Auth\AuthServiceProvider::class,
        \Illuminate\Broadcasting\BroadcastServiceProvider::class,
        \Illuminate\Bus\BusServiceProvider::class,
        \Illuminate\Cache\CacheServiceProvider::class,
        \Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        \Illuminate\Cookie\CookieServiceProvider::class,
        \Illuminate\Database\DatabaseServiceProvider::class,
        \Illuminate\Encryption\EncryptionServiceProvider::class,
        \Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        \Illuminate\Hashing\HashServiceProvider::class,
        \Illuminate\Mail\MailServiceProvider::class,
        \Illuminate\Notifications\NotificationServiceProvider::class,
        \Illuminate\Pagination\PaginationServiceProvider::class,
        \Illuminate\Pipeline\PipelineServiceProvider::class,
        \Illuminate\Queue\QueueServiceProvider::class,
        \Illuminate\Redis\RedisServiceProvider::class,
        \Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        \Illuminate\Translation\TranslationServiceProvider::class,
        \Illuminate\Validation\ValidationServiceProvider::class,
        \Illuminate\View\ViewServiceProvider::class

    ];

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */

    public $laravel_aliases = [
        'App' => \Illuminate\Support\Facades\App::class,
        'Arr' => \Illuminate\Support\Arr::class,
        'Artisan' => \Illuminate\Support\Facades\Artisan::class,
        'Auth' => \Illuminate\Support\Facades\Auth::class,
        'Blade' => \Illuminate\Support\Facades\Blade::class,
        'Broadcast' => \Illuminate\Support\Facades\Broadcast::class,
        'Bus' => \Illuminate\Support\Facades\Bus::class,
        'Cache' => \Illuminate\Support\Facades\Cache::class,
        'Config' => \Illuminate\Support\Facades\Config::class,
        'Cookie' => \Illuminate\Support\Facades\Cookie::class,
        'Crypt' => \Illuminate\Support\Facades\Crypt::class,
        'DB' => \Illuminate\Support\Facades\DB::class,
        'Eloquent' => \Illuminate\Database\Eloquent\Model::class,
        'Event' => \Illuminate\Support\Facades\Event::class,
      //  'File' => \Illuminate\Support\Facades\File::class,
        'Gate' => \Illuminate\Support\Facades\Gate::class,
        'Hash' => \Illuminate\Support\Facades\Hash::class,
        'Http' => \Illuminate\Support\Facades\Http::class,
        'Lang' => \Illuminate\Support\Facades\Lang::class,
        'Log' => \Illuminate\Support\Facades\Log::class,
        'Mail' => \Illuminate\Support\Facades\Mail::class,
        'Notification' => \Illuminate\Support\Facades\Notification::class,
        'Password' => \Illuminate\Support\Facades\Password::class,
        'Queue' => \Illuminate\Support\Facades\Queue::class,
        'Redirect' => \Illuminate\Support\Facades\Redirect::class,
        'Redis' => \Illuminate\Support\Facades\Redis::class,
        'Request' => \Illuminate\Support\Facades\Request::class,
        'Response' => \Illuminate\Support\Facades\Response::class,
        'Route' => \Illuminate\Support\Facades\Route::class,
        'Schema' => \Illuminate\Support\Facades\Schema::class,
      //  'Session' => \Illuminate\Support\Facades\Session::class,
        'Storage' => \Illuminate\Support\Facades\Storage::class,
        'Str' => \Illuminate\Support\Str::class,
        'URL' => \Illuminate\Support\Facades\URL::class,
        'Validator' => \Illuminate\Support\Facades\Validator::class,
        'View' => \Illuminate\Support\Facades\View::class,
        'PDF' => \Barryvdh\DomPDF\Facade::class
    ];

    public function __construct($app)
    {
        ClassLoader::addDirectories([
            base_path() . DIRECTORY_SEPARATOR . 'userfiles' . DIRECTORY_SEPARATOR . 'modules',
            __DIR__,
        ]);

        ClassLoader::register();

        spl_autoload_register([$this, 'autoloadModules']);

        $this->aliasInstance = AliasLoader::getInstance();

        parent::__construct($app);
    }

    public function register() {

        $this->registerLaravelProviders();
        $this->registerLaravelAliases();
        $this->setEnvironmentDetection();
        $this->registerUtils();

        $this->registerSingletonProviders();
        $this->registerHtmlCollective();
        $this->registerMarkdown();

        $this->app->instance('config', new ConfigSave($this->app));

        $this->app->register(TaggableFileCacheServiceProvider::class);

        //$this->app->register(AlternativeCacheStoresServiceProvider::class);

        $this->app->register('Conner\Tagging\Providers\TaggingServiceProvider');
        $this->app->register(EventManagerServiceProvider::class);
        $this->app->register(HelpersServiceProvider::class);
        $this->app->register(  PageServiceProvider::class);
        $this->app->register(ContentServiceProvider::class);
        $this->app->register(ContentManagerServiceProvider::class);
        $this->app->register(CategoryManagerServiceProvider::class);
        $this->app->register(TagsManagerServiceProvider::class);
        $this->app->register(MediaManagerServiceProvider::class);
        $this->app->register(MenuManagerServiceProvider::class);
        $this->app->register(ProductServiceProvider::class);
        $this->app->register(ContentDataServiceProvider::class);
        $this->app->register(CustomFieldServiceProvider::class);

        // Shop
        $this->app->register(ShopManagerServiceProvider::class);
        $this->app->register(TaxManagerServiceProvider::class);
        $this->app->register(OrderManagerServiceProvider::class);
        $this->app->register(CurrencyServiceProvider::class);
        $this->app->register(ClientsManagerServiceProvider::class);
        $this->app->register(CheckoutManagerServiceProvider::class);
        $this->app->register(CartManagerServiceProvider::class);

        $this->app->register(FileManagerServiceProvider::class);
        $this->app->register(TemplateManagerServiceProvider::class);
        $this->app->register(FormsManagerServiceProvider::class);
        $this->app->register(UserManagerServiceProvider::class);
        $this->app->register(CaptchaManagerServiceProvider::class);
        $this->app->register(OptionManagerServiceProvider::class);
        $this->app->register(DatabaseManagerServiceProvider::class);
        $this->app->register(BackupManagerServiceProvider::class);
        $this->app->register(ModuleServiceProvider::class);
        $this->app->register(InvoicesManagerServiceProvider::class);
        $this->app->register(CustomerServiceProvider::class);
        $this->app->register(PermissionServiceProvider::class);
        $this->app->register(PaymentServiceProvider::class);
        $this->app->register(RoleServiceProvider::class);
        $this->app->register(  \Barryvdh\DomPDF\ServiceProvider::class);

        $this->aliasInstance->alias('Carbon', 'Carbon\Carbon');

    }

    protected function registerLaravelProviders()
    {
        $this->app->singleton('mw_migrator', function ($app) {
            $repository = $app['migration.repository'];
            return new MicroweberMigrator($repository, $app['db'], $app['files'], $app['events'], $app);
        });

        foreach ($this->laravel_providers as $provider) {
            $this->app->register($provider);
        }

        $this->app->bind('Illuminate\Contracts\Auth\Registrar', 'Microweber\App\Services\Registrar');

        $this->app->singleton(
            'Illuminate\Cache\StoreInterface',
            'Utils\Adapters\Cache\CacheStore'
        );

    }

    protected function registerLaravelAliases()
    {
        foreach ($this->laravel_aliases as $alias => $provider) {
            $this->aliasInstance->alias($alias, $provider);
        }
    }

    protected function setEnvironmentDetection()
    {
        if (! is_cli()) {
            if(isset($_SERVER['HTTP_HOST'])){
                $domain = $_SERVER['HTTP_HOST'];
            } else if(isset($_SERVER['SERVER_NAME'])){
                $domain = $_SERVER['SERVER_NAME'];
            }

            return $this->app->detectEnvironment(function () use ($domain) {
                if (getenv('APP_ENV')) {
                    return getenv('APP_ENV');
                }

                $port = explode(':', $domain);

                $domain = str_ireplace('www.', '', $domain);

                if (isset($port[1])) {
                    $domain = str_ireplace(':' . $port[1], '', $domain);
                }

                return strtolower($domain);
            });
        }

        if (defined('MW_UNIT_TEST')) {
            $this->app->detectEnvironment(function () {
                if (! defined('MW_UNIT_TEST_ENV_FROM_TEST')) {
                    return 'testing';
                }

                return MW_UNIT_TEST_ENV_FROM_TEST;
            });
        }
    }

    protected function registerUtils()
    {
        $this->app->bind('http', function ($app) {
            return new Http($app);
        });

        $this->app->singleton('format', function ($app) {
            return new Format($app);
        });

        $this->app->singleton('parser', function ($app) {
            return new Parser($app);
        });
    }

    protected function registerSingletonProviders()
    {
        $providers = [
            'ui' => 'Ui',
            'update' => 'UpdateManager',
            'cache_manager' => 'CacheManager',
            'config_manager' => 'ConfigurationManager',
            'notifications_manager' => 'NotificationsManager',
            'log_manager' => 'LogManager',
            'permalink_manager' => 'PermalinkManager',
            'layouts_manager' => 'LayoutsManager'
        ];

        foreach ($providers as $alias => $class) {
            $this->app->singleton($alias, function ($app) use ($class) {
                $class = 'MicroweberPackages\\App\Managers\\' . $class;

                return new $class($app);
            });
        }

//        $this->app->singleton('modules', function($app) use ($class) {
//           return new ModuleManager($app);
//        });

    }

    protected function registerHtmlCollective()
    {
        $this->app->register('Collective\Html\HtmlServiceProvider');

        $this->aliasInstance->alias('Form', 'Collective\Html\FormFacade');
        $this->aliasInstance->alias('HTML', 'Collective\Html\HtmlFacade');
    }

    protected function registerMarkdown()
    {
        $this->app->register('GrahamCampbell\Markdown\MarkdownServiceProvider');

        $this->aliasInstance->alias('Markdown', 'GrahamCampbell\Markdown\Facades\Markdown');
    }

    public function boot()
    {
        if (DB::Connection() instanceof \Illuminate\Database\SQLiteConnection) {
            DB::connection('sqlite')->getPdo()->sqliteCreateFunction('regexp',
                function ($pattern, $data, $delimiter = '~', $modifiers = 'isuS') {
                    if (isset($pattern, $data) === true) {
                        return preg_match(sprintf('%1$s%2$s%1$s%3$s', $delimiter, $pattern, $modifiers), $data) > 0;
                    }
                    return;
                }
            );
        }

        $this->app->singleton('lang_helper', function ($app) {
            return new Lang($app);
        });

        \App::instance('path.public', base_path());

        $this->app->database_manager->add_table_model('content', Content::class);
        $this->app->database_manager->add_table_model('media', Media::class);

        // If installed load module functions and set locale
        if (mw_is_installed()) {

            load_all_functions_files_for_modules();

            $this->commands('MicroweberPackages\Option\Console\Commands\OptionCommand');


          /*  $language = get_option('language', 'website');

            if ($language != false) {
                set_current_lang($language);
            }*/

            if (is_cli()) {

                $this->commands('MicroweberPackages\Console\Commands\ResetCommand');
                $this->commands('MicroweberPackages\Console\Commands\UpdateCommand');
                $this->commands('MicroweberPackages\Console\Commands\ModuleCommand');
                $this->commands('MicroweberPackages\Console\Commands\PackageInstallCommand');

            }
        } else {
            // Otherwise register the install command
            $this->commands('MicroweberPackages\Install\Console\Commands\InstallCommand');
        }

        $this->loadRoutes();
        if (mw_is_installed()) {

            $this->app->event_manager->trigger('mw.after.boot', $this);
        }
    }

    private function loadRoutes()
    {
        $routesFile = dirname(__DIR__) . '/routes/web.php';

        if (file_exists($routesFile)) {
            include $routesFile;
        }
    }

    public function autoloadModules($className)
    {
        $filename = modules_path() . $className . '.php';
        $filename = normalize_path($filename, false);

        if (!class_exists($className, false) && is_file($filename)) {
            require_once $filename;
        }
    }

}
