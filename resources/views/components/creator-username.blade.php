<!-- resources/views/components/creator-username.blade.php -->
<span class="creator-username">
    <a href="{{ route('creator.profile', ['username' => $username]) }}" class="username-link">
        @{{ $username }}
        @if(isset($verified) && $verified)
        <span class="verified-badge" title="Conta Verificada">
            <svg viewBox="0 0 24 24" fill="currentColor" width="16" height="16">
                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
            </svg>
        </span>
        @endif
        @if(isset($online) && $online)
        <span class="online-badge" title="Online Agora"></span>
        @endif
    </a>
</span>