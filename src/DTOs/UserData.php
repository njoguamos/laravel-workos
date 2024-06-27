<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkOS\DTOs;

use Carbon\CarbonImmutable;
use NjoguAmos\LaravelWorkOS\Concerns\HasWorkOSTimestamps;
use NjoguAmos\LaravelWorkOS\Contracts\Transformers;
use NjoguAmos\LaravelWorkOS\Contracts\WorkOSTimestamps;
use NjoguAmos\LaravelWorkOS\Enums\WorkOSObject;
use Saloon\Contracts\DataObjects\WithResponse;
use Saloon\Traits\Responses\HasResponse;

/**
 * @link https://workos.com/docs/reference/user-management/user
 */
final class UserData implements Transformers, WithResponse, WorkOSTimestamps
{
    use HasResponse;
    use HasWorkOSTimestamps;

    public function __construct(
        public readonly WorkOSObject  $object,
        public readonly string  $id,
        public readonly string  $email,
        public readonly bool    $email_verified,
        public readonly CarbonImmutable $created_at,
        public readonly CarbonImmutable $updated_at,
        public readonly ?string $first_name = null,
        public readonly ?string $last_name = null,
        public readonly ?string $profile_picture_url = null,
    ) {
    }

    public function array(): array
    {
        return [
            'object'              => $this->object->value,
            'id'                  => $this->id,
            'email'               => $this->email,
            'email_verified'      => $this->email_verified,
            'created_at'          => $this->format($this->created_at),
            'updated_at'          => $this->format($this->updated_at),
            'first_name'          => $this->first_name,
            'last_name'           => $this->last_name,
            'profile_picture_url' => $this->profile_picture_url,
        ];
    }

    public function json(): string|false
    {
        return json_encode($this->array());
    }
}
