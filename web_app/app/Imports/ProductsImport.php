<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\ProductImage;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductsImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        // DEBUG: Xem dữ liệu đọc được
        //Log::info('Import rows count: ' . $rows->count());
        //Log::info('First row: ' . json_encode($rows->first()));

        if ($rows->isEmpty()) {
            Log::warning('No rows to import');
            return;
        }

        DB::beginTransaction();
        try {
            $imported = 0;
            foreach ($rows as $index => $row) {
                // DEBUG: Log từng row
                Log::info("Row {$index}: " . json_encode($row->toArray()));

                // Lấy name - thử nhiều cách
                $name = $row['name'] ?? $row[2] ?? null;

                if (empty($name)) {
                    Log::warning("Row {$index}: name is empty, skipped");
                    continue;
                }

                // Lấy data với fallback theo index
                $categoryId = $row['category_id'] ?? $row[0] ?? null;
                $manufacturerId = $row['manufacturer_id'] ?? $row[1] ?? null;
                $price = $row['price'] ?? $row[4] ?? 0;
                $stockQty = $row['stock_quantity'] ?? $row[5] ?? 0;
                $description = $row['description'] ?? $row[6] ?? null;
                $memory = $row['memory'] ?? $row[7] ?? null;
                $cpu = $row['cpu'] ?? $row[8] ?? null;
                $graphic = $row['graphic'] ?? $row[9] ?? null;
                $powerSpecs = $row['power_specs'] ?? $row[10] ?? null;
                $imageUrl = $row['image_url'] ?? $row[11] ?? null;

                // Tạo Product
                $product = Product::create([
                    'category_id' => $categoryId,
                    'manufacturer_id' => $manufacturerId,
                    'name' => $name,
                    'slug' => Str::slug($name),
                    'description' => $description,
                    'price' => $price ?: 0,
                    'stock_quantity' => $stockQty ?: 0,
                ]);

                ProductDetail::updateOrCreate(
                    ['product_id' => $product->id],
                    [
                        'memory' => $memory,
                        'cpu' => $cpu,
                        'graphic' => $graphic,
                        'power_specs' => $powerSpecs,
                    ]
                );

                // Tạo Product Image
                if (!empty($imageUrl)) {
                    ProductImage::create([
                        'product_id' => $product->id,
                        'url' => $imageUrl,
                        'is_avatar' => true,
                    ]);
                }

                $imported++;
            }

            DB::commit();
            Log::info("Import completed: {$imported} products imported");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Import failed: " . $e->getMessage());
            Log::error("Stack trace: " . $e->getTraceAsString());
            throw $e;
        }
    }

    public function headingRow(): int
    {
        return 1;
    }
}
