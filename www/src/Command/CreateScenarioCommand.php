<?php

namespace BRMControl\Command;

use BRMControl\Command\Traits\QuestionChooseCommand;
use BRMControl\Command\Traits\QuestionChooseRemote;
use BRMControl\Command\Traits\SaveDeviceTrait;
use BRMControl\Device\RMPPlus;
use BRMControl\Device\Scenario;
use BRMControl\Device\ScenarioItem;
use BRMControl\Service\DeviceReader;
use BRMControl\Service\DeviceStorageWriter;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

class CreateScenarioCommand extends AbstractCommand
{
    use QuestionChooseRemote;
    use QuestionChooseCommand;
    use SaveDeviceTrait;

    protected static $defaultName = 'rmproplus:scenario:create';

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
            ->setDescription('Create new Scenario using predefined Commands from the exiting Remotes')
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

        if ($currentDevice->getRemotes()->count() === 0) {
            $this->output->writeln('<noresult>No remotes stored for this device.</noresult>');

            return;
        }

        if ($scenarioName === null) {
            $question = new Question('<question>Please type the name of new Scenario: </question>');
            $scenarioName = $this->helper->ask($this->input, $this->output, $question);
        }

        if ($currentDevice->isScenarioExist($scenarioName)) {
            $question = new ChoiceQuestion(
                '<question>The scenario with name "'.$scenarioName.'" is already exist, overwrite it?</question>',
                ['Y' => 'Yes', 'N' => 'No']
            );

            $answer = $this->helper->ask($this->input, $this->output, $question);

            if ($answer === 'N') {
                return;
            }
        }

        $scenario = new Scenario($scenarioName);

        $this->addScenarioItemStep($currentDevice, $scenario);

        $this->saveDevice($currentDevice, $scenario->getName(), 'Scenario');
    }

    private function addScenarioItemStep(RMPPlus $device, Scenario $scenario)
    {
        $remote = $this->questionChooseRemote($device);

        if ($remote === null) {
            $this->output->writeln('<warn>No remote was selected!</warn>');

            return;
        }

        $command = $this->questionChooseCommand($device, $remote);

        if ($command === null) {
            $this->output->writeln('<warn>No command was selected!</warn>');

            return;
        }

        $question = new Question(
            '<question>Please type delay after executing the command <highlight>[default - 0]</highlight>: </question>', 0
        );

        $delay = (float) $this->helper->ask($this->input, $this->output, $question);

        $scenarioItem = new ScenarioItem($command);
        $scenarioItem->setDelay($delay);

        $scenario->addScenarioItem($scenarioItem);

        $device->addScenario($scenario);

        $nextStep = $scenario->getItems()->count() + 1;
        $question = new ChoiceQuestion(
            '<question>Add new step #'.(string) $nextStep.' to current Scenario?</question>',
            ['Y' => 'Yes', 'N' => 'No']
        );

        $answer = $this->helper->ask($this->input, $this->output, $question);

        if ($answer === 'Y') {
            $this->addScenarioItemStep($device, $scenario);
        }
    }
}
