<?php

namespace App\Transformers;

use League\Fractal\Serializer\ArraySerializer;

class NoDataArraySerializer extends ArraySerializer
{
    public function collection($resourceKey, array $data)
    {
        if ($resourceKey === false) {
            return $data;
        }
        return [$resourceKey ?: 'data' => $data];
    }

    public function item($resourceKey, array $data)
    {
        if ($resourceKey === false) {
            return $data;
        }
        return [$resourceKey ?: 'data' => $data];
    }
}
