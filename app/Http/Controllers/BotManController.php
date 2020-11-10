<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Conversations\SearchConversation;
use BotMan\BotMan\BotMan;
use App\Conversations\ExampleConversation;

class BotManController extends Controller
{
    /**
     * Place your BotMan logic here.
     */
    public function handle()
    {
        $botman = app('botman');

        $botman->listen();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tinker()
    {
        return view('tinker');
    }

    /**
     * Loaded through routes/botman.php
     * @param  BotMan $bot
     */
    public function startConversation(BotMan $bot)
    {
        $bot->startConversation(new ExampleConversation());
    }

    public function search(BotMan $bot)
    {
        $bot->startConversation(app()->make(SearchConversation::class));
    }
}
