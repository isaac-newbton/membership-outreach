<?php
namespace App\Service\Survey;

use App\Entity\Survey;
use App\Entity\SurveyResponse;
use Doctrine\ORM\EntityManager;

class SurveyHandler{

    const STATUS_OPEN = 1;
    const STATUS_CLOSED = 2;

    public function getSurveyStatusTypes(){
        return [
            'open' => Survey::STATUS_OPEN,
            'closed' => Survey::STATUS_CLOSED,
        ];
    }

	public function generateResponses(Survey $survey, EntityManager $entity_manager){
		$questions = $survey->getSurveyTemplate()->getQuestions();
		if($questions){
			foreach($questions as $question){
				$response = new SurveyResponse();
				$response->setSurvey($survey);
				$response->setQuestion($question);
				$entity_manager->persist($response);
			}
			$entity_manager->flush();
		}
	}

}