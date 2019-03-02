<?php

namespace BRMControl\Command;

use BRMControl\Device\RMPPlus;
use BRMControl\Exception\FileExistsException;
use BRMControl\Factory\RMPPlusFactory;
use BRMControl\Service\DeviceWriter;
use BroadlinkApi\Device\Authenticatable\RMDevice;
use BroadlinkApi\Device\NetDevice;
use BroadlinkApi\Exception\BroadlinkApiException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

class AddDeviceCommand extends AbstractCommand
{
    protected static $defaultName = 'rmproplus:device:add';

    /**
     * @var RMPPlusFactory
     */
    private $rmpPlusFactory;

    /**
     * @var DeviceWriter
     */
    private $deviceWriter;

    public function __construct(RMPPlusFactory $rmpPlusFactory, DeviceWriter $deviceWriter, $name = null)
    {
        parent::__construct($name);

        $this->rmpPlusFactory = $rmpPlusFactory;
        $this->deviceWriter = $deviceWriter;
    }

    protected function configure()
    {
        $this
            ->setDescription('Adds a new Broadlink device, discovered within current network')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);

        $this->output->writeln('<process>Discovering Broadlink RM Pro + Devices...</process>');

        $discovered = $this->discoverDevices();

        if (count($discovered) > 0) {
            $added = 0;

            /** @var RMPPlus $device */
            foreach ($discovered as $device) {
                try {
                    $written = $this->deviceWriter->saveNewDevice($device);

                    if ($written) {
                        $added++;
                    }
                } catch (FileExistsException $e) {
                    $this->output->writeln(
                        sprintf(
                            '<noresult>Device "%s (id: %s)" already exists in "device" folder, skipping.</noresult>',
                            $device->getName(),
                            $device->getId()
                        )
                    );
                }
            }

            $this->output->writeln(
                sprintf("<okresult>%s device(s) were added.</okresult>", $added)
            );
        } else {
            $this->output->writeln("<noresult>0 devices were added.</noresult>");
        }
    }

    private function discoverDevices(): array
    {
        $netDevice = NetDevice::create();

        while (true) {
            try {
                $discovered = $netDevice->discover();
            } catch (BroadlinkApiException $e) {
                $this->output->writeln(
                    sprintf("<warn>Error discovering devices: %s</warn>", $e->getMessage())
                );

                return [];
            }

            if (empty($discovered)) {
                $this->output->writeln("<noresult>0 devices were found. Retrying in 2 seconds. (Press CTRL+C to stop)</noresult>");

                sleep(2);
            } else {
                $RmpDevices = [];

                foreach ($discovered as $device) {
                    if ($device instanceof RMDevice) {
                        try {
                            $device->authenticate();

                            if ($this->questionAdd($device) === 'Y') {
                                $rmpDevice = $this->rmpPlusFactory->create($device);
                                $rmpDevice->setName($this->questionName($device));

                                $RmpDevices[] = $rmpDevice;
                            }
                        } catch (\Exception $e) {
                            $this->output->writeln("<noresult>Failed to add the device, because Authorization was not successful!</noresult>");
                        }
                    }
                }

                return $RmpDevices;
            }
        }

        return [];
    }

    private function questionAdd(RMDevice $device): string
    {
        $question = new ChoiceQuestion(
            sprintf(
                '<question>Found: <highlight>"%s"</highlight> (ip: <highlight>%s</highlight>, mac: <highlight>%s</highlight>). Do you wish to add?</question>',
                $device->getName(),
                $device->getIP(),
                $device->getMac()
            ),
            ['Y', 'N']
        );

        return $this->helper->ask($this->input, $this->output, $question);
    }

    private function questionName(RMDevice $device): string
    {
        $question = new Question('<question>Type the name of your RM Pro+ Device: </question>', $device->getName());

        return $this->helper->ask($this->input, $this->output, $question);
    }
}
