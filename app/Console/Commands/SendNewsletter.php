<?php

namespace App\Console\Commands;

use App\Moldova\Service\Newsletter;
use Illuminate\Console\Command;

class SendNewsletter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'newsletter:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Newsletter to subscribers.';

    /**
     * @var Newsletter
     */
    private $newsletter;

    /**
     * Create a new command instance.
     * @param Newsletter $newsletter
     * @internal param MailChimp $mailChimp
     */
    public function __construct(Newsletter $newsletter)
    {
        parent::__construct();
        $this->newsletter = $newsletter;
    }

    /**
     * Execute the console command.
     * @return mixed
     */
    public function handle()
    {
        $title = date('l jS \of F Y h:i:s A');
        $this->newsletter->createAndSendCampaign($title,"Moldova Newsletter");
    }
}
