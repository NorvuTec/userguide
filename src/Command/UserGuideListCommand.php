<?php

namespace Norvutec\UserGuideBundle\Command;

use Norvutec\UserGuideBundle\Component\Builder\ListUserGuideBuilder;
use Norvutec\UserGuideBundle\Component\UserGuideRegistry;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'userguide:list',
    description: 'List all user guides'
)]
final class UserGuideListCommand extends Command {

    public function __construct(
        private readonly UserGuideRegistry $registry
    ) {
        parent::__construct();
    }

    /**
     * @inheritDoc
     */
    protected function execute(InputInterface $input, OutputInterface $output): int {
        $output->writeln("  ");
        $output->writeln("  ");

        $userGuides = $this->registry->all();
        if(count($userGuides) == 0) {
            $output->writeln("<error>No user guides found</error>");
            $output->writeln("  ");
            $output->writeln("  ");
            return Command::SUCCESS;
        }

        $table = new Table($output);
        $table->setHeaders(["ID", "Name", "Class", "Steps", "Route", "Alternate Routes"]);

        foreach($userGuides as $userGuide) {
            $builder = new ListUserGuideBuilder();
            $userGuide->configure($builder);
            $table->addRow([$userGuide->id(), $userGuide->name(), get_class($userGuide), $builder->stepsCount(), ($builder->getRoute() ?: "--"), $builder->alternateRouteCount()]);
        }

        $output->writeln("Found " . count($userGuides) . " user guides:");
        $output->writeln("  ");
        $table->render();
        $output->writeln("  ");
        $output->writeln("  ");
        return Command::SUCCESS;
    }


}