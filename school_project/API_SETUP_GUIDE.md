# School Management System API Setup Guide

## Prerequisites
- PHP 7.4 or higher
- Laravel 7.x or higher
- MySQL database
- Composer

## Step 1: Install Laravel Sanctum

```bash
composer require laravel/sanctum
```

## Step 2: Publish Sanctum Configuration

```bash
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
```

## Step 3: Run Migrations

```bash
php artisan migrate
```

## Step 4: Configure Sanctum

### Update `app/Http/Kernel.php`

Add Sanctum middleware to the API middleware group:

```php
'api' => [
    \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
    'throttle:api',
    \Illuminate\Routing\Middleware\SubstituteBindings::class,
],
```

### Update User Model

Add the `HasApiTokens` trait to your User model (`app/User.php`):

```php
<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
```

## Step 5: Create Missing Database Tables

Some API controllers reference tables that might not exist. Create migrations for them:

### Create Attendance Table Migration

```bash
php artisan make:migration create_attendance_table
```

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceTable extends Migration
{
    public function up()
    {
        Schema::create('attendance', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->date('date');
            $table->enum('status', ['present', 'absent', 'late', 'excused']);
            $table->text('remarks')->nullable();
            $table->timestamps();
            
            $table->foreign('student_id')->references('id')->on('admission_forms')->onDelete('cascade');
            $table->unique(['student_id', 'date']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('attendance');
    }
}
```

### Create Teacher Payments Table Migration

```bash
php artisan make:migration create_teacher_payments_table
```

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeacherPaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('teacher_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('teacher_id');
            $table->decimal('amount', 10, 2);
            $table->date('payment_date');
            $table->string('payment_method');
            $table->string('transaction_id')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['paid', 'pending', 'cancelled'])->default('paid');
            $table->timestamps();
            
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('teacher_payments');
    }
}
```

### Create Class Routines Table Migration

```bash
php artisan make:migration create_class_routines_table
```

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassRoutinesTable extends Migration
{
    public function up()
    {
        Schema::create('class_routines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('class_id');
            $table->enum('day_of_week', ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']);
            $table->string('subject');
            $table->string('teacher');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('room')->nullable();
            $table->timestamps();
            
            $table->foreign('class_id')->references('id')->on('class_forms')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('class_routines');
    }
}
```

### Update Existing Tables

Add missing columns to existing tables:

```bash
php artisan make:migration add_missing_columns_to_tables
```

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMissingColumnsToTables extends Migration
{
    public function up()
    {
        // Add transport_id to admission_forms table
        if (Schema::hasTable('admission_forms') && !Schema::hasColumn('admission_forms', 'transport_id')) {
            Schema::table('admission_forms', function (Blueprint $table) {
                $table->unsignedBigInteger('transport_id')->nullable();
                $table->foreign('transport_id')->references('id')->on('transports')->onDelete('set null');
            });
        }

        // Add status column to transports table
        if (Schema::hasTable('transports') && !Schema::hasColumn('transports', 'status')) {
            Schema::table('transports', function (Blueprint $table) {
                $table->enum('status', ['active', 'inactive', 'maintenance'])->default('active');
                $table->integer('capacity')->nullable();
                $table->decimal('fare', 8, 2)->nullable();
                $table->text('route_description')->nullable();
            });
        }

        // Add payment columns to challans table
        if (Schema::hasTable('challans')) {
            Schema::table('challans', function (Blueprint $table) {
                if (!Schema::hasColumn('challans', 'payment_date')) {
                    $table->date('payment_date')->nullable();
                }
                if (!Schema::hasColumn('challans', 'payment_method')) {
                    $table->string('payment_method')->nullable();
                }
                if (!Schema::hasColumn('challans', 'transaction_id')) {
                    $table->string('transaction_id')->nullable();
                }
                if (!Schema::hasColumn('challans', 'remarks')) {
                    $table->text('remarks')->nullable();
                }
            });
        }

        // Add columns to books table
        if (Schema::hasTable('books')) {
            Schema::table('books', function (Blueprint $table) {
                if (!Schema::hasColumn('books', 'publisher')) {
                    $table->string('publisher')->nullable();
                }
                if (!Schema::hasColumn('books', 'publication_year')) {
                    $table->integer('publication_year')->nullable();
                }
                if (!Schema::hasColumn('books', 'price')) {
                    $table->decimal('price', 8, 2)->nullable();
                }
                if (!Schema::hasColumn('books', 'description')) {
                    $table->text('description')->nullable();
                }
                if (!Schema::hasColumn('books', 'cover_image')) {
                    $table->string('cover_image')->nullable();
                }
            });
        }

        // Add columns to book_issues table
        if (Schema::hasTable('book_issues')) {
            Schema::table('book_issues', function (Blueprint $table) {
                if (!Schema::hasColumn('book_issues', 'condition')) {
                    $table->enum('condition', ['good', 'damaged', 'lost'])->nullable();
                }
                if (!Schema::hasColumn('book_issues', 'fine_amount')) {
                    $table->decimal('fine_amount', 8, 2)->default(0);
                }
                if (!Schema::hasColumn('book_issues', 'remarks')) {
                    $table->text('remarks')->nullable();
                }
                if (!Schema::hasColumn('book_issues', 'status')) {
                    $table->enum('status', ['issued', 'returned', 'overdue'])->default('issued');
                }
            });
        }
    }

    public function down()
    {
        // Reverse the migrations if needed
    }
}
```

## Step 6: Run the New Migrations

```bash
php artisan migrate
```

## Step 7: Configure CORS (Optional)

If you're building a separate frontend application, you might need to configure CORS. Install Laravel CORS:

```bash
composer require fruitcake/laravel-cors
```

Publish the configuration:

```bash
php artisan vendor:publish --tag="cors"
```

Update `config/cors.php`:

```php
<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['*'], // Change this to your frontend URL in production
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false,
];
```

## Step 8: Environment Configuration

Update your `.env` file:

```env
# Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=school_management
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Sanctum Configuration
SANCTUM_STATEFUL_DOMAINS=localhost,127.0.0.1,your-frontend-domain.com

# Session Configuration
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null
```

## Step 9: Create Storage Link

For file uploads (photos, documents):

```bash
php artisan storage:link
```

## Step 10: Install PDF Generation (Optional)

For challan PDF generation, install DomPDF:

```bash
composer require barryvdh/laravel-dompdf
```

Publish the configuration:

```bash
php artisan vendor:publish --provider="Barryvdh\DomPDF\ServiceProvider"
```

## Step 11: Test the API

### Create a Test User

```bash
php artisan tinker
```

```php
$user = new App\User();
$user->name = 'Admin User';
$user->email = 'admin@school.com';
$user->password = bcrypt('password');
$user->save();
```

### Test Authentication

```bash
curl -X POST http://your-domain.com/api/v1/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@school.com","password":"password"}'
```

### Test Protected Endpoint

```bash
curl -X GET http://your-domain.com/api/v1/students \
  -H "Authorization: Bearer YOUR_ACCESS_TOKEN" \
  -H "Content-Type: application/json"
```

## Step 12: API Rate Limiting (Optional)

Update `app/Http/Kernel.php` to add rate limiting:

```php
'api' => [
    \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
    'throttle:60,1', // 60 requests per minute
    \Illuminate\Routing\Middleware\SubstituteBindings::class,
],
```

## Step 13: Error Handling

Create a custom exception handler for API responses. Update `app/Exceptions/Handler.php`:

```php
public function render($request, Throwable $exception)
{
    if ($request->expectsJson()) {
        if ($exception instanceof \Illuminate\Validation\ValidationException) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $exception->errors()
            ], 422);
        }

        if ($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            return response()->json([
                'success' => false,
                'message' => 'Resource not found'
            ], 404);
        }

        if ($exception instanceof \Illuminate\Auth\AuthenticationException) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated'
            ], 401);
        }

        return response()->json([
            'success' => false,
            'message' => 'Something went wrong',
            'error' => $exception->getMessage()
        ], 500);
    }

    return parent::render($request, $exception);
}
```

## Step 14: API Testing

You can test the APIs using:

1. **Postman**: Import the API endpoints and test them
2. **Insomnia**: REST client for testing APIs
3. **curl**: Command line testing
4. **Frontend Application**: React, Vue, Angular, etc.

## Security Considerations

1. **Use HTTPS in production**
2. **Set proper CORS origins**
3. **Implement proper rate limiting**
4. **Validate all inputs**
5. **Use environment variables for sensitive data**
6. **Implement proper logging**
7. **Regular security updates**

## Performance Optimization

1. **Database indexing**
2. **Query optimization**
3. **Caching (Redis/Memcached)**
4. **API response caching**
5. **Database connection pooling**

## Deployment

1. **Set APP_ENV=production**
2. **Set APP_DEBUG=false**
3. **Configure proper database credentials**
4. **Set up SSL certificates**
5. **Configure web server (Apache/Nginx)**
6. **Set up monitoring and logging**

Your School Management System API is now ready for mobile application development!
