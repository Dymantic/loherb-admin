<?php

namespace App\Console\Commands;

use Dymantic\MultilingualPosts\Post;
use Dymantic\SmlMediaBroker\MediaModel;
use Illuminate\Console\Command;
use Spatie\MediaLibrary\Models\Media;

class UpdateToMediaModels extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'multilingual-posts:update-media';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update to media models';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $media = Media::where('model_type', Post::class)->get();

        $media->each(function($med) {
            $mm = MediaModel::firstOrCreate(['post_id' => $med->model_id]);

            $med->model_id = $mm->id;
            $med->model_type = MediaModel::class;
            $med->save();
        });
    }
}
