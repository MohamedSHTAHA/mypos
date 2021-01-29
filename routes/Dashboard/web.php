<?php

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
    ],
    function () {
        Route::get('/hashid', function () {
            dd(App\user::find(11)->first_name);
        });
        Route::get('/', function () {
            /* Backup::setPath(public_path('uploads/backup'));

            //dd(Backup::getPath());
            \Backup::setEnabled(true);
            Backup::setCompress(true);
            Backup::setFilename('backup-' . date('Ymd-His'));
            \Backup::export();*/

            return redirect()->route('dashboard.index');
        });
        Route::get('/routes/{id}', function () {
            echo url()->current() . '<br>';
            echo url()->full() . '<br>';
            echo url()->previous() . '<br>';
            echo URL::current() . '<br>';
            echo Request::url() . '<br>';
            // Full URL, with query string
            echo Request::fullUrl() . '<br>';

            // Just the path part of the URL 
            echo Request::path() . '<br>';

            // Just the root (protocol and domain) part of the URL)
            echo Request::root() . '<br>';

            echo Request::getPathInfo() . '<br>';
            echo Request::getRequestUri() . '<br>';
            echo Request::fullUrl() . '<br>';
            echo '<pre>';
            print_r(Request::query()) . '<br>';

            echo Request::getQueryString() . '<br>';
            echo Request::route()->getName() . '<br>';
            echo Route::currentRouteName() . '<br>';
            echo Route::getCurrentRoute()->getActionName() . '<br>';
            echo Route::getFacadeRoot()->current()->uri() . '<br>';
            echo Route::currentRouteAction() . '<br>.';
            //echo Request::route()->getPrefix() . '<br>';



            //echo LaravelLocalization::getCurrentLocale();
            echo '<pre>';

            $app = app();
            $routes =
                Route::getRoutes(); //$app->routes->getRoutes(); //
            //dd($routes);
            //dd(Route::getRoutes()->getRoutes());
            $route_name = [];

            foreach (Route::getRoutes()->getRoutes() as $route) {
                $action = $route->getAction();
                if (array_key_exists('as', $action)) {
                    $route_name[] = $action['as'];
                    //dump($action);
                }
            }
            $namespaces = [];

            foreach (Route::getRoutes()->getRoutes() as $route) {
                $action = $route->getAction();
                if (array_key_exists('as', $action)) {
                    $namespaces[$action['namespace']] = $action['namespace'];
                    //dump($action);
                }
            }
            dd($namespaces);
            //dd($route_name);
            $arrays = (array) $routes;
            // dd($arrays);


            foreach ($routes as $key => $value) {
                dump($value->getAction());
                /*if ($value->getAction()['prefix'] == "/dashboard") {
            dump($value->getAction());
        }*/
                //if (Route::getFacadeRoot()->current()->uri() == $value->uri()) {
                // echo 'methods() : ' . $value->methods()[0] . '-----------------';
                /*echo 'key : ' . $key . '-----------------';
        echo 'uri() : ' . $value->uri() . '-----------------';
        echo 'getActionName() : ' . $value->getActionName() . '-----------------';
        echo 'getName() : ' . $value->getName() . '<br>';*/
                //}
            }
        });

       // Route::prefix('dashboard')->name('dashboard.')->middleware(['auth', 'verified'])->group(function () {
        Route::prefix('dashboard')->name('dashboard.')->middleware(['auth'])->group(function () {

            //Route::post('/save-token', 'FCMController@index');
            Route::post('/save-token', 'FCMController@index')->name('save-token');


            Route::get('/', 'DashboardController@index')->name('index');
            Route::get('/notifyMe', 'DashboardController@notifyMe')->name('notifyMe');
            Route::post('/createChat', 'DashboardController@createChat')->name('createChat');
            Route::post('/getUserMessages', 'DashboardController@getUserMessages')->name('getUserMessages');
            ////////////
            Route::post('/getUserchats', 'DashboardController@getUserchats')->name('getUserchats');
            Route::post('/saveChat', 'DashboardController@saveChat')->name('saveChat');
            Route::post('/readChat', 'DashboardController@readChat')->name('readChat');
            Route::post('/chatsReseviedTotal', 'DashboardController@chatsReseviedTotal')->name('chatsReseviedTotal');
            Route::post('/myFriend', 'DashboardController@myFriend')->name('myFriend');

            ////////////////
            Route::get('/backupDB', function () {
                DB::unprepared('FLUSH TABLES WITH READ LOCK;');

                // run the artisan command to backup the db using the package I linked to
                $x = \Artisan::call('backup:run --only-to-disk=public_uploads');

                // unlock all tables
                DB::unprepared('UNLOCK TABLES');
                //$x = \Artisan::call('backup:run --only-to-disk=public_uploads');

                return $x;
            })->name('backupDB');





            //////////
            Route::resource('users', 'UserController')->except('show');

            Route::resource('categories', 'CategoryController')->except('show');

            Route::resource('products', 'ProductController')->except('show');

            Route::resource('clients', 'ClientController')->except('show');
            Route::resource('clients.orders', 'Client\OrderController')->except('show');
            Route::get('orders/categories', 'Client\OrderController@categories')->name('orders.categories');

            Route::resource('orders', 'OrderController');
            Route::get('getclients', 'OrderController@clientsDatatable')->name('get-clients');
            //Route::get('orders/{order}/products', 'OrderController@products')->name('orders.products');


            Route::get('orderCheckOut/{order}', 'OrderController@orderCheckOut')->name('orders.checkout');
            Route::get('orderCheckOutFinal/{order}', 'OrderController@orderCheckOutFinal')->name('orders.checkoutfinal');
            Route::get('showOrderCheckOut/{order}', 'OrderController@showOrderCheckOut')->name('orders.showOrderCheckOut');


            Route::resource('managementPages', 'ManagementPagesController');


            Route::resource('firebase', 'FirebaseController');
        });
    }
);