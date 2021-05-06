<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\Ocr\Parser\ParserInterface;
use App\Service\Ocr\Reader\ReaderInterface;
use App\Service\Ocr\Writer\Factory\WriterFactoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class OcrRunCommand extends Command
{
    public const COMMAND_NAME = 'app:ocr:run';
    public const ARGUMENT_INPUT_FILE_PATH = 'input-file-path';
    public const OPTION_OUTPUT_FILE_PATH = 'output-file-path';
    public const OPTION_WRITER_FORMATTER = 'formatter';

    private ReaderInterface $reader;
    private WriterFactoryInterface $writerFactory;
    private ParserInterface $parser;
    private array $formatters;

    public function __construct(
        ReaderInterface $reader,
        ParserInterface $parser,
        WriterFactoryInterface $writerFactory,
        array $formatters
    ) {
        parent::__construct();

        $this->reader = $reader;
        $this->parser = $parser;
        $this->writerFactory = $writerFactory;
        $this->formatters = $formatters;
    }

    protected function configure(): void
    {
        $this
            ->setName(self::COMMAND_NAME)
            ->addArgument(self::ARGUMENT_INPUT_FILE_PATH, InputArgument::REQUIRED, 'Path to input file')
            ->addOption(self::OPTION_OUTPUT_FILE_PATH, 'o', InputOption::VALUE_OPTIONAL, 'Path to output file')
            ->addOption(self::OPTION_WRITER_FORMATTER, 'f', InputOption::VALUE_OPTIONAL, 'Formatter to use')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $inputFilePath = $input->getArgument(self::ARGUMENT_INPUT_FILE_PATH);

        $formatterName = $input->getOption(self::OPTION_WRITER_FORMATTER);
        if (!$formatterName) {
            $formatterName = $io->choice('Which formatter to use?', array_keys($this->formatters));
        }
        $formatter = $this->formatters[$formatterName] ?? null;
        if (!$formatter) {
            $io->error(sprintf('Formatter "%s" not found', $formatterName));

            return Command::FAILURE;
        }

        $outputFilePath = $input->getOption(self::OPTION_OUTPUT_FILE_PATH);
        if ($outputFilePath) {
            $writer = $this->writerFactory->create($outputFilePath, $formatter);
        } else {
            $writer = $this->writerFactory->createFromInputFile($inputFilePath, $formatter);
        }

        foreach ($this->reader->readNumber($inputFilePath) as $numberAsString) {
            $accountNumber = $this->parser->parse($numberAsString);
            $writer->write($accountNumber);
        }

        return Command::SUCCESS;
    }
}
