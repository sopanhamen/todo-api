<?php

use App\Modules\SiteInquiry\Enum\InquiryStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_inquiries', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('property_id');
            $table->string('name')->nullable();
            $table->string('phone_number')->index();
            $table->string('email')->nullable();
            $table->text('message');
            $table->text('url')->nullable();
            $table->enum('status', array_column(InquiryStatus::cases(), 'value'))
                ->default(InquiryStatus::PENDING->value);
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
        Schema::dropIfExists('site_inquiries');
    }
};
