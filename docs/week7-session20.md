# Laravel Queues & Jobs

## 🎯 Learning Objectives

By the end of this session, you will be able to:

- Understand what queues are and why they're important
- Set up and configure Laravel queues
- Create, dispatch, and process jobs
- Implement email notifications using queues
- Monitor and debug queue jobs

---

## 📚 Session Outline

### Part 1: Introduction to Queues

#### What are Queues?

**Real-world Analogy:**
Think of a queue like a line at a coffee shop:

- Orders are taken and put in a queue
- Baristas process orders one by one
- Customers don't wait at the counter - they can sit down
- The coffee shop can serve more customers efficiently

**In Web Development:**

```
Without Queues:
User clicks "Send Email" → Server processes email → User waits → Response

With Queues:
User clicks "Send Email" → Job added to queue → Immediate response
                        ↓
Background worker processes email later
```

#### Why Use Queues?

1. **Improved User Experience**

   - Instant responses to user actions
   - No waiting for slow operations

2. **Better Performance**

   - Offload heavy tasks to background
   - Handle more concurrent users

3. **Reliability**

   - Jobs can be retried if they fail
   - System remains responsive even during heavy load

4. **Scalability**
   - Add more workers to process jobs faster
   - Distribute work across multiple servers

**Common Use Cases:**

- Sending emails
- Image/video processing
- Data exports
- Third-party API calls
- Database cleanup tasks

### Part 2: Laravel Queue Configuration

#### Queue Drivers

Laravel supports multiple queue drivers:

```php
// config/queue.php
'default' => env('QUEUE_CONNECTION', 'sync'),

'connections' => [
    'sync' => [
        'driver' => 'sync', // For development - runs immediately
    ],
    'database' => [
        'driver' => 'database', // Uses database table
        'table' => 'jobs',
    ],
    'redis' => [
        'driver' => 'redis', // Fast, in-memory
    ],
]
```

#### Setting Up Database Queue

**Step 1: Create Jobs Table**

```bash
php artisan queue:table
php artisan migrate
```

**Step 2: Configure Environment**

```env
# .env file
QUEUE_CONNECTION=database
```

**Step 3: Understanding the Jobs Table**

```sql
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`)
);
```

### Part 3: Creating and Understanding Jobs

#### Creating Your First Job

**Generate a Job Class:**

```bash
php artisan make:job SendWelcomeEmail
```

**Basic Job Structure:**

```php
<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class SendWelcomeEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    /**
     * Create a new job instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Simulate sending email
        Log::info("Sending welcome email to: " . $this->user->email);

        // In real application, you would send actual email here
        sleep(2); // Simulate processing time

        Log::info("Welcome email sent successfully!");
    }
}
```

#### Job Anatomy Explained

**Key Components:**

1. **Traits:**

   ```php
   use Dispatchable;        // Allows job to be dispatched
   use InteractsWithQueue;  // Provides queue interaction methods
   use Queueable;          // Makes job queueable
   use SerializesModels;   // Safely serializes Eloquent models
   ```

2. **Constructor:**

   ```php
   public function __construct(User $user)
   {
       $this->user = $user; // Data needed for job execution
   }
   ```

3. **Handle Method:**
   ```php
   public function handle(): void
   {
       // The actual work the job performs
   }
   ```

**Job Properties:**

```php
class SendWelcomeEmail implements ShouldQueue
{
    // How long job can run before timing out
    public $timeout = 120;

    // How many times job can be attempted
    public $tries = 3;

    // Specific queue to use
    public $queue = 'emails';
}
```

### Part 4: Dispatching Jobs

#### Basic Job Dispatching

**In a Controller:**

```php
<?php

namespace App\Http\Controllers;

use App\Jobs\SendWelcomeEmail;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function register(Request $request)
    {
        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Dispatch welcome email job
        SendWelcomeEmail::dispatch($user);

        return response()->json([
            'message' => 'User registered successfully!',
            'user' => $user
        ]);
    }
}
```

#### Advanced Dispatching Options

```php
// Delay job execution
SendWelcomeEmail::dispatch($user)->delay(now()->addMinutes(5));

// Send to specific queue
SendWelcomeEmail::dispatch($user)->onQueue('high-priority');

// Chain jobs (run in sequence)
SendWelcomeEmail::dispatch($user)
    ->chain([
        new SendWelcomeGift($user),
        new UpdateUserStats($user)
    ]);
```

### Part 5: Processing Jobs - Queue Workers

#### Starting a Queue Worker

```bash
# Process jobs from default queue
php artisan queue:work

# Process specific queue
php artisan queue:work --queue=emails

# Process with specific settings
php artisan queue:work --tries=3 --timeout=30
```

#### Queue Worker Commands

```bash
# Process only one job then stop
php artisan queue:work --once

# Stop worker gracefully after current job
php artisan queue:restart

# See failed jobs
php artisan queue:failed

# Retry failed jobs
php artisan queue:retry all
```

### Part 6: Email Notifications with Queues

#### Creating a Notification

```bash
php artisan make:notification WelcomeNotification
```

```php
<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Welcome to Our Platform!')
                    ->line('Thank you for joining our platform.')
                    ->line('We are excited to have you on board!')
                    ->action('Get Started', url('/dashboard'))
                    ->line('Thank you for using our application!');
    }
}
```

#### Using Queued Notifications

**In User Model:**

```php
<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\WelcomeNotification;

class User extends Authenticatable
{
    use Notifiable;

    // ... other code

    public function sendWelcomeNotification()
    {
        $this->notify(new WelcomeNotification());
    }
}
```

**In Controller:**

```php
public function register(Request $request)
{
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
    ]);

    // Send queued notification
    $user->sendWelcomeNotification();

    return response()->json([
        'message' => 'User registered! Welcome email will be sent shortly.'
    ]);
}
```

---

## 🛠️ Hands-on Practice

### Exercise 1: Create a Simple Job

**Task:** Create a job that processes a user's profile picture

```bash
php artisan make:job ProcessProfilePicture
```

**Students will implement:**

- Job constructor to accept user and image data
- Handle method to simulate image processing
- Proper error handling

### Exercise 2: Email Notification

**Task:** Create a notification for password reset

```bash
php artisan make:notification PasswordResetNotification
```

**Students will implement:**

- Queued notification
- Email template with reset link
- Dispatch from controller

---

## 🔍 Monitoring and Debugging

### Useful Artisan Commands

```bash
# Monitor queue in real-time
php artisan queue:monitor

# Clear all queued jobs
php artisan queue:clear

# Get queue statistics
php artisan queue:stats

# List failed jobs with details
php artisan queue:failed
```

### Common Issues and Solutions

1. **Jobs Not Processing:**

   - Check if queue worker is running
   - Verify queue connection in .env

2. **Jobs Failing:**

   - Check failed_jobs table
   - Review job logic and dependencies

3. **Performance Issues:**
   - Monitor job execution time
   - Consider job optimization or chunking

---

## 📝 Key Takeaways

1. **Queues improve user experience** by moving slow operations to background
2. **Jobs are classes** that encapsulate work to be done later
3. **Queue workers process jobs** from the queue continuously
4. **Notifications can be queued** to prevent email sending delays
5. **Always monitor and handle failures** in production

---

## 🏠 Homework Assignment

Create a mini e-commerce order processing system:

1. **Order Confirmation Job:**

   - Send order confirmation email
   - Update inventory
   - Log order details

2. **Order Status Notification:**

   - Create queued notification for order updates
   - Include order tracking information

3. **Background Tasks:**
   - Generate invoice PDF (simulated)
   - Send to accounting system (simulated)

**Deliverables:**

- Working Laravel application with queues configured
- At least 2 jobs and 1 notification implemented
- Screenshot of successful job processing
- Brief documentation of your implementation

---

## 📚 Resources for Further Learning

- [Laravel Queue Documentation](https://laravel.com/docs/queues)
- [Laravel Notification Documentation](https://laravel.com/docs/notifications)
- [Horizon for Queue Monitoring](https://laravel.com/docs/horizon)
- Best Practices for Production Queue Setup

---

## ❓ Q&A Session

Common questions to address:

- When should I use queues vs immediate processing?
- How do I handle job failures in production?
- What's the difference between jobs and notifications?
- How do I scale queue processing?
