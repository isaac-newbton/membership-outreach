<?php

namespace App\DataFixtures;

use App\Entity\Organization;
use App\Entity\Question;
use App\Entity\Survey;
use App\Entity\SurveyTemplate;
use App\Service\Question\QuestionHandler;
use App\Service\Survey\SurveyHandler;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class SurveyFixtures extends Fixture
{
    private $surveyHandler;

    public function __construct(SurveyHandler $surveyHandler){
        $this->surveyHandler = $surveyHandler;
    }

    public function load(ObjectManager $manager)
    {
        $org1 = new Organization();
        $org1->setCustomId('DD-001-SURV');
        $org1->setName('Digi Dev, LLC');

        $org2 = new Organization();
        $org2->setCustomId('FK-002-SURV');
        $org2->setName('FunnelKake');

        $q1 = new Question();
        $q1->setQuestion('Pick the true option');
        $q1->setType(QuestionHandler::INPUT_BOOLEAN);

        $q2 = new Question();
        $q2->setQuestion('Enter a number');
        $q2->setType(QuestionHandler::INPUT_NUMBER);

        $q3 = new Question();
        $q3->setQuestion('Enter your name');
        $q3->setType(QuestionHandler::INPUT_TEXT);

        $q4 = new Question();
        $q4->setQuestion('Write the complete text for the extant volumes of "A Song of Ice and Fire"');
        $q4->setType(QuestionHandler::INPUT_TEXTAREA);

        $q5 = new Question();
        $q5->setQuestion('What is greater?');
        $q5->setOptions('6.02e23,A googol,A googoplex,Graham\'s number');
        $q5->setType(QuestionHandler::INPUT_SELECT);

        $template = new SurveyTemplate();
        $template->setName('Default survey template');
        $template->addQuestion($q1);
        $template->addQuestion($q2);
        $template->addQuestion($q3);
        $template->addQuestion($q4);
        $template->addQuestion($q5);

        $survey1 = new Survey();
        $survey1->setSurveyTemplate($template);
        $survey1->setOrganization($org1);
        $survey1->setDueDate(new \DateTime());

        $survey2 = new Survey();
        $survey2->setSurveyTemplate($template);
        $survey2->setOrganization($org2);
        $survey2->setDueDate(new \DateTime('+1 week'));

        $manager->persist($org1);
        $manager->persist($org2);
        $manager->persist($q1);
        $manager->persist($q2);
        $manager->persist($q3);
        $manager->persist($q4);
        $manager->persist($q5);
        $manager->persist($template);
        $manager->persist($survey1);
        $manager->persist($survey2);

        $manager->flush();

        $this->surveyHandler->generateResponses($survey1, $manager);
        $this->surveyHandler->generateResponses($survey2, $manager);
    }
}
