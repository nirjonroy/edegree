<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\HomePartner;
use App\Models\HomeSection;
use App\Models\HomeTestimonial;
use App\Models\News;
use App\Models\Program;
use App\Models\ProgramCategory;
use App\Models\Siteinfo;
use App\Models\Slider;
use App\Models\University;
use App\Support\FrontendMedia;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index()
    {
        $siteinfo = Siteinfo::latest()->first();
        $slider = Slider::where('status', true)->orderBy('sort_order')->latest()->first();
        $universities = University::where('status', true)
            ->withCount('programs')
            ->orderBy('priority')
            ->latest()
            ->take(6)
            ->get();
        $programs = Program::with(['degree', 'university'])
            ->where('status', true)
            ->latest()
            ->take(6)
            ->get();
        $popularPrograms = Program::with(['degree', 'university'])
            ->where('status', true)
            ->where('recommend', true)
            ->latest()
            ->take(3)
            ->get();

        if ($popularPrograms->isEmpty()) {
            $popularPrograms = $programs->take(3);
        }

        $blogPosts = BlogPost::with('category')
            ->where('is_published', true)
            ->where('show_on_home', true)
            ->latest('published_at')
            ->take(2)
            ->get();

        if ($blogPosts->isEmpty()) {
            $blogPosts = BlogPost::with('category')->where('is_published', true)->latest('published_at')->take(2)->get();
        }

        $newsItems = News::where('status', true)->latest('published_at')->take(2)->get();
        $programCategories = ProgramCategory::where('status', true)->orderBy('name')->get();
        $homeSections = HomeSection::where('status', true)
            ->whereIn('key', ['testimonials', 'partners', 'subscribe'])
            ->get()
            ->keyBy('key');
        $homeTestimonials = HomeTestimonial::where('status', true)
            ->orderBy('display_order')
            ->latest()
            ->get();
        $homePartners = HomePartner::where('status', true)
            ->orderBy('display_order')
            ->latest()
            ->get();

        return view('frontend.home', [
            'siteinfo' => $siteinfo,
            'slider' => $slider,
            'universities' => $universities,
            'programs' => $programs,
            'popularPrograms' => $popularPrograms,
            'blogPosts' => $blogPosts,
            'newsItems' => $newsItems,
            'programCategories' => $programCategories,
            'homeSections' => $homeSections,
            'homeTestimonials' => $homeTestimonials,
            'homePartners' => $homePartners,
            'frontendData' => $this->frontendData($universities, $programs, $blogPosts, $newsItems),
        ]);
    }

    private function frontendData($universities, $programs, $blogPosts, $newsItems): array
    {
        return [
            'universities' => $universities->map(fn (University $university) => [
                'id' => $university->slug ?: (string) $university->id,
                'name' => $university->name,
                'shortName' => Str::limit($university->name, 18, ''),
                'location' => $university->location ?: '',
                'logoUrl' => $this->imageUrl($university->image_1, 'https://images.unsplash.com/photo-1562774053-701939374585?w=120&h=120&fit=crop&q=80'),
                'programsCount' => $university->programs_count ?? $university->programs()->count(),
                'accreditation' => $university->accreditation_badge ?: '',
            ])->values(),
            'programs' => $programs->map(fn (Program $program) => [
                'id' => $program->slug ?: (string) $program->id,
                'name' => $program->program,
                'universityId' => $program->university?->slug ?: (string) $program->university_id,
                'degreeType' => $program->degree?->name ?: $program->type ?: 'Program',
                'category' => $program->type ?: $program->degree?->name ?: 'General',
                'duration' => $program->duration ?: 'Flexible',
                'price' => $program->total_fee ?: 'Contact',
                'popular' => (bool) $program->recommend,
                'image' => $this->imageUrl($program->university?->image_1, 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?w=600&h=400&fit=crop&q=80'),
            ])->values(),
            'blogPosts' => $blogPosts->map(fn (BlogPost $post) => [
                'id' => $post->slug ?: (string) $post->id,
                'title' => $post->title,
                'category' => $post->category?->name ?: 'Education Insights',
            ])->values(),
            'newsItems' => $newsItems->map(fn (News $news) => [
                'id' => $news->slug ?: (string) $news->id,
                'title' => $news->title,
                'category' => $news->category ?: 'Admissions News',
            ])->values(),
        ];
    }

    private function imageUrl(?string $path, string $fallback): string
    {
        return FrontendMedia::image($path, $fallback);
    }
}
