@php
    $seoData = \App\Support\SeoMeta::fromModel($seoModel ?? null, $seo ?? []);
    $title = $seoData['title'];
    $desc = $seoData['desc'];
    $ogTitle = $seoData['ogTitle'] ?? $title;
    $ogDescription = $seoData['ogDescription'] ?? $desc;
    $twitterTitle = $seoData['twitterTitle'] ?? $title;
    $twitterDescription = $seoData['twitterDescription'] ?? $desc;
    $author = $seoData['author'];
    $publisher = $seoData['publisher'];
    $copyright = $seoData['copyright'];
    $keywords = $seoData['keywords'];
    $url = $seoData['url'];
    $indexable = $seoData['indexable'];
    $robots = $seoData['robots'];
    $siteName = $seoData['siteName'];
    $ogImage = $seoData['ogImage'];
    $updatedIso = $seoData['updatedIso'];
    $twitter = $seoData['twitter'];
@endphp
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{ $title }}</title>
<meta name="title" content="{{ $title }}">
<meta name="description" content="{{ $desc }}">
<meta name="author" content="{{ $author }}">
@if ($publisher)
<meta name="publisher" content="{{ $publisher }}">
@endif
@if ($copyright)
<meta name="copyright" content="{{ $copyright }}">
@endif
@if ($keywords)
<meta name="keywords" content="{{ $keywords }}">
@endif
<link rel="canonical" href="{{ $url }}">
<meta name="robots" content="{{ $robots ?: ($indexable ? 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1' : 'noindex, nofollow') }}">

<meta property="og:type" content="website">
<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:title" content="{{ $ogTitle }}">
<meta property="og:description" content="{{ $ogDescription }}">
<meta property="og:url" content="{{ $url }}">
<meta property="og:image" content="{{ $ogImage }}">
<meta property="og:image:secure_url" content="{{ $ogImage }}">
<meta property="og:image:alt" content="{{ $siteName }}">
<meta property="og:updated_time" content="{{ $updatedIso }}">
<meta property="og:locale" content="en_US">
@if ($publisher)
<meta property="article:publisher" content="{{ $publisher }}">
@endif
@if ($author)
<meta property="article:author" content="{{ $author }}">
@endif

<meta name="twitter:card" content="summary">
<meta name="twitter:site" content="{{ $twitter }}">
<meta name="twitter:title" content="{{ $twitterTitle }}">
<meta name="twitter:description" content="{{ $twitterDescription }}">
<meta name="twitter:url" content="{{ $url }}">
<meta name="twitter:image" content="{{ $ogImage }}">

<meta name="csrf-token" content="{{ csrf_token() }}">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
