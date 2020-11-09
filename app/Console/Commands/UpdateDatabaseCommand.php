<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\Category;
use App\Service\DataProvider;
use Illuminate\Console\Command;

class UpdateDatabaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update data about articles';

    protected $provider;

    /**
     * Create a new command instance.
     *
     * @param DataProvider $provider
     */
    public function __construct(DataProvider $provider)
    {
        parent::__construct();
        $this->provider = $provider;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /**
         * 1. Получить данные
         * 2. Получить какие-то идентификаторы тех данных, что есть на текущий момент в базе, предположительно поле link
         * 3. При наличии записи с существующим идентификатором обновлять данные в базе
         * 4. При отсутствии записи в базе - добавлять её
         * 5. При наличии в базе записей, которых нет в файле - удалять их
         */

        $categories = Category::pluck('id', 'title')->all();
        $categoryTitles = array_keys($categories);

        foreach ($this->provider->provide() as $index => $value) {
//            dump($categories);
            if (!$value) {
                continue;
            }
//            if ($index === 8743) {
//                dd($categoryTitles, $value);
//            }
            if (!in_array($value['category'], $categoryTitles)) {
                $category = Category::create(['title' => $value['category']]);
                $categories[$category->title] = $category->id;
                $categoryTitles[] = $category->title;
                $value['category_id'] = $category->id;

//                if ($index === 8743) {
//                    dd($categoryTitles, $value, in_array($value['category'], $categoryTitles));
//                }
            } else {
                $value['category_id'] = $categories[$value['category']];
            }

            $value['issue_number'] = $value['issueNumber'];
            $value['issue_url'] = $value['issueUrl'];

            Article::create($value);
            $this->info($index);
//            dd($value);
        }
    }
}
