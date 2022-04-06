<?php
if ( ! isset($appConfig)) {
    $appConfig = [];
}
/**
 * Set $appConfig locales
 * --------------------------------------------- 
 */
$appConfig['locales'] = [
    'dayNames' => [
        'Monday' => 'Montag', 
        'Tuesday' => 'Dienstag', 
        'Wednesday' => 'Mittwoch', 
        'Thursday' => 'Donnerstag', 
        'Friday' => 'Freitag', 
        'Saturday' => 'Samstag',
        'Sunday' => 'Sonntag',
    ],
    'monthNames' => ['Januar','Februar','März','April','Mai','Juni','Juli','August','September','Oktober','November','Dezember',],
];
