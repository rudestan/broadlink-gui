<?php

namespace BRMControl\Command;

use BRMControl\Command\Traits\QuestionChooseRemote;
use BRMControl\Device\RMPPlus;
use BRMControl\Service\DeviceReader;
use BRMControl\Service\DeviceStorageWriter;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Question\ChoiceQuestion;

class DeleteRemoteCommand extends AbstractCommand
{
    use QuestionChooseRemote;

    protected static $defaultName = 'rmproplus:remote:delete';

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
            ->setDescription('Remove the Remote from the device')
            ->addOption('name', null, InputOption::VALUE_REQUIRED, 'Name of the Remote', null)
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);

        $remoteName = $this->input->getOption('name');

        $devices = $this->deviceReader->readDevices();

        if ($devices->count() > 1) {
            $this->output->writeln('<warn>Currently only 1 device supported!</warn>');

            return;
        }

        /** @var RMPPlus $currentDevice */
        $currentDevice = $devices->first();

        if ($currentDevice->getRemotes()->count() === 0) {
            $this->output->writeln('<noresult>No remotes stored for this device.</noresult>');

            return;
        }

        if ($remoteName === null) {
            $remote = $this->questionChooseRemote($currentDevice);
        } else {
            $remote = $currentDevice->getRemoteByName($remoteName);
        }

        if ($remote === null) {
            $this->output->writeln('<noresult>No remote was selected. Exiting.</noresult>');

            return;
        }

        $question = new ChoiceQuestion(
            '<warn>Do you really want to delete "'.$remote->getName().'" remote?</warn>',
            ['Y', 'N']
        );

        $answer = $this->helper->ask($this->input, $this->output, $question);

        if ($answer === 'N') {
            return;
        }

        $currentDevice->getRemotes()->removeElement($remote);

        if ($this->deviceWriter->saveDevice($currentDevice->getFilename(), $currentDevice)) {
            $this->output->writeln('<process>The "'.$remote->getName().'" was successfully deleted.</process>');
        }
    }
}
