<?php

namespace App\Concerns;

use App\Dto\ValidationErrors;
use Illuminate\Http\Client\RequestException;
use RuntimeException;

use function Laravel\Prompts\error;

/**
 * @template TReturn
 */
trait Validates
{
    /**
     * @param  callable(ValidationErrors): TReturn  $callback
     * @return TReturn
     */
    protected function loopUntilValid(callable $callback, int $maxAttempts = 10): mixed
    {
        $result = null;
        $errors = new ValidationErrors;
        $attempts = 0;

        while (! $result) {
            if ($attempts >= $maxAttempts) {
                throw new RuntimeException('Maximum attempts reached');
            }

            $attempts++;

            try {
                $result = $callback($errors);

                return $result;
            } catch (RequestException $e) {
                $errors->clear();

                if ($e->response?->status() === 422) {
                    $responseErrors = $e->response->json()['errors'] ?? [];

                    if (count($responseErrors) > 0) {
                        foreach ($responseErrors as $field => $messages) {
                            error(ucwords($field).': '.implode(', ', $messages));
                            $errors->add($field);
                        }
                    } else {
                        $message = $e->response->json()['message'] ?? 'Unknown validation error';
                        error('Failed to create application: '.$message);
                    }
                } else {
                    error('Failed to create application: '.$e->getMessage());
                }
            }
        }

        return $result;
    }
}
