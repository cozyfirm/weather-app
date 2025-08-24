<?php

namespace App\Console\Commands\Fixes;

use App\Models\Base\Cities;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateCitySlugs extends Command{
    protected $signature = 'fixes:generate-slugs';
    protected $description = 'Generate unique slugs for all cities in the database';

    public function handle(): int{
        $cities = Cities::all();
        foreach ($cities as $city) {
            $cityName = $city->name_eng ?: $city->name;   // Check first eng then bosnian

            // Base slug
            $baseSlug = Str::slug($cityName);

            $slug = $baseSlug;
            $counter = 1;

            // Check if slug exists
            while (Cities::where('slug', '=', $slug)->where('id', '!=', $city->id)->exists()) {
                // If duplicate exists, add key or counter
                $slug = $baseSlug . '-' . ($city->key ?? $counter);
                $counter++;
            }

            $city->slug = $slug;
            $city->save();

            echo "Generated slug for {$city->name}: {$slug}\n";
        }

        return 0;
    }
}
