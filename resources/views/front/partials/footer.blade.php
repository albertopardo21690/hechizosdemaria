<footer class="mt-20 bg-pink-50 pt-20 pb-10 border-t border-pink-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">

            <div>
                <div class="flex items-center gap-3 mb-6">
                    <img src="/images/branding/Logo-Hechizos-de-Maria.png" alt="Hechizos de María" class="h-10 w-auto">
                </div>
                <p class="text-gray-600 text-sm leading-relaxed mb-6">María José Gómez. Tarotista profesional, astróloga y ritualista. Guía espiritual con más de 15 años de experiencia.</p>
                <div class="flex gap-3">
                    <a href="https://www.tiktok.com/@hechizosdemariatarot" target="_blank" rel="noopener" class="w-10 h-10 border border-pink-200 rounded-full flex items-center justify-center text-gray-500 hover:bg-pink-500 hover:text-white hover:border-pink-500 transition-all" aria-label="TikTok">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5.8 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1.84-.1z"/></svg>
                    </a>
                    <a href="https://wa.me/34695619087" target="_blank" rel="noopener" class="w-10 h-10 border border-pink-200 rounded-full flex items-center justify-center text-gray-500 hover:bg-green-500 hover:text-white hover:border-green-500 transition-all" aria-label="WhatsApp">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    </a>
                </div>
            </div>

            <div>
                <h4 class="text-pink-500 text-xs font-bold uppercase tracking-widest mb-6">Tienda mágica</h4>
                <ul class="space-y-3 text-sm text-gray-600">
                    <li><a href="{{ route('collection', 'lecturas') }}" class="hover:text-pink-600 transition-colors">Lecturas de tarot</a></li>
                    <li><a href="{{ route('collection', 'rituales') }}" class="hover:text-pink-600 transition-colors">Rituales personalizados</a></li>
                    <li><a href="{{ route('collection', 'perfumes-arabes') }}" class="hover:text-pink-600 transition-colors">Perfumes árabes</a></li>
                    <li><a href="{{ route('collection', 'inciensos-organicos') }}" class="hover:text-pink-600 transition-colors">Inciensos y resinas</a></li>
                    <li><a href="{{ route('shop') }}" class="hover:text-pink-600 transition-colors">Ver toda la tienda</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-pink-500 text-xs font-bold uppercase tracking-widest mb-6">Información</h4>
                <ul class="space-y-3 text-sm text-gray-600">
                    <li><a href="{{ route('page', 'sobre-mi') }}" class="hover:text-pink-600 transition-colors">Sobre María José</a></li>
                    <li><a href="{{ route('booking') }}" class="hover:text-pink-600 transition-colors">Reservar cita</a></li>
                    <li><a href="{{ route('testimonials') }}" class="hover:text-pink-600 transition-colors">Testimonios</a></li>
                    <li><a href="{{ route('page', 'politica-privacidad') }}" class="hover:text-pink-600 transition-colors">Política de privacidad</a></li>
                    <li><a href="{{ route('page', 'aviso-legal') }}" class="hover:text-pink-600 transition-colors">Aviso legal</a></li>
                    <li><a href="{{ route('page', 'condiciones-compra') }}" class="hover:text-pink-600 transition-colors">Condiciones de compra</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-pink-500 text-xs font-bold uppercase tracking-widest mb-6">Contacto</h4>
                <div class="space-y-3 text-sm text-gray-600">
                    <a href="mailto:hechizosdemaria@gmail.com" class="block hover:text-pink-600 transition-colors">hechizosdemaria@gmail.com</a>
                    <a href="tel:+34695619087" class="block hover:text-pink-600 transition-colors">+34 695 619 087</a>
                </div>
                <div class="flex flex-wrap gap-2 items-center mt-6">
                    <span class="text-[10px] uppercase tracking-widest text-gray-400">Pagos seguros:</span>
                    <span class="px-2 py-1 bg-white rounded-md text-[10px] font-bold text-gray-500 border border-pink-100">VISA</span>
                    <span class="px-2 py-1 bg-white rounded-md text-[10px] font-bold text-gray-500 border border-pink-100">MC</span>
                    <span class="px-2 py-1 bg-white rounded-md text-[10px] font-bold text-gray-500 border border-pink-100">PayPal</span>
                    <span class="px-2 py-1 bg-white rounded-md text-[10px] font-bold text-gray-500 border border-pink-100">Bizum</span>
                </div>
            </div>
        </div>

        <div class="pt-8 border-t border-pink-200 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-[10px] text-gray-500 uppercase tracking-widest">&copy; {{ date('Y') }} Hechizos de María. Todos los derechos reservados.</p>
            <p class="text-[10px] text-gray-400 uppercase tracking-widest italic">Bendecida por las estrellas</p>
        </div>
    </div>
</footer>
