<?php

namespace SCTiengen\CalendarViewBundle\Command;

use SCTiengen\CalendarViewBundle\Google\Sync\CalendarManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SyncCommand extends ContainerAwareCommand {
    
    protected function configure() {
        $this->setName('calendar:sync')->setDescription('Synchronize calendar events')
            ->addOption(
                'update-calendars',
                null,
                InputOption::VALUE_NONE,
                'If set, the calendar list is updated first'
            )
        ;
    }
    
    protected function execute(InputInterface $input, OutputInterface $output) {
        /**
         * @var $calendarSyncManager CalendarManager
         */
        $calendarSyncManager = $this->getContainer()->get('sctiengen_calendar_view.calendar_sync_manager');
        if ($input->getOption('update-calendars')) {
            $calendarSyncManager->updateCalendars();
        }
        $startDateTime = new \DateTime('today -1 day');
        $endDateTime = new \DateTime('today +1 day +1 month');
        $calendarSyncManager->syncAllCalendarEvents($startDateTime, $endDateTime);
    }
    
}
