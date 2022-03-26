# Middleware

<p><b>Middleware</b> आपके Application में entry करने वाली Requests को <b>filter</b> करने का सबसे easy और efficient mechanism है। Means Middleware का use करके हम अपनी need के according हर request के लिए कोई भी action / task perform कर सकते हैं।</p><p><b>For Example</b> : किसी भी तरह के task जहाँ पर authentication की जरूरत होती है , perform करने से पहले हमें ये check करना जरूरी होता है कि , user authenticated है या नहीं। Middleware के though यह काम हम बहुत ही easy और efficient तरीके से कर सकते हैं।</p><p>Laravel Application में सभी Middleware <span class="dir-path">app/Http/Middleware</span> में define किये जाते हैं।  हालाँकि Laravel में पहले से कुछ predefine  Middleware होते हैं जैसे-</p><ol class="list"><li>
<p><b> VerifyCsrfToken</b> : यह Middleware यह confirm करता है कि POST, PUT, PATCH, or DELETE Type की Request में _token field added है अगर <b>_token</b> field add नहीं है तो request <b>reject</b> कर देता है। </p>

<div class="box-info"><p><br>इसलिए POST, PUT, PATCH, or DELETE Type की request के लिए हम &lt;form&gt;&lt;/form&gt;&nbsp; में <b>@csrf </b> का use करते हैं। हालाँकि आप <b>VerifyCsrfToken Middleware</b> में <b>$except</b> Array Variable में वो सभी URLs define कर सकते हैं जिनके लिए  <b>_token</b> field की जरूरत नहीं है। </p></div></li> 

<li><p><b>TrimString</b> : यह Middleware  आने वाली Requests के सभी <b>Input Fields</b> (password , password_confirmation को छोड़कर)  को <b>Trim</b> करता है। Menas left &amp; right side से extra <b>whitespace</b> remove करता है।  हालाँकि इसमें भी वो सभी input field define कर सकते हैं जिन्हे <b>Trim</b> नहीं करना है।</p></li> <li><p><b>EncryptCookies</b> : यह Middleware Cookies को <b>encrypt</b> करता है , इसमें भी वो सभी Cookies Define कर सकते हैं जिन्हें आपको encrypt नहीं करना है।</p></li></ol><br><p>ये सभी Middlewares  आपको <span class="dir-path">app/Http/Middleware</span> directory में मिलेंगे , ये preinstalled होते हैं।</p><h3>Laravel Define Middleware</h3><p>Middleware define करने के लिए नीचे लिखी Artisan command command अपने terminal में run करें।</p><pre class="pre">php artisan make:middleware MyMiddleware</pre><br><p>Command Run होते ही <span class="dir-path">app/Http/Middleware</span> directory में <b>MyMiddleware</b> नाम की एक class generate हो गयी होगी , जो कि कुछ इस तरह से होगी।&nbsp;हालाँकि आप चाहे तो Middleware File <b>manually</b> भी create कर सकते हैं , बस हमें <b>namespace</b> etc define करना होता है।</p>
<div class="row">
   <div class="col-lg-12">
	<p>File : <span class="dir-path">app/Http/Middleware/MyMiddleware.php</span></p>
	
<pre class="code_container"><code class="code" data-mode="php">&lt;?php 
namespace App\Http\Middleware;
use Closure;
class MyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
       /* Perform Action : It will run before handling the request*/

       return $next($request);
       
       /* Perform Action : It will run after the request*/
    }
}
</code></pre>

</div></div><br><p>Middleware में एक handle method होता है जो request को return ( return $next($request) ) करता है, इसी method में हम अपना logic लिखते हैं।</p>
<br>

><p class="alert alert-primary">handle method में <b>return $next($request);</b> statement से  पहले लिखा गया code Request handle होने से <b>पहले</b> run होता है , जबकि return $next($request); के बाद लिखा गया code Request Handle hone के <b>बाद</b> run होता है|</p>

<h3>Laravel Registering Middleware</h3><p>कोई भी Middleware <b>Run</b> होने के लिए उसका <b>Register</b> होना जरूरी है , बिना register किये वह Middleware Run नहीं होगा।  सभी Middlwares को <span class="dir-path">app/Http/Kernel.php</span> file में Register किया जाता है।</p><h4>Global Middleware</h4><p>अगर आप चाहते हैं कि , Middleware हर एक Request के लिए run हो तो उसे  Kernal.php Class की $middleware property में register करें।</p> <pre class="pre">/**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        \App\Http\Middleware\TrustProxies::class,
        \Fruitcake\Cors\HandleCors::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        /*here list your middleware*/
    ];
</pre><h4>Assigning Middleware To Routes</h4><p>Routes के लिए Middleware Register करने के लिए आपको <b>$routeMiddleware</b> property  में अपना Middleware  लिस्ट करना होता है।&nbsp;यहां पर Middleware को एक <b>key</b> से <b>associate</b> किया जाता है , ताकि उसे key का use करके routes पर apply कर सकें।&nbsp;</p><p></p>

```diff
protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,

+        'mymiddleware' => \App\Http\Middleware\MyMiddleware::class,
    ];
```

<br><p>एक बार $routeMiddleware Register होने के बाद उसे अपने route में use कर सकते हैं।</p><pre class="pre">Route::get('testurl', 'Controller@method')-&gt;middleware('mymiddleware');</pre><br><p>हालाँकि  Middleware को आप routes में कई तरह से use कर सकते हैं , कुछ examples इस प्रकार हैं।</p><pre class="pre">Route::get('/', function () {
    //
})-&gt;middleware('mymiddleware');

Or

Route::group(['middleware' =&gt; 'mymiddleware'], function () {
   /*do whatever you want*/
});

Or

Route::middleware(['mymiddleware'])-&gt;group(function () {
  /*do whatever you want*/
});
