<?php
declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\Category;
use App\Service\DataProvider\DataProvider;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

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
        $categories = Category::pluck('id', 'title')->all();
        $categoryTitles = array_keys($categories);

        DB::beginTransaction();

        foreach ($this->provider->provide() as $index => $value) {
            if (!$value) {
                continue;
            }

            if (!in_array($value['category'], $categoryTitles)) {
                $category = Category::create(['title' => $value['category']]);
                $categories[$category->title] = $category->id;
                $categoryTitles[] = $category->title;
                $value['category_id'] = $category->id;
            } else {
                $value['category_id'] = $categories[$value['category']];
            }

            $value['issue_number'] = $value['issueNumber'];
            $value['issue_url'] = $value['issueUrl'];

            Article::updateOrCreate(
                [
                    'link' => $value['link']
                ],
                $value
            );
        }

        DB::commit();
    }
}
