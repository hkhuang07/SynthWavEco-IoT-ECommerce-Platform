<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Product;
$product = Product::first();
Cart::add([
    'id' => $product->id,
    'name' => $product->name,
    'price' => $product->price,
    'qty' => 1,
    'weight' => 0,
    'options' => [
        'image' => 'products/test.jpg'
    ]
]);

$item = Cart::content()->first();
echo "options class: " . get_class($item->options) . "\n";
echo "isset(options->image): " . (isset($item->options->image) ? 'yes' : 'no') . "\n";
echo "options->image value: " . $item->options->image . "\n";
echo "options['image'] value: " . $item->options['image'] . "\n";
echo "isset(options['image']): " . (isset($item->options['image']) ? 'yes' : 'no') . "\n";
