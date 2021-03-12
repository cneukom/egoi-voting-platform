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
    'results' => [
        'results' => 'Voting Results',
        'no_votes' => '(Nobody voted for this option)',
        'back' => 'Back to overview',
    ],
    'create' => [
        'create_vote' => 'Create Vote',
        'instructions' => [
            'basic' => 'To create a new vote, supply at least a question and two answer options.',
            'voting_deadline' => 'The vote starts immediately and results will only be visible after the vote has been closed. You can close a vote early as soon as everybody has voted.',
        ],
        'confirm' => 'You are about to open a vote. The vote will start immediately and you cannot make any changes once the vote has started. Please review the voting details carefully. The voting duration will only start when the vote is opened.',
        'question' => 'Question',
        'information' => 'Additional information',
        'optional' => 'optional',
        'duration' => 'Voting duration',
        'duration_unit' => 'minutes',
        'closes_at_approx' => '(approximately at :time)',
        'options' => 'Answer options',
        'option' => 'Answer option',
        'next' => 'Next step',
        'back' => 'Back',
        'create' => 'Create & Open Vote',
    ],
    'vote' => [
        'vote' => 'Vote',
        'back' => 'Back to overview',
        'instructions' => 'The voting deadline is at :time. You have one vote and cannot change it once submitted.',
        'submit' => 'Vote now',
    ],
    'vote_closed' => [
        'vote_closed' => 'Vote closed',
        'message' => 'You can not vote anymore, as this vote has been closed at :time.',
    ],
    'vote_participated' => [
        'vote_participated' => 'Already participated',
        'message' => 'You already participated in this vote.',
    ],
];
