<?php

namespace BRMControl\Command\Traits;

use BRMControl\Device\RMPPlus;
use BRMControl\Device\Remote;
use Symfony\Component\Console\Question\ChoiceQuestion;

trait QuestionChooseRemote
{
    private function questionChooseRemote(RMPPlus $device): ?Remote
    {
        $remotesList = $device->getRemotesWithNamesAsKeys();

        $question = new ChoiceQuestion(
            '<question>Please choose the Remote:</question>',
            array_keys($remotesList)
        );

        $answer = $this->helper->ask($this->input, $this->output, $question);

        return $remotesList[$answer] ?? null;
    }
}
