<?php


class QuestionTranslationRepository extends BaseRepository {
    public function __construct() {
        parent::__construct('bka_question_translations');
    }

    protected function to_array($translation) {
        return [
            'question_id' => $translation->question_id,
            'language_code' => $translation->language_code,
            'question_text' => $translation->question_text,
            'options' => $translation->options,
        ];
    }

    protected function to_object($row) {
        return new QuestionTranslation(
            $row->id,
            $row->question_id,
            $row->language_code,
            $row->question_text,
            $row->options
        );
    }
}
?>