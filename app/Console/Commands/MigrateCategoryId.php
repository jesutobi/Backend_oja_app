<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrateCategoryId extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:migrate-category-id';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate category ID from JSON column to new category_id column';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DB::table('products')->orderBy('id')->chunk(100, function ($products) {
            foreach ($products as $product) {
                $categoryJson = $product->product_category;
                $categoryArray = json_decode($categoryJson, true);

                if (isset($categoryArray['id'])) {
                    DB::table('products')
                        ->where('id', $product->id)
                        ->update(['category_id' => $categoryArray['id']]);
                }
            }
        });

        $this->info('Category ID migration completed.');
    }
}
