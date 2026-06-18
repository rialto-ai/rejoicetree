<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"></head>
<body style="margin:0;background:#f7f8fa;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif;color:#1f2430;">
  <div style="max-width:560px;margin:0 auto;padding:32px 24px;">
    <div style="font-weight:700;font-size:18px;color:#2f5d62;margin-bottom:18px;">Rejoice Pages</div>
    <div style="background:#fff;border:1px solid #e6e8ee;border-radius:10px;padding:28px;">
      <h1 style="font-size:22px;margin:0 0 14px;">{{ $heading }}</h1>
      @foreach($lines as $line)
        <p style="font-size:15px;line-height:1.6;color:#3a414f;margin:0 0 12px;">{{ $line }}</p>
      @endforeach
    </div>
    <p style="font-size:12px;color:#8a92a1;margin-top:18px;">
      A trusted home for Christian creators.<br>
      Rejoice Pages is built on open-source LinkStack infrastructure.
    </p>
  </div>
</body>
</html>
