<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class ModelColorCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return json_decode($value, true);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (!is_array($value)) {
            throw new \InvalidArgumentException("The {$key} field must be an array.");
        }

        $formattedColors = array_map(function ($color) {
            if (!isset($color['name'], $color['hex'], $color['image'], $color['cash_price'], $color['installment_price'])) {
                throw new \InvalidArgumentException("Each color must contain name, hex, image, cash_price and installment_price  fields.");
            }

            return [
                'name' => (string) $color['name'],
                'hex' => (string) $color['hex'],
                'image' => (string) $color['image'],
                'cash_price' => number_format((float) $color['cash_price'], 2, '.', ''),
                'installment_price' => number_format((float) $color['installment_price'], 2, '.', ''),                
            ];
        }, $value);

        return json_encode($formattedColors);
    }
}
