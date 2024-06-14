<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkos\DTOs;

use NjoguAmos\LaravelWorkos\Contracts\Arrayable;

class UserDTO extends BaseDTO implements Arrayable
{
    /**
     * @link https://workos.com/docs/reference/user-management/user
     */
    public function __construct(
        public readonly string  $object,
        public readonly string  $id,
        public readonly string  $email,
        public readonly bool    $email_verified,
        public readonly string  $created_at,
        public readonly string  $updated_at,
        public readonly ?string $first_name = null,
        public readonly ?string $last_name = null,
        public readonly ?string $profile_picture_url = null,
    ) {
    }

    public function array(): array
    {
        return [
            'object'              => $this->object,
            'id'                  => $this->id,
            'email'               => $this->email,
            'email_verified'      => $this->email_verified,
            'created_at'          => $this->created_at,
            'updated_at'          => $this->updated_at,
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
