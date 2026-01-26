<?php

namespace App\Dto;

use App\Enums\LogLevel;
use App\Enums\LogType;
use Carbon\CarbonImmutable;

class EnvironmentLog extends Data
{
    public function __construct(
        public readonly string $message,
        public readonly LogLevel $level,
        public readonly LogType $type,
        public readonly CarbonImmutable $loggedAt,
        public readonly ?array $data = null,
    ) {
        //
    }

    public static function fromApiResponse(array $response, ?array $item = null): self
    {
        $data = $item ?? $response;

        return new self(
            message: $data['message'] ?? '',
            level: LogLevel::from($data['level'] ?? 'info'),
            type: LogType::from($data['type'] ?? 'application'),
            loggedAt: isset($data['logged_at']) ? CarbonImmutable::parse($data['logged_at']) : CarbonImmutable::now(),
            data: $data['data'] ?? null,
        );
    }

    public function isAccessLog(): bool
    {
        return $this->type === LogType::ACCESS;
    }

    public function isApplicationLog(): bool
    {
        return $this->type === LogType::APPLICATION;
    }

    public function isExceptionLog(): bool
    {
        return $this->type === LogType::EXCEPTION;
    }

    public function isSystemLog(): bool
    {
        return $this->type === LogType::SYSTEM;
    }

    public function getAccessData(): ?array
    {
        if (! $this->isAccessLog() || ! is_array($this->data)) {
            return null;
        }

        return [
            'status' => $this->data['status'] ?? null,
            'method' => $this->data['method'] ?? null,
            'path' => $this->data['path'] ?? null,
            'duration_ms' => $this->data['duration_ms'] ?? null,
            'bytes_sent' => $this->data['bytes_sent'] ?? null,
            'ip' => $this->data['ip'] ?? null,
            'user_agent' => $this->data['user_agent'] ?? null,
            'country' => $this->data['country'] ?? null,
        ];
    }

    public function getApplicationData(): ?array
    {
        if (! $this->isApplicationLog() || ! is_array($this->data)) {
            return null;
        }

        return [
            'channel' => $this->data['channel'] ?? null,
            'context' => $this->data['context'] ?? null,
            'extra' => $this->data['extra'] ?? null,
        ];
    }

    public function getExceptionData(): ?array
    {
        if (! $this->isExceptionLog() || ! is_array($this->data)) {
            return null;
        }

        return [
            'class' => $this->data['class'] ?? null,
            'code' => $this->data['code'] ?? null,
            'file' => $this->data['file'] ?? null,
            'trace' => $this->data['trace'] ?? null,
        ];
    }

    public function toArray(): array
    {
        return [
            'message' => $this->message,
            'level' => $this->level->value,
            'type' => $this->type->value,
            'logged_at' => $this->loggedAt->toIso8601String(),
            'data' => $this->data,
        ];
    }

    public function __toString(): string
    {
        $timestamp = $this->loggedAt->format('Y-m-d H:i:s');
        $level = strtoupper($this->level->value);
        $type = $this->type->value;

        $output = "[{$timestamp}] [{$level}] [{$type}] {$this->message}";

        if ($this->isAccessLog() && $accessData = $this->getAccessData()) {
            $output .= " | {$accessData['method']} {$accessData['path']} | {$accessData['status']} | {$accessData['duration_ms']}ms";
        }

        if ($this->isExceptionLog() && $exceptionData = $this->getExceptionData()) {
            $output .= " | {$exceptionData['class']}";
            if ($exceptionData['code']) {
                $output .= " ({$exceptionData['code']})";
            }
        }

        return $output;
    }
}
