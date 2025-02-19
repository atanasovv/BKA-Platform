<?php

class QuestionRepository extends BaseRepository {
    public function __construct() {
        parent::__construct('bka_questions');
    }

    protected function to_array($question) {
        return [
            'wp_user_id' => $question->wp_user_id,
            'type' => $question->type,
        ];
    }

    protected function to_object($row) {
        return new Question(
            $row->id,
            $row->wp_user_id,
            $row->type
        );
    }
}
?>