<?php

namespace App\Service\Question;

use App\Entity\Question;

class QuestionHandler {
    private $question;

    const INPUT_TEXT = 1;
    const INPUT_TEXTAREA = 2;
    const INPUT_NUMBER = 3;
    const INPUT_BOOLEAN = 4;
    const INPUT_SELECT = 5;

    public function getQuestionTypes(){
        return [
            'text' => self::INPUT_TEXT,
            'textarea' => self::INPUT_TEXTAREA,
            'number' => self::INPUT_NUMBER,
            'boolean' => self::INPUT_BOOLEAN,
            'select' => self::INPUT_SELECT,
        ];
    }

    public function getOptions(Question $question){
        $this->question = $question;
        return explode(',' , $question->options);
    }
}