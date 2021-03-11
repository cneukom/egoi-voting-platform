<?php

return [
    'name' => config('app.name'),
    'voting' => [
        'info' => [
            'no_open_votes_voter' => 'There\'s no ongoing vote currently. We\'ll inform you in your Keybase group chat as soon as a new vote is published.',
            'no_open_votes_admin' => 'There\'s no ongoing vote currently. Use the button above to open a new vote.',
            'no_closed_votes' => 'No past votes yet. Once a vote is closed, we\'ll show the results here.',
        ],
        'open_votes' => 'Open Votes',
        'closed_votes' => 'Past Votes',
        'question' => 'Question',
        'selected_option' => 'Selected option',
        'votes' => 'Votes',
        'undecided' => 'tie',
        'closed_at' => 'Closed at',
        'closes_at' => 'Due by',
        'closes_at_format' => 'H:i',
        'action' => 'Action',
        'vote' => 'Go to vote',
        'voted' => 'Voted already',
        'create' => 'Create Vote',
        'results' => 'View results',
    ],
];
