<?php

namespace App\Client\Resources\BackgroundProcesses;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetBackgroundProcessRequest extends Request
{
    protected Method $method = Method::GET;

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
