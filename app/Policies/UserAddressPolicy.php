<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserAddressPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function update(User $currentUser, UserAddress $address)
    {
        return $currentUser->id == $address->user_id;
    }

    public function delete(User $currentUser, UserAddress $address)
    {
        return $currentUser->id == $address->user_id;
    }
}
