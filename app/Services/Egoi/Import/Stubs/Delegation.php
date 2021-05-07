<?php


namespace App\Services\Egoi\Import\Stubs;

/**
 * @property-read string $name
 * @property-read string $contestantCount
 * @property-read string $leaderCount
 * @property-read string $guestCount
 * @property-read string $alreadyPayed
 * @property-read string $participationMode
 * @property-read string $attendanceReviewProgress
 * @property-read string $translations
 * @property-read string $deliveryAddress
 * @property-read string $contributionReviewProgress
 * @property-read string $registration_url
 * @property-read string $countryCode
 */
class Delegation extends Stub
{
    const FIELDS = [
        'name' => 0,
        'contestantCount' => 1,
        'leaderCount' => 2,
        'guestCount' => 3,
        'alreadyPayed' => 4,
        'participationMode' => 5,
        'attendanceReviewProgress' => 6,
        'translations' => 7,
        'deliveryAddress' => 8,
        'contributionReviewProgress' => 9,
        'registration_url' => 10,
        'countryCode' => 11,
    ];
}
