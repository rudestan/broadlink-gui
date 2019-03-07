<?php

namespace BRMControl\Command;

use BRMControl\Command\Traits\QuestionChooseCommand;
use BRMControl\Command\Traits\QuestionChooseRemote;
use BRMControl\Device\RMPPlus;
use BRMControl\Service\DeviceReader;
use BRMControl\Service\DeviceStorageWriter;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Question\ChoiceQuestion;

class DeleteCommandCommand extends AbstractCommand
{
    use QuestionChooseRemote;
    use QuestionChooseCommand;

    protected static $defaultName = 'rmproplus:command:delete';

    /**
     * @var DeviceReader
     */
    protected $deviceReader;

    /**
     * @var DeviceStorageWriter
     */
    protected $deviceWriter;

    public function __construct(DeviceReader $deviceReader, DeviceStorageWriter $deviceWriter, $name = null)
    {
        parent::__construct($name);

        $this->deviceReader = $deviceReader;
        $this->deviceWriter = $deviceWriter;
    }

    protected function configure()
    {
        $this
            ->setDescription('Remove the Command from the desired remote')
            ->addOption('name', null, InputOption::VALUE_REQUIRED, 'Name of the Command', null)
            ->addOption('remote_name', null, InputOption::VALUE_OPTIONAL, 'Remote name where the command belongs to')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);

        $commandName = $this->input->getOption('name');
        $remoteName = $this->input->getOption('remote_name');

        $devices = $this->deviceReader->readDevices();

        if ($devices->count() > 1) {
            $this->output->writeln('<warn>Currently only 1 device supported!</warn>');

            return;
        }

        /** @var RMPPlus $currentDevice */
        $currentDevice = $devices->first();

        if ($remoteName === null) {
            $remote = $this->questionChooseRemote($currentDevice);
        } else {
            $remote = $currentDevice->getRemoteByName($remoteName);
        }

        if ($remote === null) {
            $this->output->writeln('<noresult>No remote was selected. Exiting.</noresult>');

            return;
        }

        if ($commandName === null) {
            $command = $this->questionChooseCommand($currentDevice, $remote);
        } else {
            $command = $remote->getCommandByName($commandName);
        }

        if ($command === null) {
            return;
        }

        $question = new ChoiceQuestion(
            '<warn>Do you really want to delete "'.$command->getName().'" command?</warn>',
            ['Y', 'N']
        );

        $answer = $this->helper->ask($this->input, $this->output, $question);

        if ($answer === 'N') {
            return;
        }

        $remote->getCommands()->removeElement($command);

        if ($this->deviceWriter->saveDevice($currentDevice->getFilename(), $currentDevice)) {
            $this->output->writeln('<process>The "'.$command->getName().'" was successfully deleted.</process>');
        }
    }
}
