@php
    $hasConsent = request()->cookie('cookie_consent') !== null;
@endphp

@if(!$hasConsent)
<div id="cookie-banner" class="fixed bottom-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-md border-t border-pink-300 p-5 shadow-2xl">
    <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-start md:items-center gap-4">
        <div class="flex-1">
            <p class="text-sm text-gray-700 leading-relaxed">
                <span class="text-pink-500 font-semibold">Nos encanta verte volando por aqui.</span>
                Usamos cookies propias y de terceros para mejorar tu experiencia magica y analizar el trafico.
                <a href="{{ route('page', 'politica-privacidad') }}" class="text-pink-500 hover:text-pink-700 underline">Politica de privacidad</a>.
            </p>
        </div>
        <div class="flex gap-2 flex-shrink-0">
            <button type="button" onclick="setCookieConsent(0)" class="px-5 py-2 rounded-md text-xs uppercase tracking-widest font-semibold border border-gray-500/40 text-gray-700 hover:border-gray-400 transition">
                Rechazar
            </button>
            <button type="button" onclick="setCookieConsent(1)" class="px-5 py-2 rounded-md text-xs uppercase tracking-widest font-bold bg-gradient-to-br from-pink-500 to-pink-500 text-pink-900 hover:from-pink-500 hover:to-pink-300 transition">
                Aceptar
            </button>
        </div>
    </div>
</div>

<script>
function setCookieConsent(accepted) {
    const expiry = new Date();
    expiry.setTime(expiry.getTime() + (365 * 24 * 60 * 60 * 1000));
    document.cookie = 'cookie_consent=' + accepted + '; expires=' + expiry.toUTCString() + '; path=/; SameSite=Lax; Secure';
    document.getElementById('cookie-banner').remove();
}
</script>
@endif
