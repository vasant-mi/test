<?php

namespace App\Api\V1\Transformers;

use App\Notification;
use App\Notifications\DownloadCouponAfter2DaysNotification;
use App\Status;
use App\User;
use League\Fractal\TransformerAbstract;

/**
 * Class UserTransformer
 * @package App\Api\V1\Transformers
 */
class UserTransformer extends TransformerAbstract
{

    /**
     * @param User $user
     */
    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'date_of_birth' => $user->date_of_birth,
            'newsletter' => $user->newsletter,
            'country_id' => $user->country_id,
            'status_id' => $user->status_id
        ];
    }
}