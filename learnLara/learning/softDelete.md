# SoftDelete

 Soft का use तब किया जाता है जब हमे Dtatabase के किसी table से डाटा को स्थायी (परमानेंट) रूप से डिलीट नहीं करना होता | इस method में डाटा केवल hide होता है और टेबल में deleted_at में delete कियॆ गए दिनांक समय के साथ स्टोर हो जाता है, जिसे हम बाद में Restore भी कर सकते है| इसका उपयोग हम यूजर को डिलीट करने, तथा बाद में Admin द्वारा उसे वापस Restore करने के लिए करते है | 

 Softdelete is used when we do not have to permanently delete the data from any table in the database. In this method, the data is only hidden and the deleted_at is stored in the table with the deleted date time, which we can also restore later. We use this to delete the user and later restore it back by the admin.


 ## Steps:

 ### Migration -

 soft delete को implement के लिए सबसे पहले जिस टेबल में हम इस मेथड को लागु करना चाहते है उसके माइग्रेशन फाइल में $table->softDeletes(); को जोड़ना होता है |  

 उदाहरण के लिए जैसे हम इसे Users टेबल के लिए apply  करना चाहते है तो उसके माइग्रेशन फाइल में इसे ऐड कर देंगे | जैसे -

```diff
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
+            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
```
 ### Model -

 माइग्रेशन फाइल को माइग्रेट करने के बाद अब इसके मेथड ( **use Illuminate\Database\Eloquent\SoftDeletes;** ) को उस मॉडल में ऐड करेंगे जिससे वह माइग्रेशन फाइल कनेक्ट हो या जिसके द्वारा डेटाबेस के उस टेबल को एक्सेस किया जाता हो | 
 जैसे Users टेबल को User मॉडल द्वारा Access  किया जाता है - 

```diff
<?php

    namespace App\Models;

    use Illuminate\Contracts\Auth\MustVerifyEmail;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;
    use Laravel\Sanctum\HasApiTokens;
+   use Illuminate\Database\Eloquent\SoftDeletes;

    class User extends Authenticatable
    {
+       use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

        /**
        * The attributes that are mass assignable.
        *
        * @var array<int, string>
        */
        protected $fillable = [
            'name',
            'email',
            'password',
        ];

        /**
        * The attributes that should be hidden for serialization.
        *
        * @var array<int, string>
        */
        protected $hidden = [
            'password',
            'remember_token',
        ];

        /**
        * The attributes that should be cast.
        *
        * @var array<string, string>
        */
        protected $casts = [
            'email_verified_at' => 'datetime',
        ];
    }

```

### Methods -

```diff
User::first()->delete(); // Delete first data in users table from database
$user = User::get();// Get all users table from database
$user2 = User::withTrashed()->get();// Get all users (with delated data) table from database
User::onlyTrashed()->whereId(3)->restore();// Restore deleted(trashded) users data
User::withTrashed()->restore();// Restore all deleted(trashded) users data
$user3 = User::onlyTrashed()->get();     // Get only deleted(trashded) users table from database
dd($user->toArray());    // Display users in home page array format
```

How to add color to GitHub's README.md file??
You can use the diff language tag to generate some colored text:

```diff
- text in red
+ text in green
! text in orange
# text in gray
@@ text in purple (and bold)@@
```
