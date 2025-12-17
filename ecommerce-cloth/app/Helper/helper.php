<?php

function generateCombinations($arrays)
{
    $result = [[]];
    foreach ($arrays as $property => $property_values) {
        $tmp = [];
        foreach ($result as $result_item) {
            foreach ($property_values as $value) {
                $tmp[] = array_merge($result_item, [$value]);
            }
        }
        $result = $tmp;
    }
    return $result;
}

function generateSKU($product_id, $value_ids)
{
    return 'P' . $product_id . '-' . implode('-', $value_ids);
}
