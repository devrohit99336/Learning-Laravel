# [Route](https://www.learnhindituts.com/laravel/laravel-routing)

### Laravel Application के लिए सभी route , routes directory में defined होते हैं। routes Directory में हम aaplication के सभी तरह के routes (web routes , api routes और console routes) रखते हैं।

<h3>Laravel Basic Routing</h3><p>Laravel में सबसे Basic route एक <b>URL</b> और <b>Closure</b> को accept करता है। जिसे कुछ इस तरह से लिखते हैं। </p><p>File Location : routes &gt; web.php</p><pre class="pre">Route::get('hello', function () {
return 'Hello Laravel';
});
</pre><br><p>यह एक GET Type की request के लिए routes है , Browser में अपने project name के बाद <b>/hello</b> लिखेंगे तो आपको "Hello Laravel" मिलेगा।</p><h3>Laravel Default Route Files </h3><p><b>web.php</b> file defined सभी routes को directly आप <b>http://your-app/url</b> से access कर सकते हैं , जो कि <b>web middleware</b> group को assigned होती हैं जो <b>session</b> state and <b>CSRF</b> protection जैसे features provide करती है।</p><p>API routes के लिए आप सभी routes को <span class="dir-path">routes/api.php</span> में register कर सकते हैं। api routes <b>stateless</b> होते हैं , और ये routes <b>api middleware</b> group को assigned होते हैं। </p><br><p>api routes के लिए <b>/api</b> automatically <b>prefix</b> होता है , जिसे आप <span class="dir-path">app/Providers/RouteServiceProvider.php</span> में जाकर customize कर सकते हैं।</p><h2>Laravel Routing Methods</h2><pre class="pre">Route::get('url', callback);
Route::post('url', callback);
Route::match(['get', 'post'], 'url', callback);
Route::put('url', callback);
Route::patch('url', callback);
Route::delete('url', callback);
Route::any('url', callback);
</pre><br><div class="box-info"><p><span class="info-symbol p-1 px-2">❕</span> हालाँकि HTML Forms PUT, PATCH, or DELETE type की request नहीं बन सकते हैं , इसलिए हमें manually एक _method name का hidden field  या  @method blade directive का use करना पड़ता है। <br></p><pre class="pre">&lt;form action="/action/abcd" method="POST"&gt;
@method('PUT')
or
&lt;input type="hidden" value="PUT" name="_method"&gt;
&lt;/form&gt;
</pre><p></p></div><br><h4>Laravel CSRF Protection</h4><p>कोई भी HTML Form जो <b>POST, PUT, PATCH, or DELETE</b> type की request को point कर रहा हो और जो web routes में defined हो , उस request के लिए एक  <b>CSRF token</b> field add कर लेना चाहिए , otherwise request <b>reject</b> हो जायगी। <br>CSRF token field add करने के लिए simply &lt;form&gt;&lt;/form&gt; tag  आप @csrf लिखें या manually hidden input field लिखें।</p><p>For Example : </p><p>
</p><pre class="pre">&lt;form action="/action/abcd" method="POST"&gt;
@csrf
or
&lt;input type="hidden" value="{{csrf_token()}}" name="_token"&gt;
&lt;/form&gt;
</pre><h3>Laravel Route Parameters</h3><h4>Required Parameter</h4><p>कभी - कभी आपके URL में से Parameters को capture करने की जरूरत पड़ जाती है , but उसके लिए हमें उस Parameter को route के साथ define करना पड़ता है।</p><pre class="pre">Route::get('user/{id}', function($id){
return "User Id : ". $id;
});</pre><br><p>हालाँकि आप अपनी need  according कितने ही parameters define कर  सकते है।</p><pre class="pre">Route::get('post/{id}/comments/{comment}', function(){
//do whatever you want
});</pre><br><h4>Route Optional Parameters</h4><p>हालाँकि आप , <b>Optional Parameter</b> भी define कर सकते हैं। Optional Parameter में आप route में parameter pass भी कर सकते हैं और नहीं भी। </p><pre class="pre">Route::get('user/{first_name}/{last_name?}', function($first_name , $last_name=null){
return "Welcome : ".$first_name.' '.$last_name;
});</pre><br><p>Example में last_name Optional Parameter है। </p><h5>Use Controller To Handle Request</h5><p>अभी तक हम Closure Function के through request या request Parameter को Handle कर रहे थे , Request को Controller में Handle  करने के लिए हमें Controller का name और method का name define करना पड़ता है। </p><pre class="pre">Route::get('user', 'UserController@user_inde');
/*make Your Controller , app/Http/Controllers/UserController.php  */</pre><br><p>Controller के किसी particular method को hit करने के लिए , @ के बाद method का name लिखते हैं।</p><br><p class="alert alert-warning">use करने से पहले आप <b>app/Providers/RouteServiceProvider.php</b> file Open करके ये check कर लें कि , <b>web</b> routes के लिए Controllers के लिए default path क्या है, अगर path app/Http/Controllers नहीं है तो इसे edit कर दें। नहीं तो route में define किया गया Controller point नहीं हो पाएगा।</p><h3>Laravel Named Routes</h3><p>Laravel में आप किसी URL को एक unique name भी दे सकते हैं , और उस name का use करके URLs generate कर सकते हो और redirects भी। लेकिन name के thorugh URL generate करने के लिए हमें route() function का use करना पड़ता है।</p><pre class="pre">Route::get('user/profile', function () {
//your logic
})-&gt;name('user-profile');
</pre><br><p>आप <b>Controller</b> के लिए भी named route define कर सकते हैं।  ये आप दो तरह से define कर सकते हैं।</p><pre class="pre">Route::get('user/profile', 'UserProfileController@profile')-&gt;name('user-profile');
Or
Route::get('user/profile', ['as' =&gt; 'user-profile', 'uses' =&gt; 'UserProfileController@profile']);
</pre><br><h4>Generating URLs To Named Routes</h4><p>URL generate या redirect करने के लिए route helper function का use करते हैं। </p><pre class="pre">$user_profile_url = route('user-profile');
/*to redirect from location to other*/
return redirect( route('user-profile') );
or
return redirect()-&gt;route('user-profile');

<b class="text-success">/_if you want to pass parameter_/</b>
$user_profile_url = route('user-profile', 'param1');
or 
$user_profile_url = route('user-profile', ['param1', 'param2']);

</pre> <br><h3>Laravel Route Prefixes</h3><p>कभी कभी हमें हर URL में एक particular जगह पर same URL segment add करना होता है , उसके लिए हम prefix() method use करते हैं।</p><pre class="pre">Route::prefix('user')-&gt;group(function () {
Route::get('/', function () {
// Matches The "www.yourapp.com/user" URL
});
Route::get('/profile', function () {
// Matches The "www.yourapp.com/user/profile" URL
});
});
</pre>

<b class="text-success">या directly group method का use करके भी , directly prefix और middleware define कर सकते हैं।</b>

<pre >
Route::group(['prefix' =&gt; 'user'], function () {
Route::get('/', function () {
// Matches The "www.yourapp.com/user" URL
});
Route::get('/profile', function () {
// Matches The "www.yourapp.com/user/profile" URL
});
});
</pre>
</div>

<br>
