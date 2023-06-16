<?php

namespace App\Providers;

use Illuminate\Console\Events\CommandFinished;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use NunoMaduro\LaravelDesktopNotifier\Notification;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Blade;
use Laravel\Passport\Passport;
use App\Broadcasting\FirebaseChannel;

class AppServiceProvider extends AuthServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    protected $policies = [
        'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];


    public function register()
    {
        $app = $this->app;

        $this->app->make(ChannelManager::class)->extend('firebase', function () use ($app) {
            return $app->make(FirebaseChannel::class);
        });

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    if(config('app.env') === 'production') {
        \URL::forceScheme('http');
    }

    $this->registerPolicies();    

    if (! $this->app->routesAreCached()) {
        Passport::routes();
    }

     Blade::directive('selected', function($expression){
            list($a, $b) = explode(',', $expression);
            return '<?php echo (' . $a . ' == ' . $b . ') ? "selected" : ""; ?>';
        });

    Blade::withoutDoubleEncoding();
        //
//         Event::listen(CommandFinished::class, function(CommandFinished $event){
//             if($event->command  === 'test'){
//                 $passed = !$event->exitCode;
//                 $this->notify($passed);
//             }
//         });
    }

//     public function notify($passed){
//     $notification = (new Notification())
//         ->setTitle(config('app.name') . ' DLP')
//         ->setBody(
//             $passed ? 'ALL test passed':'One or More test fail!'
//
//         )
//         ->addOption(
//             'sound',
//             $passed ? 'glass': 'basso'
//         );
//
//         $this->app->make('desktop.notifier')->send($notification);
//     }  public function notify($passed){
//     $notification = (new Notification())
//         ->setTitle(config('app.name') . ' DLP')
//         ->setBody(
//             $passed ? 'ALL test passed':'One or More test fail!'
//
//         )
//         ->addOption(
//             'sound',
//             $passed ? 'glass': 'basso'
//         );
//
//         $this->app->make('desktop.notifier')->send($notification);
//     }
}
