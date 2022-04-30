# Named Route -

लारवेल में हम बहुत से तरीको(methods) से अपने पेज को Redirect (Route) कर सकते है। लेकिन सभी तरीको में सबसे बेहतरीन तरीका है Named Route क्योकि इसके use से हमारा URL कितना ही लम्बा क्यों न हो हम आसानी(easly) से उसके नाम का उपयोग कर उसे एक्सेस(Access) कर सकते है। 

step 1 - 

सबसे पहले हमे अपने Route को name() atrribute जोड़कर एक नाम देना होता है जिसकी मदद से हम उसे एक्सेस(Access) कर सके। हम डॉट ऑपरेटर की मदद से Route के नाम(name) को स्पेसिफिक(specific) भी बना सकते है। 

Example - 

```diff
Route::get('/', function () {
    return view('admin');
})->name('home');                   // Route Name

Route::get('/aboute', function () {
    return view('admin');
})->name('admin.about');            // Specific Route Name
```


step 2-

हम अपने view में रूट को बहुत से तरीको से एक्सेस(Access) कर सकते है ,लेकिन named रूट को हम केवल route() method की मदद से एक्सेस कर सकते है। जैसे - 
१. url()
२. route()
३. href

Example -

```diff
<nav>
    <a href="{{ url('/') }}">Home</a>       // using url
    <a href="{{ route('blog') }}">Blog</a>  // using named route
    <a href="/home">Gallery</a>              // using href
</nav>

```

