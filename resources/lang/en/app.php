<?php

return [
    'name' => config('app.name'),
    'contestant' => [
        'label' => 'Contestant',
    ],
    'evidence' => [
        'label' => 'File name',
        'overview' => 'Video Evidence Overview',
        'screenCaptures' => 'Screen Captures',
        'workScenes' => 'Work Scenes',
        'status' => [
            'created' => 'being uploaded',
            'present' => 'uploaded',
        ],
        'drag_or_click' => 'Drag or click here to upload evidence.',
    ],
    'modal' => [
        'delete' => [
            'title' => 'Remove Evidence',
            'message' => 'Are you sure to permanently remove the following evidence?',
        ],
        'actions' => [
            'cancel' => 'Cancel',
            'delete' => 'Delete',
        ],
    ],
];
