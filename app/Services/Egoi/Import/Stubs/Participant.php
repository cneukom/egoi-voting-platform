<?php


namespace App\Services\Egoi\Import\Stubs;

/**
 * @property-read string $role
 * @property-read string $delegationName
 * @property-read string $phone
 * @property-read string $givenName
 * @property-read string $familyName
 * @property-read string $birthday
 * @property-read string $email
 * @property-read string $gender
 * @property-read string $nameOnDocuments
 * @property-read string $portrait
 * @property-read string $papers
 * @property-read string $consent
 * @property-read string $personalDataReviewProgress
 * @property-read string $nationality
 * @property-read string $passportNumber
 * @property-read string $passportValidityFrom
 * @property-read string $passportValidityTo
 * @property-read string $passportIssueCountry
 * @property-read string $countryOfResidence
 * @property-read string $placeOfBirth
 * @property-read string $immigrationReviewProgress
 * @property-read string $shirtSize
 * @property-read string $shirtFit
 * @property-read string $diet
 * @property-read string $allergies
 * @property-read string $singleRoom
 * @property-read string $eventPresenceReviewProgress
 */
class Participant extends Stub
{
    const FIELDS = [
        'role' => 0,
        'delegation.name' => 1,
        'phone' => 2,
        'givenName' => 3,
        'familyName' => 4,
        'birthday' => 5,
        'email' => 6,
        'gender' => 7,
        'nameOnDocuments' => 8,
        'portrait' => 9,
        'papers' => 10,
        'consent' => 11,
        'personalDataReviewProgress' => 12,
        'nationality' => 13,
        'passportNumber' => 14,
        'passportValidityFrom' => 15,
        'passportValidityTo' => 16,
        'passportIssueCountry' => 17,
        'countryOfResidence' => 18,
        'placeOfBirth' => 19,
        'immigrationReviewProgress' => 20,
        'shirtSize' => 21,
        'shirtFit' => 22,
        'diet' => 23,
        'allergies' => 24,
        'singleRoom' => 25,
        'eventPresenceReviewProgress' => 26,
    ];

    public function __get($key)
    {
        if ($key === 'delegationName') {
            $key = 'delegation.name';
        }
        return parent::__get($key);
    }
}
