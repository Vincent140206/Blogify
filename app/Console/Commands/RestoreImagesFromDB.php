<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Article;
use Illuminate\Support\Facades\Storage;

class RestoreImagesFromDb extends Command
{
    protected $signature = 'images:restore-from-db';
    protected $description = 'Restore images from database to storage folder';

    public function handle()
    {
        $articles = Article::whereNotNull('thumbnail')->get();

        if ($articles->isEmpty()) {
            $this->info('No articles with thumbnails found.');
            return 0;
        }

        foreach ($articles as $article) {
    
            $originalImagePath = public_path('path/to/backup/' . $article->thumbnail); 

            if (file_exists($originalImagePath)) {

                $destinationPath = 'thumbnails/' . basename($article->thumbnail);

                Storage::disk('public')->put($destinationPath, file_get_contents($originalImagePath));

                $article->thumbnail = $destinationPath;
                $article->save();

                $this->info("Restored image for article ID: {$article->id}");
            } else {
                $this->error("Image not found for article ID: {$article->id}");
            }
        }

        $this->info('Image restoration completed.');

        return 0;
    }
}
