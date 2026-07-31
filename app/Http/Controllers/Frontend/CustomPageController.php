<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\CustomPage;
use App\Models\HomeSection;
use App\Models\News;
use App\Models\Program;
use App\Models\ProgramCategory;
use App\Models\Siteinfo;
use App\Models\University;
use Illuminate\Support\Str;

class CustomPageController extends Controller
{
    public function privacyPolicy()
    {
        return $this->legalPage('privacy-policy', 'Privacy Policy');
    }

    public function terms()
    {
        return $this->legalPage('terms-of-service', 'Terms of Service');
    }

    public function show(string $customPagePath)
    {
        $path = trim($customPagePath, '/');

        $page = CustomPage::where('status', true)
            ->where(function ($query) use ($path) {
                $query->where('desired_url', $path)->orWhere('slug', $path);
            })
            ->firstOrFail();

        if (in_array($path, ['privacy-policy', 'terms-of-service'], true)) {
            return $this->renderLegalPage($page);
        }

        return view('frontend.custom-pages.show', array_merge($this->sharedData(), [
            'page' => $page,
        ]));
    }

    private function legalPage(string $path, string $fallbackTitle)
    {
        $page = CustomPage::where('status', true)
            ->where(function ($query) use ($path) {
                $query->where('desired_url', $path)->orWhere('slug', $path);
            })
            ->firstOrFail();

        return $this->renderLegalPage($page, $fallbackTitle);
    }

    private function renderLegalPage(CustomPage $page, ?string $fallbackTitle = null)
    {
        return view('frontend.custom-pages.legal', array_merge($this->sharedData(), [
            'page' => $page,
            'fallbackTitle' => $fallbackTitle,
        ]));
    }

    private function sharedData(): array
    {
        $universities = University::where('status', true)->withCount('programs')->orderBy('priority')->latest()->take(6)->get();
        $programs = Program::with(['degree', 'university'])->where('status', true)->latest()->take(8)->get();
        $programCategories = ProgramCategory::where('status', true)->orderBy('name')->get();
        $blogPosts = BlogPost::with('category')->where('is_published', true)->latest('published_at')->take(2)->get();
        $newsItems = News::where('status', true)->latest('published_at')->take(2)->get();
        $popularPrograms = $programs->where('recommend', true);
        $subscribeSection = HomeSection::where('key', 'subscribe')->where('status', true)->first();

        if ($popularPrograms->isEmpty()) {
            $popularPrograms = $programs->take(3);
        }

        return [
            'siteinfo' => Siteinfo::latest()->first(),
            'universities' => $universities,
            'programs' => $programs,
            'popularPrograms' => $popularPrograms,
            'programCategories' => $programCategories,
            'blogPosts' => $blogPosts,
            'newsItems' => $newsItems,
            'subscribeSection' => $subscribeSection,
            'frontendData' => [
                'universities' => $universities->map(fn (University $university) => [
                    'id' => $university->slug,
                    'name' => $university->name,
                    'shortName' => Str::limit($university->name, 18, ''),
                    'location' => $university->location,
                ])->values(),
                'programs' => $programs->map(fn (Program $program) => [
                    'id' => $program->slug,
                    'name' => $program->program,
                    'universityId' => $program->university?->slug,
                    'degreeType' => $program->degree?->name ?? $program->type,
                    'price' => $program->total_fee ?: 'Contact',
                ])->values(),
            ],
        ];
    }
}
