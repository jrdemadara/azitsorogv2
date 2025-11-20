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
        Schema::connection('pgsql_main')->table('draft_invoices', function (Blueprint $table) {
            $table->date('date')->nullable()->after('type');
            $table->string('terms')->nullable()->after('date');
            $table->decimal('vatable_sales', 15, 2)->nullable()->after('total_amount');
            $table->decimal('vat', 15, 2)->nullable()->after('vatable_sales');
            $table->decimal('vat_exempt_sales', 15, 2)->nullable()->after('vat');
            $table->decimal('zero_rated_sales', 15, 2)->nullable()->after('vat_exempt_sales');
            $table->decimal('total_sales_vat_inclusive', 15, 2)->nullable()->after('zero_rated_sales');
            $table->decimal('less_vat', 15, 2)->nullable()->after('total_sales_vat_inclusive');
            $table->decimal('amount_net_of_vat', 15, 2)->nullable()->after('less_vat');
            $table->decimal('discount', 15, 2)->nullable()->after('amount_net_of_vat');
            $table->string('discount_id_number')->nullable()->after('discount');
            $table->decimal('add_vat', 15, 2)->nullable()->after('discount_id_number');
            $table->decimal('withholding_tax', 15, 2)->nullable()->after('add_vat');
            $table->decimal('total_amount_due', 15, 2)->nullable()->after('withholding_tax');
            $table->string('printed_name')->nullable()->after('total_amount_due');
            $table->enum('status', ['draft', 'final'])->default('draft')->after('printed_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('pgsql_main')->table('draft_invoices', function (Blueprint $table) {
            $table->dropColumn([
                'date',
                'terms',
                'vatable_sales',
                'vat',
                'vat_exempt_sales',
                'zero_rated_sales',
                'total_sales_vat_inclusive',
                'less_vat',
                'amount_net_of_vat',
                'discount',
                'discount_id_number',
                'add_vat',
                'withholding_tax',
                'total_amount_due',
                'printed_name',
                'status',
            ]);
        });
    }
};
