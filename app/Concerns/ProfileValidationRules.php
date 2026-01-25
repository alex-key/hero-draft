<?php

namespace App\Concerns;

use App\Models\User;
use Illuminate\Validation\Rule;

trait ProfileValidationRules
{
    /**
     * Get the validation rules used to validate user profiles.
     *
     * @return array<string, array<int, \Illuminate\Contracts\Validation\Rule|array<mixed>|string>>
     */
    protected function profileRules(?int $userId = null): array
    {
        return [
            'username' => $this->usernameRules($userId),
            'name' => $this->nameRules(),
        ];
    }

    /**
     * Get the validation rules used to validate username.
     *
     * @return array<int, \Illuminate\Contracts\Validation\Rule|array<mixed>|string>
     */
    protected function usernameRules($userId): array
    {
        return [
          'required',
          'string',
          'max:20',
          $userId === null
              ? Rule::unique(User::class)
              : Rule::unique(User::class)->ignore($userId),
          ];
    }

  /**
   * Get the validation rules used to validate user full name.
   *
   * @return array<int, \Illuminate\Contracts\Validation\Rule|array<mixed>|string>
   */
  protected function nameRules(): array
  {
    return ['string', 'max:255'];
  }
}
