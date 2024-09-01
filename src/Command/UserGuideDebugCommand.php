<?php

namespace Norvutec\UserGuideBundle\Command;

use Norvutec\UserGuideBundle\Component\Builder\ListUserGuideBuilder;
use Norvutec\UserGuideBundle\Component\UserGuideRegistry;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

#[AsCommand(
    name: 'userguide:debug',
    description: 'Debug a user guide and prints the guide json to console.'
)]
final class UserGuideDebugCommand extends Command {

    public function __construct(
        private readonly UserGuideRegistry      $registry,
        private readonly SerializerInterface    $serializer
    )
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->addArgument("guide", InputArgument::REQUIRED, "The ID of the user guide to debug.");
    }


    protected function execute(InputInterface $input, OutputInterface $output): int {
        $guideId = $input->getArgument("guide");
        $guide = $this->registry->getUserGuideById($guideId);
        if($guide == null) {
            $output->writeln("<error>User guide with ID $guideId not found</error>");
            return Command::FAILURE;
        }
        $builder = new ListUserGuideBuilder();
        $guide->configure($builder);
        $json = $this->serializer->serialize($builder, 'json', ['json_encode_options' => JSON_PRETTY_PRINT]);
        $output->writeln("User guide details for $guideId:");
        $output->writeln($json);
        return Command::SUCCESS;
    }


}