<?php

namespace App\Support\Concerns\Transformers;

use League\Fractal\Serializer\DataArraySerializer as BaseSerializer;

class DataArraySerializer extends BaseSerializer
{
    /**
     * {@inheritDoc}
     */
    public function mergeIncludes($transformedData, $includedData)
    {
        $includedData = array_map(function ($include) {
            return $include['data'];
        }, $includedData);

        return parent::mergeIncludes($transformedData, $includedData);
    }
}
