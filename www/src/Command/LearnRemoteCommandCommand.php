<?php

namespace BRMControl\Command;

use BRMControl\Command\Traits\QuestionChooseRemote;
use BRMControl\Command\Traits\SaveDeviceTrait;
use BRMControl\Device\Command;
use BRMControl\Device\Remote;
use BRMControl\Device\RMPPlus;
use BRMControl\Exception\DeviceAuthorizationException;
use BRMControl\Service\DeviceApiClient;
use BRMControl\Service\DeviceStorageReader;
use BRMControl\Service\DeviceStorageWriter;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

class LearnRemoteCommandCommand extends AbstractCommand
{
    use QuestionChooseRemote;
    use SaveDeviceTrait;

    /**
     * Interval between retries in seconds
     */
    private const RETRY_DELAY = 1;

    protected static $defaultName = 'rmproplus:command:learn';

    /**
     * @var DeviceApiClient
     */
    private $deviceApiClient;

    /**
     * @var DeviceStorageReader
     */
    private $deviceReader;

    /**
     * @var DeviceStorageWriter
     */
    private $deviceWriter;

    public function __construct(
        DeviceApiClient $deviceApiClient,
        DeviceStorageReader $deviceReader,
        DeviceStorageWriter $deviceWriter,
        $name = null
    ) {
        parent::__construct($name);

        $this->deviceApiClient = $deviceApiClient;
        $this->deviceReader = $deviceReader;
        $this->deviceWriter = $deviceWriter;
    }

    protected function configure()
    {
        $this
            ->setDescription('Sets the Remote device to Learn mode and captures the Command.')
            ->addOption('name', null, InputOption::VALUE_REQUIRED, 'Name of the Command', null)
            ->addOption('remote_id', null, InputOption::VALUE_OPTIONAL, 'Remote id where to add the command')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);

        $name = $this->input->getOption('name');
        $devices = $this->deviceReader->readDevices();

        if ($devices->count() > 1) {
            $this->output->writeln('<warn>Currently only 1 device supported!</warn>');

            return;
        }

        /** @var RMPPlus $currentDevice */
        $currentDevice = $devices->first();
        $currentRemote = null;

        if ($currentDevice->getRemotes()->count() == 1) {
            $currentRemote = $currentDevice->getRemotes()->first();
        } else {
            $currentRemote = $this->questionChooseRemote($currentDevice);

            if ($currentRemote === null) {
                $this->output->writeln('<warn>Unknown Remote was chosen! Exiting.</warn>');
            }
        }

        $this->addNewCommandFullStep($currentDevice, $currentRemote, $name);
    }

    private function addNewCommandFullStep(RMPPlus $device, Remote $remote, ?string $name = null)
    {
        $commandName = $name;

        if ($commandName === null) {
            $question = new Question('<question>Please type the name of new command: </question>');
            $commandName = $this->helper->ask($this->input, $this->output, $question);
        }

        if($remote->isCommandExist($commandName) == true) {
            $question = new ChoiceQuestion(
                '<question>The command "'.$commandName.'" is already exist, overwrite it?</question>',
                ['Y' => 'Yes', 'N' => 'No']
            );

            $answer = $this->helper->ask($this->input, $this->output, $question);

            if ($answer === 'N') {
                $this->addNewCommandFullStep($device, $remote);
            }
        }

        $learnedCommandCode = $this->listenDevice($device);

        if ($learnedCommandCode === null) {
            return;
        }

        $command = new Command($commandName, $learnedCommandCode);
        $remote->addCommand($command);

        $this->saveDevice($device, $commandName, 'Command');

        $question = new ChoiceQuestion(
            '<question>Would you like to learn another command for "'.$remote->getName().'" remote?</question>',
            ['Y' => 'Yes', 'N' => 'No']
        );

        $answer = $this->helper->ask($this->input, $this->output, $question);

        if ($answer === 'Y') {
            $this->addNewCommandFullStep($device, $remote);
        } else {
            return;
        }
    }

    private function listenDevice(RMPPlus $device)
    {
        $learnedCommand = null;

        $this->learningMode($device);
        $learnedCommand = $this->listeningMode($device);

        return $learnedCommand;
    }

    private function learningMode(RMPPlus $device) {
        while(true) {
            $this->deviceApiClient->startLearning($device);
            $answer = $this->questionLight();

            if ($answer === 'Q') {
                return null;
            } elseif ($answer === 'Y') {
                break;
            }
        }
    }

    private function listeningMode(RMPPlus $device)
    {
        while (true) {
            try {
                $learnedCommand = $this->deviceApiClient->getLastLearnedCommand();
            } catch (DeviceAuthorizationException $e) {
                $this->output->writeln('<warn>' . $e->getMessage(). '</warn>');

                return null;
            }

            if ($learnedCommand !== null) {
                return $learnedCommand;
            }

            $this->output->writeln(
                '<process>No command received yet. Retrying in '.self::RETRY_DELAY.' second(s). Press CTRL+C to stop the quit.</process>'
            );

            sleep(self::RETRY_DELAY);
        }

        return null;
    }

    private function questionLight(): string
    {
        $question = new ChoiceQuestion(
            '<question>Learning mode started. Has the yellow light turned-on on the device?</question>',
            ['Y' => 'Yes', 'N' => 'No', 'Q' => 'Exit']
        );

        return $this->helper->ask($this->input, $this->output, $question);
    }
}
