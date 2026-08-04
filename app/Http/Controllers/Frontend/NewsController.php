<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\News;
use App\Models\Program;
use App\Models\ProgramCategory;
use App\Models\Siteinfo;
use App\Models\University;
use App\Support\FrontendMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index()
    {
        $newsPage = News::where('status', true)
            ->latest('published_at')
            ->paginate(10);

        return view('frontend.news.index', array_merge($this->sharedData(), [
            'newsPage' => $newsPage,
        ]));
    }

    public function show(News $news)
    {
        abort_unless($news->status, 404);

        $recentNews = News::where('status', true)
            ->whereKeyNot($news->id)
            ->latest('published_at')
            ->take(4)
            ->get();

        return view('frontend.news.show', array_merge($this->sharedData(), [
            'news' => $news,
            'recentNews' => $recentNews,
        ]));
    }

    public function legacyShow(Request $request)
    {
        $id = $request->query('id');
        $news = News::where('slug', $id)->orWhere('id', $id)->firstOrFail();

        return redirect()->route('frontend.news.show', $news->slug);
    }

    private function sharedData(): array
    {
        $universities = University::where('status', true)->withCount('programs')->orderBy('priority')->latest()->take(6)->get();
        $programs = Program::with(['degree', 'university'])->where('status', true)->latest()->take(8)->get();
        $programCategories = ProgramCategory::where('status', true)->orderBy('name')->get();
        $blogPosts = BlogPost::with('category')->where('is_published', true)->latest('published_at')->take(2)->get();
        $newsItems = News::where('status', true)->latest('published_at')->take(2)->get();
        $popularPrograms = $programs->where('recommend', true);

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
            'frontendData' => $this->frontendData($universities, $programs, $blogPosts, $newsItems),
        ];
    }

    private function frontendData($universities, $programs, $blogPosts, $newsItems): array
    {
        return [
            'universities' => $universities->map(fn (University $university) => [
                'id' => $university->slug,
                'name' => $university->name,
                'shortName' => Str::limit($university->name, 18, ''),
                'location' => $university->location,
                'logoUrl' => $this->assetUrl($university->image_1),
                'programsCount' => $university->programs_count ?? 0,
                'accreditation' => $university->accreditation_badge,
            ])->values(),
            'programs' => $programs->map(fn (Program $program) => [
                'id' => $program->slug,
                'name' => $program->program,
                'universityId' => $program->university?->slug,
                'degreeType' => $program->degree?->name ?? $program->type,
                'category' => $program->degree?->name ?? $program->type,
                'duration' => $program->duration,
                'price' => $program->total_fee ?: 'Contact',
                'popular' => $program->recommend,
                'image' => $this->assetUrl($program->image ?: $program->university?->image_1),
            ])->values(),
            'blogPosts' => $blogPosts->map(fn (BlogPost $post) => [
                'id' => $post->slug,
                'title' => $post->title,
                'category' => $post->category?->name,
                'excerpt' => $post->excerpt,
                'image' => $this->assetUrl($post->image),
                'author' => $post->author_name,
                'date' => optional($post->published_at)->format('M d, Y'),
            ])->values(),
            'newsItems' => $newsItems->map(fn (News $item) => [
                'id' => $item->slug,
                'title' => $item->title,
                'category' => $item->category ?: 'Admissions News',
                'excerpt' => $item->short_description,
                'date' => optional($item->published_at)->format('F d, Y'),
            ])->values(),
        ];
    }

    private function assetUrl(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        return FrontendMedia::image($path);
    }
}
