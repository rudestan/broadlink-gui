<?php

namespace BRMControl\Command;

use BRMControl\Command\Traits\QuestionChooseCommand;
use BRMControl\Command\Traits\QuestionChooseRemote;
use BRMControl\Command\Traits\QuestionChooseScenario;
use BRMControl\Command\Traits\SaveDeviceTrait;
use BRMControl\Device\RMPPlus;
use BRMControl\Device\Scenario;
use BRMControl\Device\ScenarioItem;
use BRMControl\Service\DeviceReader;
use BRMControl\Service\ScenarioPlayer;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

class PlayScenarioCommand extends AbstractCommand
{
    use SaveDeviceTrait;
    use QuestionChooseScenario;

    protected static $defaultName = 'rmproplus:scenario:play';

    /**
     * @var DeviceReader
     */
    protected $deviceReader;

    /**
     * @var ScenarioPlayer
     */
    protected $scenarioPlayer;

    public function __construct(DeviceReader $deviceReader, ScenarioPlayer $scenarioPlayer, $name = null)
    {
        parent::__construct($name);

        $this->deviceReader = $deviceReader;
        $this->scenarioPlayer = $scenarioPlayer;
    }

    protected function configure()
    {
        $this
            ->setDescription('Play existing for chosen Remote')
            ->addOption('name', null, InputOption::VALUE_REQUIRED, 'Name of the Scenario', null)
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);

        $scenarioName = $this->input->getOption('name');

        $devices = $this->deviceReader->readDevices();

        if ($devices->count() > 1) {
            $this->output->writeln('<warn>Currently only 1 device supported!</warn>');

            return;
        }

        /** @var RMPPlus $currentDevice */
        $currentDevice = $devices->first();

        if ($currentDevice->getScenarios()->count() === 0) {
            $this->output->writeln('<noresult>No scenarios stored for this device.</noresult>');

            return;
        }

        if ($scenarioName === null) {
            $scenario = $this->questionChooseScenario($currentDevice);
        } elseif(!$currentDevice->isScenarioExist($scenarioName)) {
            $this->output->writeln('<warn>Scenario with given name "' . $scenarioName . '" does not exist!</warn>');

            return;
        } else {
            $scenario = $currentDevice->getScenarioByName($scenarioName);
        }

        if ($scenario === null) {
            $this->output->writeln('<warn>Scenario does not exist!</warn>');

            return;
        }

        $this->playScenario($currentDevice, $scenario);
    }

    private function playScenario(RMPPlus $device, Scenario $scenario)
    {
        $scenarioItems = $scenario->getItems();

        if ($scenarioItems->count() === 0) {
            $this->output->writeln('<warn>No Scenario items found!</warn>');

            return;
        }

        $step = 0;

        /** @var ScenarioItem $scenarioItem */
        foreach ($scenarioItems as $scenarioItem) {
            $step++;
            $remote = $device->getRemoteByCommandId($scenarioItem->getCommandId());

            $this->output->write(
                sprintf(
                    '%d) <process>%s</process> ... ',
                    $step,
                    $remote->getName()
                )
            );

            $command = $this->scenarioPlayer->playScenarioItem($device, $scenarioItem);

            $this->output->writeln(
                sprintf(
                    '<process>-> %s</process>',
                    $command->getName()
                )
            );
        }
    }
}
