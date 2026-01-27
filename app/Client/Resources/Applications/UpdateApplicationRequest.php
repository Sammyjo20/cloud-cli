<?php

namespace App\Client\Resources\Applications;

use Saloon\Contracts\Body\HasBody;
use Saloon\Data\MultipartValue;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasMultipartBody;

class UpdateApplicationRequest extends Request implements HasBody
{
    use HasMultipartBody;

    protected Method $method = Method::PATCH;

    public function __construct(
        protected string $applicationId,
        protected ?string $name = null,
        protected ?string $slug = null,
        protected ?string $defaultEnvironmentId = null,
        protected ?string $repository = null,
        protected ?string $slackChannel = null,
        protected ?MultipartValue $avatar = null,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/applications/{$this->applicationId}";
    }

    protected function defaultBody(): array
    {
        $body = array_filter([
            'name' => $this->name,
            'slug' => $this->slug,
            'default_environment_id' => $this->defaultEnvironmentId,
            'repository' => $this->repository,
            'slack_channel' => $this->slackChannel,
        ]);

        if ($this->avatar !== null) {
            $body['avatar'] = $this->avatar;
        }

        return $body;
    }
}
