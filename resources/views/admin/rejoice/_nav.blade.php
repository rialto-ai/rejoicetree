<ul class="nav nav-pills mb-3 px-2" style="gap:6px;">
  <li class="nav-item"><a class="nav-link {{ request()->routeIs('rejoice.admin.creators') ? 'active' : '' }}" href="{{ route('rejoice.admin.creators') }}">Creators</a></li>
  <li class="nav-item"><a class="nav-link {{ request()->routeIs('rejoice.admin.pending') ? 'active' : '' }}" href="{{ route('rejoice.admin.pending') }}">Pending Review</a></li>
  <li class="nav-item"><a class="nav-link {{ request()->routeIs('rejoice.admin.flagged') ? 'active' : '' }}" href="{{ route('rejoice.admin.flagged') }}">Flagged</a></li>
  <li class="nav-item"><a class="nav-link {{ request()->routeIs('rejoice.admin.verification') ? 'active' : '' }}" href="{{ route('rejoice.admin.verification') }}">Verification</a></li>
  <li class="nav-item"><a class="nav-link {{ request()->routeIs('rejoice.admin.audio') ? 'active' : '' }}" href="{{ route('rejoice.admin.audio') }}">Audio Onboarding</a></li>
  <li class="nav-item"><a class="nav-link {{ request()->routeIs('rejoice.admin.support') ? 'active' : '' }}" href="{{ route('rejoice.admin.support') }}">Support Links</a></li>
  <li class="nav-item"><a class="nav-link {{ request()->routeIs('rejoice.admin.settings') ? 'active' : '' }}" href="{{ route('rejoice.admin.settings') }}">Settings</a></li>
</ul>
@if(session()->has('success'))
  <div class="alert alert-success mx-2">{{ session()->get('success') }}</div>
@endif
