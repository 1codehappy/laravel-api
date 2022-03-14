<?php

namespace App\Support\Core\Concerns\Transformers;

use Illuminate\Support\Arr;

trait AddsTransformerCapabilities
{
    /**
     * @var array
     */
    protected array $fields = [];

    /**
     * Response for transformer
     *
     * @param array $data
     * @return array
     */
    public function transformed(array $data): array
    {
        Arr::forget($data, $this->fields);

        return $data;
    }

    /**
     * Remove specified fields
     *
     * @param array $fields
     * @return self
     */
    public function withoutFields(array $fields): self
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * Remove timestamps from data
     *
     * @return $this
     */
    public function withoutTimestamps(): self
    {
        return $this->withoutFields(['created_at', 'updated_at']);
    }

    /**
     * Remove includes from "default"
     *
     * @return $this
     */
    public function withoutIncludes(): self
    {
        $this->setDefaultIncludes([]);

        return $this;
    }

    /**
     * Includes to "default"
     *
     * @param string|array $resources
     * @return $this
     */
    public function includes($resources): self
    {
        if (is_array($resources) === false) {
            $resources = [$resources];
        }
        foreach ($resources as $resource) {
            $this->defaultIncludes[] = $resource;
        }

        return $this;
    }
}
