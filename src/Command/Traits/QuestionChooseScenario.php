<?php

namespace BRMControl\Command\Traits;

use BRMControl\Device\RMPPlus;
use BRMControl\Device\Scenario;
use Symfony\Component\Console\Question\ChoiceQuestion;

trait QuestionChooseScenario
{
    private function questionChooseScenario(RMPPlus $device): ?Scenario
    {
        $scenarioList = $device->getScenariosWithNamesAsKeys();
        $answers = array_keys($scenarioList);
        $question = new ChoiceQuestion(
            '<question>Please Choose a Scenario to play:</question>',
            $answers
        );

        $answer = $this->helper->ask($this->input, $this->output, $question);

        return $scenarioList[$answer] ?? null;
    }
}
