## Create fake data using factory,seeder and model -

### 1. first create a model with migration and resource controller -
        Sytax -   nphp artisan make:model ModelName -mcr  

        Example - php artisan make:model User -mcr

or create a model with migration -

        php artisan make:model ModelName -m

### 2. make tabale structure in migration file -
open migration file like -database/migrations/2022_03_03_100900_create_tbname_table.php file and add table fields -

for Example create contact table migration file -

    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class CreateContactsTable extends Migration
    {
        /**
        * Run the migrations.
        *
        * @return void
        */
        public function up()
        {
            Schema::create('contacts', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
                $table->string('address');
                $table->string('phone');
                $table->timestamps();
            });
        }

        /**
        * Reverse the migrations.
        *
        * @return void
        */
        public function down()
        {
            Schema::dropIfExists('contacts');
        }
    }

## 3. insert fake data in factory using fakear, for databse table -
Path - database/factories/ModelNameFactory.php <br>
example - database/factories/ContactFactory.php <br>

>  Create a fake forigin key using parent id refrence in factory. example create a user_id using User model and users primary key id -<br>
>'user_id' => User::pluck('id')->random(),


    <?php

        namespace Database\Factories;

        use Illuminate\Database\Eloquent\Factories\Factory;
        use App\Models\User;  //import model for user_id

        class ContactFactory extends Factory
        {
            /**
            * refrence for how to use user primary key(id) as a contact user_id => https://www.codegrepper.com/code-examples/php/how+to+add+foreign+key+in+laravel+faker
            */
            public function definition()
            {
                return [
                    'user_id' => User::pluck('id')->random(),
                    'address' => $this->faker->unique()->safeEmail(),
                    'phone' => $this->faker->phoneNumber(),
                ];
            }
        }

## 4. Insert factory with model in database/seeders/DatabaseSeeder.php for create fake data in database (related table)-

Example - 

    <?php

    namespace Database\Seeders;

    use Illuminate\Database\Seeder;

    class DatabaseSeeder extends Seeder
    {
        public function run()
        {
            \App\Models\User::factory(10)->create();
            \App\Models\Contact::factory(10)->create();
        }
    }


## 5. Generate a fake data using a seeder in database table -

Seeding for command -

    php artisan db:seed




