<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('attendances')) {
            Schema::table('attendances', function (Blueprint $table) {
                if (!Schema::hasIndex('attendances', ['student_id', 'created_at'])) {
                    $table->index(['student_id', 'created_at']);
                }
                if (!Schema::hasIndex('attendances', ['class_session_id', 'status'])) {
                    $table->index(['class_session_id', 'status']);
                }
                if (!Schema::hasIndex('attendances', ['status'])) {
                    $table->index('status');
                }
            });
        }

        if (Schema::hasTable('class_sessions')) {
            Schema::table('class_sessions', function (Blueprint $table) {
                if (!Schema::hasIndex('class_sessions', ['subject_id', 'date'])) {
                    $table->index(['subject_id', 'date']);
                }
                if (!Schema::hasIndex('class_sessions', ['date'])) {
                    $table->index('date');
                }
            });
        }

        if (Schema::hasTable('subject_student')) {
            Schema::table('subject_student', function (Blueprint $table) {
                if (!Schema::hasIndex('subject_student', ['student_id', 'subject_id'])) {
                    $table->index(['student_id', 'subject_id']);
                }
            });
        }

        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasIndex('users', ['role'])) {
                    $table->index('role');
                }
            });
        }
    }

    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropIndex(['student_id', 'created_at']);
            $table->dropIndex(['class_session_id', 'status']);
            $table->dropIndex(['status']);
        });

        Schema::table('class_sessions', function (Blueprint $table) {
            $table->dropIndex(['subject_id', 'date']);
            $table->dropIndex(['date']);
        });

        Schema::table('subject_student', function (Blueprint $table) {
            $table->dropIndex(['student_id', 'subject_id']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['role']);
        });
    }
};