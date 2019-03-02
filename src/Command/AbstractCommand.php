<?php

namespace BRMControl\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;

abstract class AbstractCommand extends Command
{
    /**
     * @var InputInterface
     */
    protected $input;

    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * @var QuestionHelper
     */
    protected $helper;

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;
        $this->helper = $this->getHelper('question');

        $this->initCustomStyles($this->output);
    }

    protected function initCustomStyles(OutputInterface $output)
    {
        $output->getFormatter()->setStyle('process', new OutputFormatterStyle('cyan'));
        $output->getFormatter()->setStyle('noresult', new OutputFormatterStyle('yellow'));
        $output->getFormatter()->setStyle('okresult', new OutputFormatterStyle('green'));
        $output->getFormatter()->setStyle('question', new OutputFormatterStyle('blue'));
        $output->getFormatter()->setStyle('highlight', new OutputFormatterStyle('white'));
        $output->getFormatter()->setStyle('warn', new OutputFormatterStyle('red'));
    }
}