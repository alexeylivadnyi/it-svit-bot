<?php
declare(strict_types=1);

namespace App\Conversations;

use App\Models\Article;
use App\Models\Category;
use App\Repositories\Article\ArticleRepository;
use App\Repositories\Article\Filters\ByCategory;
use App\Repositories\Article\Filters\ByDate;
use App\Repositories\Article\Filters\ByDescription;
use App\Repositories\Article\Filters\ByLink;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use Carbon\Carbon;

class SearchConversation extends Conversation
{
    protected ArticleRepository $repository;

    /**
     * SearchConversation constructor.
     * @param ArticleRepository $repository
     */
    public function __construct(ArticleRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        $this->choice();
    }

    private function choice()
    {
        $question = Question::create('Выберите критерии поиска:')
            ->addButtons(
                [
                    Button::create('Название')->value(Article::FILTER_BY_LINK),
                    Button::create('Дата')->value(Article::FILTER_BY_DATE),
                    Button::create('Категория')->value(Article::FILTER_BY_CATEGORY),
                    Button::create('Описание')->value(Article::FILTER_BY_DESCRIPTION),
                ]
            );


        return $this->ask(
            $question,
            function (Answer $answer) {
                if ($answer->isInteractiveMessageReply()) {
                    $userChoice = $answer->getValue();
                    $this->say($userChoice);
                    if ($userChoice === Article::FILTER_BY_LINK) {
                        $this->askLink();
                    }
                    if ($userChoice === Article::FILTER_BY_DATE) {
                        $this->askDate();
                    }
                    if ($userChoice === Article::FILTER_BY_CATEGORY) {
                        $this->askCategory();
                    }
                    if ($userChoice === Article::FILTER_BY_DESCRIPTION) {
                        $this->askDescription();
                    }
                }
            }
        );
    }

    private function askLink()
    {
        $this->ask(
            'Введите название для поиска',
            function (Answer $answer) {
                $this->repository->pushFilter(new ByLink($answer->getText()));

                $this->sendAnswer();
            }
        );
    }

    private function askDate()
    {
        $this->ask(
            'Введите дату в формате ДД-ММ-ГГГГ',
            function (Answer $answer) {
                $date = Carbon::createFromFormat('d-m-Y', $answer->getText());
                $this->repository->pushFilter(new ByDate($date));

                $this->sendAnswer();
            }
        );
    }

    private function askCategory()
    {
        $question = $this->makeCategoriesQuestion();

        $this->ask($question, function (Answer $answer) {
            $this->repository->pushFilter(new ByCategory((int)$answer->getValue()));

            $this->sendAnswer();
        });
    }

    private function askDescription()
    {
        $this->ask(
            'Введите текст для поиска',
            function (Answer $answer) {
                $this->repository->pushFilter(new ByDescription($answer->getText()));

                $this->sendAnswer();
            }
        );
    }

    private function sendAnswer()
    {
        $this->repository->get()->each(
            function (Article $article) {
                $this->say($article->link);
            }
        );
    }

    private function makeCategoriesQuestion(): Question
    {
        $categories = Category::all(['id', 'title']);
        return Question::create('Выберите категорию')
            ->addButtons(
                $categories->map(
                    function (Category $category) {
                        return Button::create($category->title)->value($category->id);
                    }
                )->all()
            );
    }

}
