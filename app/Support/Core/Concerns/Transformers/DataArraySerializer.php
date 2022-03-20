<?php

namespace App\Support\Core\Concerns\Transformers;

use League\Fractal\Serializer\DataArraySerializer as BaseSerializer;

class DataArraySerializer extends BaseSerializer
{
    /**
     * {@inheritDoc}
     */
    public function mergeIncludes(array $transformedData, array $includedData): array
    {
        $includedData = array_map(function ($include) {
            return $include['data'];
        }, $includedData);

        return parent::mergeIncludes($transformedData, $includedData);
    }
}
