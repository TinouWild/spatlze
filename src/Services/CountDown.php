<?php
/**
 * Created by PhpStorm.
 * User: wilder
 * Date: 20/12/18
 * Time: 15:07
 */

namespace App\Services;


class CountDown
{
    public function DebatCountDonw(\DateTimeInterface $dateTime)
    {
        return $count = $dateTime->diff(new \DateTime());
    }
}