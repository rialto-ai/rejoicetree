{{-- Rejoice public profile section. Expects $creatorProfile (nullable) and $userinfo. --}}
@php $rp = $creatorProfile ?? null; @endphp
@if($rp)
  <div class="rejoice-public" style="max-width:560px;margin:14px auto;text-align:center;font-family:inherit;">

    @if($rp->page_type)
      <div style="font-size:13px;letter-spacing:.04em;text-transform:uppercase;opacity:.7;">{{ $rp->page_type }}</div>
    @endif

    @if(rejoice_setting('show_verification_badges_publicly') && $rp->verificationBadge())
      <div style="margin-top:6px;">
        <span style="display:inline-block;border:1px solid currentColor;opacity:.85;border-radius:6px;padding:3px 10px;font-size:13px;">
          &#10003; {{ $rp->verificationBadge() }}
        </span>
      </div>
    @endif

    @if(!empty($rp->testimony))
      <div style="margin-top:14px;font-size:15px;opacity:.9;">{!! nl2br(e($rp->testimony)) !!}</div>
    @endif

    @if($rp->church_affiliation || $rp->ministry_affiliation)
      <div style="margin-top:8px;font-size:13px;opacity:.7;">
        @if($rp->church_affiliation){{ $rp->church_affiliation }}@endif
        @if($rp->church_affiliation && $rp->ministry_affiliation) · @endif
        @if($rp->ministry_affiliation){{ $rp->ministry_affiliation }}@endif
      </div>
    @endif

    {{-- Rejoice Audio status --}}
    <div style="margin-top:12px;font-size:13px;opacity:.7;">
      @if($rp->rejoice_audio_status === 'Live')
        Available on Rejoice Audio.
      @elseif(in_array($rp->rejoice_audio_status, ['Onboarding','Submitted','Reviewed']))
        Rejoice Audio onboarding in progress.
      @else
        Rejoice Audio profile coming soon.
      @endif
    </div>

    {{-- Authorship & AI-use disclosure (admin-gated globally) --}}
    @if(rejoice_setting('show_ai_disclosure_publicly'))
      <div style="margin-top:14px;font-size:13px;opacity:.75;border-top:1px solid rgba(127,127,127,.2);padding-top:10px;">
        <strong>Authorship</strong><br>
        @if($rp->human_authorship_status === 'Human Authorship Confirmed')
          Human authorship confirmed. AI assistance, where used, is disclosed.
        @elseif($rp->human_authorship_status === 'Not Provided')
          Authorship disclosure not yet provided.
        @else
          This creator has provided a human-authorship and AI-use disclosure.
        @endif
        @if(!empty($rp->ai_use_disclosure_text))
          <div style="margin-top:4px;">{{ $rp->ai_use_disclosure_text }}</div>
        @endif
      </div>
    @endif
  </div>
@endif

{{-- Support link disclaimer + report link --}}
@if(isset($userinfo) && !empty($userinfo->littlelink_name))
  <div style="max-width:560px;margin:10px auto;text-align:center;font-size:12px;opacity:.6;">
    <a href="{{ route('rejoice.report.form', ['slug' => $userinfo->littlelink_name]) }}" style="color:inherit;">Report this page</a>
  </div>
@endif
