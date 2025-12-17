<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attribute;
use App\Models\AttributeValue;

class AttributeSeeder extends Seeder
{
    public function run()
    {
        $attributes = [
            'size' => ['S', 'M', 'L', 'XL'],
            'color' => ['Red', 'Blue', 'White', 'Black'],
            'fit' => ['Slim', 'Regular', 'Loose']
        ];

        foreach ($attributes as $attrName => $values) {
            $attr = Attribute::create([
                'name' => $attrName,
                'slug' => strtolower($attrName)
            ]);

            foreach ($values as $val) {
                AttributeValue::create([
                    'attribute_id' => $attr->id,
                    'value' => $val
                ]);
            }
        }
    }
}
