# Eloquent: Relationships


Database tables are often related to one another. For example, a blog post may have many comments or an order could be related to the user who placed it.We use it to join relation tables. Eloquent: Relationships is used in Laravel as we use join function to join tables in mysql.

इसका  उपयोग हम रिलेशन वाले टेबल्स को आपस में कनेक्ट (ज्वाइन ) करने के लिए करते है |  जिस तरह हम mysql में टेबल्स को ज्वाइन करने के लिए ज्वाइन फंक्शन का उपयोग करते है उसी तरह लारवेल में Eloquent: Relationships का उपयोग किया जाता है | 

**Faker is archived**. Read the reasons behind this decision here: [Eloquent: Relationships](https://laravel.com/docs/9.x/eloquent-relationships#main-content )

# Table of Contents 

- [Types](#types)
- [Steps](#steps)
	- [Base](#Formatters)
	- [Create model and migration](#create-model-and-migration)
	- [make database structure in migration file](#make-database-structure-in-migration-file)
	- [create a factory for generate fake data ](#create-a-factory-for-generate-fake-data)
	- [Add models in seeder file for run factories](#add-models-in-seeder-file-for-run-factories)
- [one to one](#one-to-one)
- [one to many](#one-to-many)
- [Seeding the Generator](#seeding-the-generator)
- [Faker Internals: Understanding Providers](#faker-internals-understanding-providers)
- [Real Life Usage](#real-life-usage)
- [Language specific formatters](#language-specific-formatters)
- [Third-Party Libraries Extending/Based On Faker](#third-party-libraries-extendingbased-on-faker)
- [License](#license)

## Types

Eloquent makes managing and working with these relationships easy, and supports a variety of common relationships:-

* One To One
* One To Many
* Many To Many
* Has One Through
* Has Many Through
* One To One (Polymorphic)
* One To Many (Polymorphic)
* Many To Many (Polymorphic)

## Steps 

To apply for a relationship, we have to follow the following steps -
रिलेशनशिप को अप्लाई करने के लिए हमें निम्न स्टेप्स फॉलो करने पड़ते है - 

### `Create model and migration` 

After creating the project, first we create migration and controller so that we can prepare the database structure and our model. For this we can use the command given below -

प्रोजेक्ट क्रिएट करने के बाद सबसे पहले माइग्रेशन और कंट्रोलर बना लेते है ताकि हम डेटाबेस स्ट्रक्चर और अपना मॉडल तैयार कर  सके | इसके लिए हम निचे दिए कमांड का उपयोग कर  सकते है - 

        Sytax -   php artisan make:model ModelName -mcr  

        Example - php artisan make:model User -mcr

or create a model with migration -

        php artisan make:model ModelName -m
###  `make database structure in migration file -`

path - database/migrations/migration_file.php
example - 

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
                });
            }

            public function down()
            {
                Schema::dropIfExists('users');
            }
        }

###  `create a factory for generate fake data`

In Laravel, we use migration to insert fake data into the database.
For more information about faker we can take help of this file - [fekar file](../learning/faker.md).

In Laravel, its data locale is en _FR, due to which all data comes in French, so for Indian data, we go to **config/app.php** and set the default **'faker_locale' => 'en _FR',** will have to be changed from **'faker_locale' => 'en_IN',** so that data related to India can be generated.

लारवेल में हम माइग्रेशन का उपयोग डेटाबेस में फेक डाटा डालने के लिए करते है | फेकर के बारे में अधिक जानकारी के लिए हम इस फाइल की सहायता ले सकते है -[fekar file](../learning/faker.md).

लारवेल में इसके डाटा लोकेल को en _FR  रहता है जिसके कारण  सभी डाटा फ्रेंच में आता है अतः हमें इंडियन डाटा के लिए इसमें  **config/app.php** में जाकर डिफ़ॉल्ट सेट **'faker_locale' => 'en _FR',**  से  बदलकर **'faker_locale' => 'en_IN',** करना होगा ताकि भारत से संबधित डाटा जेनेरेट हो सके | 

Example - 


    <?php

    namespace Database\Factories;

    use Illuminate\Database\Eloquent\Factories\Factory;
    use App\Models\User;

    class PostFactory extends Factory
    {

        public function definition()
        {
            return [
                'user_id' => User::pluck('id')->random(),
                'designation' => $this->faker->jobTitle(),
                'disription' => $this->faker->realText($maxNbChars = 150, $indexSize = 2),
            ];
        }
    }


### `Add models in seeder file for run factories`

  After creating the factory file, to execute the code written in it and to create fake data, we call their factories with the help of their models in the seeder file.

  फैक्ट्री फाइल बनाने के बाद उसमे लिखे कोड को एक्सेक्यूटे करने तथा फेक डाटा बनाने के लिए हमें सीडर फाइल **DatabaseSeeder.php** में उनके मॉडल्स की मदद से उनके फॅक्टरीस को कॉल करते है | 

  DatabaseSeeder.php - File path => database/seeders/DatabaseSeeder.php

  Example - 

        <?php

        namespace Database\Seeders;

        use Illuminate\Database\Seeder;

        class DatabaseSeeder extends Seeder
        {
            /**
            * Seed the application's database.
            *
            * @return void
            */
            public function run()
            {
                \App\Models\User::factory(10)->create();  //default
                \App\Models\Contact::factory(10)->create();
                \App\Models\Post::factory(30)->create();
                \App\Models\Category::factory(10)->create();
            }
        }


# one to one 
one to one is used when two tables are related and the primary key of one is used in the other table as a foreign key

one to one  का उपयोग तब किया जाता है जब दो टेबल्स आपस में संबधित हो तथा एक का प्राइमरी key दूसरे टेबल में as a फॉरेन key use हुआ हो |

As we keep the user's data in a database, then we create two tables User and Contacts for it, in which the primary key (id) of the user is used as a foreign key in the Contacts table, so that both the tables are connected to each other. is | Here a user has only one contact, so one to one will be used.

जैसे की हम यूजर के  डाटा को एक database  में रखते तब हम उसके लिए दो टेबल यूजर और कॉन्टेक्ट्स बनाते है ,जिसमे यूजर का प्राइमरी key (id ) कॉन्टेक्ट्स टेबल में फॉरेन key के रूप में उपयोग किया जाता है जिससे दोनों टेबल आपस में कनेक्टेड रहते है | यहां पर एक यूजर का केवल एक कांटेक्ट है इसलिए one to one का उपयोग किया जायेगा| 



# one to many

When more than one related data of a table is in another table, then one to many relationship is used to call/access it.

जब किसी टेबल का एक से ज्यादा संबधित data किसी दूसरे  टेबल में हो तब उसको call /access करने के लिए one to many रिलेशनशिप का उपयोग किया जाता है 

As we keep the user's data in a database, then we create two tables user and post for it, in which the primary key (id) of the user is used as a foreign key in the post table, so that both the tables are connected to each other. is | Here a user can have more than one post, so one to many will be used.

जैसे की हम यूजर के  डाटा को एक database  में रखते तब हम उसके लिए दो टेबल यूजर और पोस्ट  बनाते है ,जिसमे यूजर का प्राइमरी key (id ) पोस्ट  टेबल में फॉरेन key के रूप में उपयोग किया जाता है जिससे दोनों टेबल आपस में कनेक्टेड रहते है | यहां पर एक यूजर का  एक से ज्यादा पोस्ट हो सकता है इसलिए one to many  का उपयोग किया जायेगा| 


# one to many

    