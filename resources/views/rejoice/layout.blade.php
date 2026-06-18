<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Rejoice Pages') | Rejoice Pages</title>
    <meta name="description" content="@yield('meta_description', 'Rejoice Pages helps Christian creators and ministries share their work clearly, build trust, and prepare for Rejoice Audio.')">

    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title', 'Rejoice Pages')">
    <meta property="og:description" content="@yield('meta_description', 'A trusted home for Christian creators.')">
    <meta property="og:url" content="{{ url()->current() }}">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'Rejoice Pages')">
    <meta name="twitter:description" content="@yield('meta_description', 'A trusted home for Christian creators.')">

    <style>
        :root {
            --ink: #1f2430;
            --muted: #5d6675;
            --line: #e6e8ee;
            --bg: #ffffff;
            --soft: #f7f8fa;
            --accent: #2f5d62;
            --accent-ink: #ffffff;
        }
        * { box-sizing: border-box; }
        html, body { margin: 0; padding: 0; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            color: var(--ink);
            background: var(--bg);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }
        a { color: var(--accent); text-decoration: none; }
        a:hover { text-decoration: underline; }
        .container { max-width: 980px; margin: 0 auto; padding: 0 24px; }
        header.site {
            border-bottom: 1px solid var(--line);
            position: sticky; top: 0; background: rgba(255,255,255,0.92);
            backdrop-filter: saturate(180%) blur(8px); z-index: 10;
        }
        header.site .row { display: flex; align-items: center; justify-content: space-between; height: 64px; }
        .brand { font-weight: 700; font-size: 18px; color: var(--ink); letter-spacing: -0.01em; }
        nav.site a { color: var(--muted); margin-left: 22px; font-size: 15px; }
        nav.site a:hover { color: var(--ink); text-decoration: none; }
        @media (max-width: 720px) { nav.site { display: none; } }
        .btn {
            display: inline-block; padding: 11px 20px; border-radius: 8px;
            font-weight: 600; font-size: 15px; border: 1px solid var(--line);
        }
        .btn-primary { background: var(--accent); color: var(--accent-ink); border-color: var(--accent); }
        .btn-primary:hover { text-decoration: none; opacity: 0.93; }
        .btn-ghost { background: #fff; color: var(--ink); }
        .btn-ghost:hover { text-decoration: none; background: var(--soft); }
        section { padding: 56px 0; border-bottom: 1px solid var(--line); }
        h1 { font-size: 40px; line-height: 1.15; letter-spacing: -0.02em; margin: 0 0 16px; }
        h2 { font-size: 26px; letter-spacing: -0.01em; margin: 0 0 14px; }
        h3 { font-size: 18px; margin: 0 0 6px; }
        p.lead { font-size: 19px; color: var(--muted); max-width: 680px; }
        .muted { color: var(--muted); }
        .actions { margin-top: 26px; display: flex; gap: 12px; flex-wrap: wrap; }
        .grid { display: grid; gap: 14px; }
        .grid-2 { grid-template-columns: repeat(2, 1fr); }
        .grid-3 { grid-template-columns: repeat(3, 1fr); }
        .grid-4 { grid-template-columns: repeat(4, 1fr); }
        @media (max-width: 720px) { .grid-2, .grid-3, .grid-4 { grid-template-columns: 1fr; } }
        .card { border: 1px solid var(--line); border-radius: 10px; padding: 18px 20px; background: #fff; }
        .chip { border: 1px solid var(--line); border-radius: 8px; padding: 12px 14px; background: var(--soft); font-size: 15px; }
        ul.clean { padding-left: 18px; color: var(--muted); }
        ul.clean li { margin: 6px 0; }
        footer.site { padding: 40px 0; color: var(--muted); font-size: 14px; }
        footer.site .attr { margin-top: 14px; font-size: 13px; }
        .faq-item { padding: 22px 0; border-bottom: 1px solid var(--line); }
        .faq-item:last-child { border-bottom: 0; }
        label { display: block; font-weight: 600; margin: 14px 0 6px; font-size: 15px; }
        input, select, textarea {
            width: 100%; padding: 11px 12px; border: 1px solid var(--line);
            border-radius: 8px; font-size: 15px; font-family: inherit; color: var(--ink);
        }
        .form-note { font-size: 13px; color: var(--muted); margin-top: 6px; }
        .alert { padding: 14px 16px; border-radius: 8px; margin-bottom: 18px; }
        .alert-success { background: #eef6f0; border: 1px solid #cfe6d6; color: #235a37; }
        .alert-error { background: #fbeeee; border: 1px solid #f0d2d2; color: #7a2b2b; }
    </style>
</head>
<body>
    <header class="site">
        <div class="container row">
            <a class="brand" href="{{ route('rejoice.landing') }}">Rejoice Pages</a>
            <nav class="site">
                <a href="{{ route('rejoice.landing') }}">Overview</a>
                <a href="{{ route('rejoice.faq') }}">FAQ</a>
                <a href="{{ route('rejoice.examples') }}">Examples</a>
                <a href="{{ route('rejoice.create') }}">Create a Page</a>
                <a href="{{ route('rejoice.waitlist') }}">Creator Waitlist</a>
            </nav>
        </div>
    </header>

    @yield('content')

    <footer class="site">
        <div class="container">
            <div>Rejoice Pages helps Christian creators and ministries share their work clearly, build trust, and prepare for Rejoice Audio.</div>
            <div class="attr">Rejoice Pages is built on open-source LinkStack infrastructure.</div>
        </div>
    </footer>
</body>
</html>
