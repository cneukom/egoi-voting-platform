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
 * @property-read string $contributionReviewProgress
 * @property-read string $registration_url
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
        'contributionReviewProgress' => 8,
        'registration_url' => 9,
    ];
}
