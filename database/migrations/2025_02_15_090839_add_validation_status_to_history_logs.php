<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddValidationStatusToHistoryLogs extends Migration
{
    public function up()
    {
        Schema::table('history_logs', function (Blueprint $table) {
            $table->enum('validation_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->unsignedBigInteger('validated_by')->nullable();
            $table->timestamp('validated_at')->nullable();

            $table->foreign('validated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('history_logs', function (Blueprint $table) {
            $table->dropColumn(['validation_status', 'validated_by', 'validated_at']);
        });
    }
}
