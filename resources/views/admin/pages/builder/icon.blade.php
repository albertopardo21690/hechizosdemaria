@switch($icon)
    @case('sparkles')<path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4M4 19h4M13 3l4 8-4 8-4-8 4-8z"/>@break
    @case('text')<path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h10"/>@break
    @case('h1')<path stroke-linecap="round" stroke-linejoin="round" d="M4 6v12M12 6v12M4 12h8m4 0h4m0-6v12"/>@break
    @case('image')<path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>@break
    @case('columns')<path stroke-linecap="round" stroke-linejoin="round" d="M4 6v12M12 6v12M20 6v12"/>@break
    @case('cursor')<path stroke-linecap="round" stroke-linejoin="round" d="M15 15l-2 5-3-8-8-3 5-2 2-4 2 4 8 2-4 4z"/>@break
    @case('quote')<path stroke-linecap="round" stroke-linejoin="round" d="M7 8h2v6H5V10a2 2 0 012-2zm8 0h2v6h-4V10a2 2 0 012-2z"/>@break
    @case('grid')<path stroke-linecap="round" stroke-linejoin="round" d="M4 6h6v6H4V6zm10 0h6v6h-6V6zM4 12h6v6H4v-6zm10 0h6v6h-6v-6z"/>@break
    @case('chat')<path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.77 9.77 0 01-4-.836L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>@break
    @case('tag')<path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5a2 2 0 011.41.59l7 7a2 2 0 010 2.82l-5 5a2 2 0 01-2.82 0l-7-7A2 2 0 014 10V5a2 2 0 012-2z"/>@break
    @case('minus')<path stroke-linecap="round" d="M5 12h14"/>@break
    @case('arrows')<path stroke-linecap="round" stroke-linejoin="round" d="M8 7l4-4m0 0l4 4m-4-4v18m-4-4l4 4m0 0l4-4"/>@break
    @case('code')<path stroke-linecap="round" stroke-linejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>@break
    @case('cart')<path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 9m14-9l2 9"/>@break
@endswitch
