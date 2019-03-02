<?php

namespace BRMControl\Command;

use BRMControl\Command\Traits\QuestionChooseRemote;
use BRMControl\Device\Command;
use BRMControl\Device\Remote;
use BRMControl\Service\DeviceApiClient;
use BRMControl\Service\DeviceReader;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use BRMControl\Device\RMPPlus;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Input\ArrayInput;

class RemoteControlCommand extends AbstractCommand
{
    use QuestionChooseRemote;

    protected static $defaultName = 'rmproplus:remotecontroll';

    /**
     * @var DeviceApiClient
     */
    protected $deviceApiClient;

    /**
     * @var DeviceReader
     */
    protected $deviceReader;

    public function __construct(DeviceApiClient $deviceApiClient, DeviceReader $deviceReader, $name = null)
    {
        $this->deviceApiClient = $deviceApiClient;
        $this->deviceReader = $deviceReader;

        parent::__construct($name);
    }

    protected function configure()
    {
        $this
            ->setDescription('Remote control functionality, based on the codes stored in the configuration.')
            ->addOption('remote_name', null, InputOption::VALUE_OPTIONAL, 'Name of the remote control to use')
            ->addOption('command_name', null, InputOption::VALUE_OPTIONAL, 'The name of the command to send')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);

        $remoteName = $this->input->getOption('remote_name');

        $devices = $this->deviceReader->readDevices();

        if ($devices->count() > 1) {
            $this->output->writeln('<warn>Currently only 1 device supported!</warn>');

            return;
        }

        /** @var RMPPlus $currentDevice */
        $currentDevice = $devices->first();
        $currentRemote = null;

        if ($currentDevice->getRemotes()->count() === 0) {
            $this->output->writeln('<warn>No remotes for this device configured.</warn>');

            return;
        }

        if ($currentDevice->getRemotes()->count() == 1) {
            $currentRemote = $currentDevice->getRemotes()->first();
        } elseif ($remoteName === null) {
            $currentRemote = $this->questionChooseRemote($currentDevice);

            if ($currentRemote === null) {
                $this->output->writeln('<warn>Unknown Remote was chosen! Exiting.</warn>');
            }
        } else {
            $currentRemote = $currentDevice->getRemoteByName($remoteName);

            if ($currentRemote === null) {
                $this->output->writeln('<noresult>The Remote with given name was not found!</noresult>');

                $currentRemote = $this->questionChooseRemote($currentDevice);
            }
        }

        while(true) {
            $chosenCommand = $this->questionChooseCommand($currentDevice, $currentRemote);

            if ($chosenCommand === null) {
                return;
            }

            $this->sendCommand($currentDevice, $chosenCommand);
        }
    }

    private function sendCommand(RMPPlus $device, Command $command)
    {
        $this->deviceApiClient->sendCommand($device, $command);
    }

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
