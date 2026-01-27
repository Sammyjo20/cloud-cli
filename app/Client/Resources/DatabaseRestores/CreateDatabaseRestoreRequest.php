<?php

namespace App\Client\Resources\DatabaseRestores;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class CreateDatabaseRestoreRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected string $clusterId,
        protected ?string $snapshotId = null,
        protected ?string $pointInTime = null,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/databases/clusters/{$this->clusterId}/restores";
    }

    protected function defaultBody(): array
    {
        return array_filter([
            'snapshot_id' => $this->snapshotId,
            'point_in_time' => $this->pointInTime,
        ]);
    }
}
