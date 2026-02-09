<?php

namespace App\Client\Requests;

class CreateInstanceRequestData extends RequestData
{
    public function __construct(
        public readonly string $environmentId,
        public readonly ?string $name = null,
        public readonly ?string $type = null,
        public readonly ?string $size = null,
        public readonly ?string $scalingType = null,
        public readonly ?int $minReplicas = null,
        public readonly ?int $maxReplicas = null,
        public readonly ?bool $usesScheduler = null,
        public readonly ?int $scalingCpuThresholdPercentage = null,
        public readonly ?int $scalingMemoryThresholdPercentage = null,
    ) {
        //
    }

    public function toRequestData(): array
    {
        return $this->filter([
            'name' => $this->name,
            'type' => $this->type,
            'size' => $this->size,
            'scaling_type' => $this->scalingType,
            'min_replicas' => $this->minReplicas,
            'max_replicas' => $this->maxReplicas,
            'uses_scheduler' => $this->usesScheduler,
            'scaling_cpu_threshold_percentage' => $this->scalingCpuThresholdPercentage,
            'scaling_memory_threshold_percentage' => $this->scalingMemoryThresholdPercentage,
        ]);
    }
}
