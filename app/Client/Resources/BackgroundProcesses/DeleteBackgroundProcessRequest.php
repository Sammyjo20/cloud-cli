<?php

namespace App\Client\Resources\BackgroundProcesses;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class DeleteBackgroundProcessRequest extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        protected string $backgroundProcessId,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/background-processes/{$this->backgroundProcessId}";
    }
}
