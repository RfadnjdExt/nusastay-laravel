@extends('layouts.app')

@section('title', 'Blog | Nusa Stay')

@section('content')
<section style="padding: 48px 0; background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%); color: var(--color-light);">
    <div class="container">
        <h1 style="font-size: 2.5rem; margin-bottom: 16px;">Travel Blog</h1>
        <p style="font-size: 1.125rem; opacity: 0.9;">Discover travel tips, destination guides, and local insights</p>
    </div>
</section>

<section style="padding: 64px 0;">
    <div class="container">
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 32px;">
            @foreach($articles as $article)
                <article style="background: var(--color-card-bg); border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-soft); transition: var(--transition);"
                    onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='var(--shadow-hover)'"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='var(--shadow-soft)'">
                    <div style="height: 240px; overflow: hidden;">
                        <img src="{{ asset('images/' . $article['image']) }}" alt="{{ $article['title'] }}" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div style="padding: 24px;">
                        <div style="display: flex; gap: 12px; margin-bottom: 12px; font-size: 0.875rem; color: var(--color-gray);">
                            <span>📅 {{ \Carbon\Carbon::parse($article['date'])->format('M d, Y') }}</span>
                            <span>✍️ {{ $article['author'] }}</span>
                        </div>
                        <h2 style="font-size: 1.5rem; margin-bottom: 12px; color: var(--color-dark);">{{ $article['title'] }}</h2>
                        <p style="color: var(--color-gray); line-height: 1.6; margin-bottom: 16px;">{{ $article['excerpt'] }}</p>
                        <a href="#" class="btn btn-outline" style="display: inline-flex; padding: 10px 20px; font-size: 0.875rem;">
                            Read More →
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endsection
