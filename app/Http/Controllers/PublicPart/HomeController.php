<?php

namespace App\Http\Controllers\PublicPart;

use App\Http\Controllers\Controller;
use App\Models\Base\Cities;
use App\Models\Other\Page;
use App\Traits\API\ForecastTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller{
    use ForecastTrait;
    protected string $_path = 'public-part.app.home.';

    public function home(): View{
        $popular = Cities::where('base', '=', 1)->orderBy('name')->take(6)->get();

        return view($this->_path . 'home', [
            'popularCities' => Cities::inRandomOrder()->take(5)->get(),
            'currentCity' => Cities::where('key', '=', 33028)->first(),
            'hideMenu' => true,
            'history' => $this->getUserHistory(),
            'popular' => $popular
        ]);
    }

    public function privacyPolicy(): View{
        return view('public-part.app.pages.pages.page', [
            'history' => $this->getUserHistory(),
            'page' => Page::where('id', '=', 1)->first(),
            'gap' => 0,
            'title' => 'Pravila privatnosti',
            'privacy' => true
        ]);
    }
    public function terms(): View{
        return view('public-part.app.pages.pages.page', [
            'history' => $this->getUserHistory(),
            'page' => Page::where('id', '=', 2)->first(),
            'gap' => 0,
            'title' => 'Uslovi korištenja',
            'terms' => true
        ]);
    }
    public function cookies(): View{
        return view('public-part.app.pages.pages.page', [
            'history' => $this->getUserHistory(),
            'page' => Page::where('id', '=', 3)->first(),
            'gap' => 0,
            'title' => 'Kolačići',
            'cookies' => true
        ]);
    }

    public function aboutUs(): View{
        return view('public-part.app.pages.pages.page', [
            'history' => $this->getUserHistory(),
            'page' => Page::where('id', '=', 4)->first(),
            'gap' => 0,
            'title' => 'O nama',
            'about' => true
        ]);
    }

    /**
     * Page for testing effects
     *
     * @param $type
     * @return View
     */
    public function effects($type): View{
        return view('public-part.app.pages.pages.effects', [
            'history' => $this->getUserHistory(),
            'type' => $type
        ]);
    }


    /** ------------------------------------------------------------------------------------------------------------- */
    /**
     *  Sitemaps generator
     */
    public function sitemaps(): Response{
        $sitemap = Sitemap::create();

        // Homepage
        $sitemap->add(Url::create('/')
            ->setPriority(1.0)
            ->setChangeFrequency('daily'));

        foreach (Cities::where('base', '=', '1')->get() as $city) {
            // Main City URI

            $sitemap->add(
                Url::create(route('public.forecast.preview-by-slug', ['slug' => $city->slug]))
                    ->setPriority(0.8)
                    ->setChangeFrequency('hourly')
                    ->setLastModificationDate($city->updated_at ?? Carbon::now())
            );

            // Forecast for 5 days
            for ($i = 0; $i < 5; $i++) {
                $date = Carbon::now()->addDays($i)->format('Y-m-d');

                $sitemap->add(
                    Url::create(
                        route('public.forecast.daily-by-slug', [
                            'slug' => $city->slug,
                            'date'    => $date,
                            'type'    => 'day'
                        ])
                    )
                        ->setPriority(0.7)
                        ->setChangeFrequency('daily')
                        ->setLastModificationDate(Carbon::now()->addDays($i))
                );
            }
        }

        // Static sites
        $sitemap->add(Url::create('/contact-us'));
        $sitemap->add(Url::create('/pages/about-us'));
        $sitemap->add(Url::create('/pages/privacy-policy'));
        $sitemap->add(Url::create('/pages/terms-and-conditions'));
        $sitemap->add(Url::create('/pages/cookies'));
        $sitemap->add(Url::create('/auth'));

        return $sitemap->toResponse(request());
    }
}
