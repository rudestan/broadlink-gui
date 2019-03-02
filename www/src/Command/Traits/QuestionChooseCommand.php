<?php

namespace BRMControl\Command\Traits;

use BRMControl\Device\RMPPlus;
use BRMControl\Device\Command;
use BRMControl\Device\Remote;
use Symfony\Component\Console\Question\ChoiceQuestion;

trait QuestionChooseCommand
{
    private function questionChooseCommand(RMPPlus $device, Remote $remote): ?Command
    {
        $commandsList = $remote->getCommandsWithNamesAsKeys();

        $answers = array_keys($commandsList);
        $answers[] = '<warn>Exit</warn>';

        $question = new ChoiceQuestion(
            '<question>Please Choose a Command:</question>',
            $answers
        );

        $answer = $this->helper->ask($this->input, $this->output, $question);

        return $commandsList[$answer] ?? null;
    }
}
