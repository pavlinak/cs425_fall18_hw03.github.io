<?php
class question
{
    private $question;
    private $choice1;
    private $choice2;
    private $choice3;
    private $choice4;
    private $answer;
    private $questions_file = "questions.xml";
    
    private $xml;
    
    private $easy_questions = array();
    private $medium_questions = array();
    private $hard_questions = array();
    
    private $question_points = 0;
    private $current = 1;

    public function __construct()
    {
        $this->xml = simplexml_load_file($this->questions_file) or die("Error: Cannot create object");
    }
    public function getQuestion()
    {
        return $this->question;
    }
    public function getChoice1()
    {
        return $this->choice1;
    }
    public function getChoice2()
    {
        return $this->choice2;
    }
    public function getChoice3()
    {
        return $this->choice3;
    }
    public function getChoice4()
    {
        return $this->choice4;
    }
    public function getRightChoice()
    {
        return $this->answer;
    }
    public function getquestion_points()
    {
        return $this->question_points;
    }
    function setQuestions($easy_questions, $medium_questions, $hard_questions)
    {
        $this->easy_questions = $easy_questions;
        $this->medium_questions = $medium_questions;
        $this->hard_questions = $hard_questions;
    }
    function setLevel($level)
    {
        $this->current = $level;
    }
    function fetchQuestions()
    {
        do {
            $flag = 0;
            $random = rand(0, 24);
            if ($this->current == 0)
                foreach ($this->easy_questions as $question_item)
                    if ($random == $question_item) $flag = 1;
            if ($this->current == 1)
                foreach ($this->medium_questions as $question_item)
                    if ($random == $question_item) $flag = 1;
            if ($this->current == 2)
                foreach ($this->hard_questions as $question_item)
                    if ($random == $question_item) $flag = 1;
        } while ($flag);
        if ($this->current == 0) {
            $this->question_points = 10;
            array_push($this->easy_questions, $random);
        } else if ($this->current == 1) {
            $this->question_points = 20;
            array_push($this->medium_questions, $random);
        } else if ($this->current == 2) {
            $this->question_points = 30;
            array_push($this->hard_questions, $random);
        }
        $this->question = $this->xml->question_level[$this->current]->question_item[$random]->question;
        $this->choice1 = $this->xml->question_level[$this->current]->question_item[$random]->answer[0];
        $this->choice2 = $this->xml->question_level[$this->current]->question_item[$random]->answer[1];
        $this->choice3 = $this->xml->question_level[$this->current]->question_item[$random]->answer[2];
        $this->choice4 = $this->xml->question_level[$this->current]->question_item[$random]->answer[3];
        $this->answer = $this->xml->question_level[$this->current]->question_item[$random]->correct;
        return $random;
    }
}