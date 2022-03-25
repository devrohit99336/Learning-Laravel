# Custom Route

### Laravel में By default web.php Route provide करता है लेकिन हम इसमें custom route भी बना सकते है |

## step 1 -
सबसे पहले app/Providers/RouteServiceProvider.php फाइल में एक और Route जोड़ना होगा |

Example -

```diff

public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));

+           Route::prefix('admin')  // यह हमारे URL में दिखाई देता है अतः हम अपने हिसाब से prefix का नाम दे सकते है।  
+               ->namespace($this->namespace)
+               ->group(base_path('routes/admin.php'));
        });
    }

```
## step 2 -

RouteServiceProvider.php में रूट का नाम है उसी नाम से routes डायरेक्टरी में एक route फाइल बनानी होगी। जैसे यहां पर एडमिन(admin) नाम से route बनाया गया अतः हम Routes फोल्डर के अंदर admin.php नाम से बनाये है -

```diff
<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('admin');
});


```

## Step 3 -

यहां पर हम इस route फाइल के routes को url की मदद से देख सकते है - <br>
Example -

    http://127.0.0.1:8000/admin


