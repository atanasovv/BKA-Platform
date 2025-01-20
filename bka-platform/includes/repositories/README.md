

```php
# Include the repositories
require_once 'includes/repositories/ClientRepository.php';
require_once 'includes/repositories/CoachRepository.php';
require_once 'includes/repositories/SessionRepository.php';
require_once 'includes/repositories/QuestionRepository.php';
require_once 'includes/repositories/QuestionTranslationRepository.php';

// Create a new client
$client_repo = new ClientRepository();
$new_client = new Client(null, 1, current_time('mysql'), '12345', 'active', current_time('mysql'));
$client_id = $client_repo->insert($new_client);

// Create a new coach
$coach_repo = new CoachRepository();
$new_coach = new Coach(null, 1, current_time('mysql'), '12345', 'active', current_time('mysql'), 0, 'Short description', 'About');
$coach_id = $coach_repo->insert($new_coach);

// Create a new session
$session_repo = new SessionRepository();
$new_session = new Session(null, current_time('mysql'), 'scheduled', $coach_id, $client_id);
$session_id = $session_repo->insert($new_session);

// Create a new question
$question_repo = new QuestionRepository();
$new_question = new Question(null, 1, 'dropdown');
$question_id = $question_repo->insert($new_question);

// Create a new question translation
$question_translation_repo = new QuestionTranslationRepository();
$new_translation = new QuestionTranslation(null, $question_id, 'en_US', 'What is your preferred option?', json_encode(['Option 1', 'Option 2', 'Option 3']));
$translation_id = $question_translation_repo->insert($new_translation);
```