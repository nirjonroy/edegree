<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\News;
use App\Models\Program;
use App\Models\ProgramCategory;
use App\Models\Siteinfo;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProgramController extends Controller
{
    public function index(Request $request)
    {
        $query = trim((string) $request->query('query', ''));
        $degree = trim((string) $request->query('degree', ''));
        $category = trim((string) $request->query('category', ''));
        $university = trim((string) $request->query('university', ''));

        $programsPage = Program::with(['degree', 'university'])
            ->where('status', true)
            ->when($query, function ($builder) use ($query) {
                $builder->where(function ($inner) use ($query) {
                    $inner->where('program', 'like', "%{$query}%")
                        ->orWhere('short_name', 'like', "%{$query}%")
                        ->orWhere('short_description', 'like', "%{$query}%")
                        ->orWhere('type', 'like', "%{$query}%")
                        ->orWhereHas('university', fn ($q) => $q->where('name', 'like', "%{$query}%"));
                });
            })
            ->when($degree && $degree !== 'All', function ($builder) use ($degree) {
                $builder->where(function ($inner) use ($degree) {
                    $inner->where('type', $degree)
                        ->orWhereHas('degree', fn ($q) => $q->where('name', $degree));
                });
            })
            ->when($category && $category !== 'All', fn ($builder) => $builder->where('type', $category))
            ->when($university, function ($builder) use ($university) {
                $builder->whereHas('university', function ($inner) use ($university) {
                    $inner->where('slug', $university)->orWhere('id', $university);
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('frontend.programs.index', array_merge($this->sharedData(), [
            'programsPage' => $programsPage,
            'query' => $query,
            'selectedDegree' => $degree,
            'selectedCategory' => $category,
            'selectedUniversity' => $university,
            'filterUniversities' => University::where('status', true)->orderBy('name')->get(),
        ]));
    }

    public function show(Program $program)
    {
        abort_unless($program->status, 404);

        $program->load(['degree', 'university']);

        $relatedPrograms = Program::with(['degree', 'university'])
            ->where('status', true)
            ->whereKeyNot($program->id)
            ->when($program->degree_id, function ($query) use ($program) {
                $query->where('degree_id', $program->degree_id);
            }, function ($query) use ($program) {
                $query->where('type', $program->type);
            })
            ->orderByDesc('recommend')
            ->latest()
            ->paginate(10, ['*'], 'related_page')
            ->withQueryString();

        return view('frontend.programs.show', array_merge($this->sharedData(), [
            'program' => $program,
            'relatedPrograms' => $relatedPrograms,
        ]));
    }

    public function legacyShow(Request $request)
    {
        $id = $request->query('id');
        $program = Program::where('slug', $id)->orWhere('id', $id)->firstOrFail();

        return redirect()->route('frontend.programs.show', $program->slug);
    }

    private function sharedData(): array
    {
        $siteinfo = Siteinfo::latest()->first();
        $universities = University::where('status', true)->withCount('programs')->orderBy('priority')->latest()->take(6)->get();
        $programs = Program::with(['degree', 'university'])->where('status', true)->latest()->take(8)->get();
        $popularPrograms = Program::with(['degree', 'university'])->where('status', true)->where('recommend', true)->latest()->take(3)->get();

        if ($popularPrograms->isEmpty()) {
            $popularPrograms = $programs->take(3);
        }

        $blogPosts = BlogPost::with('category')->where('is_published', true)->latest('published_at')->take(2)->get();
        $newsItems = News::where('status', true)->latest('published_at')->take(2)->get();

        return [
            'siteinfo' => $siteinfo,
            'universities' => $universities,
            'programs' => $programs,
            'popularPrograms' => $popularPrograms,
            'programCategories' => ProgramCategory::where('status', true)->orderBy('name')->get(),
            'frontendData' => $this->frontendData($universities, $programs, $blogPosts, $newsItems),
        ];
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
                'programsCount' => $university->programs_count ?? 0,
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
        if (! $path) {
            return $fallback;
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        return asset($path);
    }
}
