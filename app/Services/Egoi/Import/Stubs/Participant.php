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
 * @property-read string $username
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
        'shirtSize' => 8,
        'shirtFit' => 9,
        'sockSize' => 10,
        'nameOnDocuments' => 11,
        'portrait' => 12,
        'papers' => 13,
        'consent' => 14,
        'personalDataReviewProgress' => 15,
        'nationality' => 16,
        'passportNumber' => 17,
        'passportValidityFrom' => 18,
        'passportValidityTo' => 19,
        'passportIssueCountry' => 20,
        'countryOfResidence' => 21,
        'placeOfBirth' => 22,
        'immigrationReviewProgress' => 23,
        'diet' => 24,
        'allergies' => 25,
        'singleRoom' => 26,
        'eventPresenceReviewProgress' => 27,
        'username' => 28,
    ];

    public function __get($key)
    {
        if ($key === 'delegationName') {
            $key = 'delegation.name';
        }
        return parent::__get($key);
    }
}
