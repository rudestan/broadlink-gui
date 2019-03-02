<?php

namespace BRMControl\Command;

use BRMControl\Command\Traits\SaveDeviceTrait;
use BRMControl\Device\Remote;
use BRMControl\Device\RMPPlus;
use BRMControl\Service\DeviceReader;
use BRMControl\Service\DeviceWriter;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Question\Question;

class CreateRemoteCommand extends AbstractCommand
{
    use SaveDeviceTrait;

    protected static $defaultName = 'rmproplus:remote:create';

    /**
     * @var DeviceReader
     */
    private $deviceReader;

    /**
     * @var DeviceWriter
     */
    private $deviceWriter;

    public function __construct(DeviceReader $deviceReader, DeviceWriter $deviceWriter, $name = null)
    {
        parent::__construct($name);

        $this->deviceReader = $deviceReader;
        $this->deviceWriter = $deviceWriter;
    }

    protected function configure()
    {
        $this
            ->setDescription('Creates new remote for specified device')
            ->addOption('name', null, InputOption::VALUE_REQUIRED, 'Name of the Remote')
            ->addOption('device_id', null, InputOption::VALUE_OPTIONAL, 'Device id where to add the remote')
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

        if ($remoteName === null) {
            $question = new Question('<question>Please type the name of new Remote: </question>');
            $remoteName = $this->helper->ask($this->input, $this->output, $question);
        }

        if ($currentDevice->isRemoteExist($remoteName)) {
            $this->output->writeln(sprintf('<warn>The remote with name "%s" already exists!</warn>', $commandName));

            return;
        }

        $remote = new Remote($remoteName);

        $currentDevice->addRemote($remote);

        $this->saveDevice($currentDevice, $remoteName, 'Remote');
    }
}