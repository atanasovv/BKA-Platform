<?php

class QuestionTranslation {
    public $id;
    public $question_id;
    public $language_code;
    public $question_text;
    public $options;

    public function __construct($id, $question_id, $language_code, $question_text, $options) {
        $this->id = $id;
        $this->question_id = $question_id;
        $this->language_code = $language_code;
        $this->question_text = $question_text;
        $this->options = $options;
    }
}
?>