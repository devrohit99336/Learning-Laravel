<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

# Laravel Relationship

Database tables are often related to one another. For example, a blog post may have many comments or an order could be related to the user who placed it. Eloquent makes managing and working with these relationships easy, and supports a variety of common relationships:

## Defining Relationships -

Eloquent relationships are defined as methods on your Eloquent model classes. Since relationships also serve as powerful query builders, defining relationships as methods provides powerful method chaining and querying capabilities.

### One To One -

इसका उपयोग दो मॉडल्स को आपस में जोड़ने के लिए करते है | इस प्रकार के रिलेशनशिप में एक टेबल का प्राइमरी की दूसरे टेबल में foregn की यूज़ होता है |

Tables : users, contacts

=> user has one contact ->(id) as a primary key<br>
=> contact belongs to user ->(user_id) is a foreignId<br>

Steps -

<table>
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>User</th>
                <th>Contact</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Migration</td>
                <td>
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
                        });
                    }
                </td>
                <td>
                    public function up()
                    {
                        Schema::create('contacts', function (Blueprint $table) {
                            $table->id();
                            $table->string('address');
                            $table->string('phone');
                            $table->foreignId('user_id')->constrained()->onDelete('cascade');
                            $table->timestamps();
                        });
                    }
                </td>
            </tr>
            <tr>
                <td>2</td>
                <td>model</td>
                <td>
                    public function user()
                    {
                        return $this->belongsTo(User::class);
                    }
                </td>
                <td>
                    public function contact(){
                        return $this->hasOne(Contact::class);
                    }
                </td>
            </tr>

            <tr>
                <td>3</td>
                <td>model</td>
                <td>
                    public function user()
                    {
                        return $this->belongsTo(User::class);
                    }
                </td>
                <td>
                    public function contact(){
                        return $this->hasOne(Contact::class);
                    }
                </td>
            </tr>

        </tbody>

</table>
