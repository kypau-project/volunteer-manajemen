<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modify existing users table
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->enum('role', ['admin', 'coordinator', 'volunteer'])->default('volunteer')->after('password');
            $table->string('photo')->nullable()->after('role');
        });

        // 2. volunteer_profiles
        Schema::create('volunteer_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // One-to-One
            $table->text('address')->nullable();
            $table->text('skills')->nullable(); // JSON or comma-separated string
            $table->text('bio')->nullable();
            $table->decimal('total_hours', 8, 2)->default(0.00);
            $table->timestamps();
            $table->unique('user_id');
        });

        // 3. events
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('category')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('location');
            $table->integer('quota');
            $table->text('required_skills')->nullable(); // JSON or comma-separated string
            $table->enum('status', ['draft', 'published', 'cancelled'])->default('draft');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade'); // coordinator/admin
            $table->timestamps();
        });

        // 4. registrations (Many-to-Many with extra fields)
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['pending', 'approved', 'rejected', 'cancelled'])->default('pending');
            $table->dateTime('check_in')->nullable();
            $table->dateTime('check_out')->nullable();
            $table->decimal('hours_contributed', 8, 2)->default(0.00);
            $table->boolean('attended')->default(false);
            $table->timestamps();
            $table->unique(['user_id', 'event_id']);
        });

        // 5. attendances (For verification log, linking to registration)
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->constrained()->onDelete('cascade');
            $table->foreignId('verified_by')->constrained('users')->onDelete('cascade'); // coordinator/admin
            $table->dateTime('check_in');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // 6. certificates
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->constrained()->onDelete('cascade');
            $table->string('file_path');
            $table->dateTime('issued_at');
            $table->timestamps();
            $table->unique('registration_id');
        });

        // 7. feedbacks
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->constrained()->onDelete('cascade');
            $table->integer('rating');
            $table->text('comment')->nullable();
            $table->timestamps();
            $table->unique('registration_id');
        });

        // 8. activity_logs
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('action');
            $table->text('meta')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('feedbacks');
        Schema::dropIfExists('certificates');
        Schema::dropIfExists('attendances');
        Schema::dropIfExists('registrations');
        Schema::dropIfExists('events');
        Schema::dropIfExists('volunteer_profiles');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'role', 'photo']);
        });
    }
};

