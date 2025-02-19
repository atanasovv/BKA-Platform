<?php
// Prevent direct access to this file
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}


# Database Table names
define('BKA_USERS_TABLE', 'bka_users');
define('BKA_USER_DETAILS_TABLE', 'bka_user_details');
define('BKA_SESSIONS_TABLE', 'bka_sessions');
define('BKA_QUESTIONS_TABLE', 'bka_questions');
define('BKA_QUESTION_TRANSLATIONS_TABLE', 'bka_question_translations');

define('ALL_TABLES', [
    BKA_USERS_TABLE,
    BKA_USER_DETAILS_TABLE,
    BKA_SESSIONS_TABLE,
    BKA_QUESTIONS_TABLE,
    BKA_QUESTION_TRANSLATIONS_TABLE
]);

