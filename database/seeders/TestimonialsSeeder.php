<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialsSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Laura M.',
                'location' => 'Madrid',
                'service_type' => 'lectura',
                'rating' => 5,
                'text' => 'María José me dio una lectura que cambió mi perspectiva por completo. Acertó con cosas que solo yo sabía y me guió con una dulzura impresionante. Volveré sin duda.',
                'featured' => true,
                'approved' => true,
                'sort' => 1,
            ],
            [
                'name' => 'Carmen V.',
                'location' => 'Sevilla',
                'service_type' => 'ritual',
                'rating' => 5,
                'text' => 'Hice el ritual de endulzamiento amoroso y a las dos semanas mi pareja y yo volvimos a conectar como al principio. No sé cómo funciona, pero funciona. Gracias María José.',
                'featured' => true,
                'approved' => true,
                'sort' => 2,
            ],
            [
                'name' => 'Isabel R.',
                'location' => 'Barcelona',
                'service_type' => 'bola_cristal',
                'rating' => 5,
                'text' => 'La lectura con bola de cristal fue una experiencia espiritual increíble. Vio detalles de mi futuro que ya se están cumpliendo. Tiene un don real.',
                'featured' => true,
                'approved' => true,
                'sort' => 3,
            ],
            [
                'name' => 'Raquel G.',
                'location' => 'Valencia',
                'service_type' => 'lectura',
                'rating' => 5,
                'text' => 'Estaba muy perdida con una decisión laboral. María José me hizo la lectura Premium y me dio tanta claridad que pude decidir sin dudar. Acertó en todo.',
                'featured' => true,
                'approved' => true,
                'sort' => 4,
            ],
            [
                'name' => 'Nerea P.',
                'location' => 'Bilbao',
                'service_type' => 'producto',
                'rating' => 5,
                'text' => 'El perfume Saher huele divino y desde que lo uso siento una energía diferente. María José explica todo con mucho cariño y los envíos llegan súper rápido.',
                'featured' => true,
                'approved' => true,
                'sort' => 5,
            ],
            [
                'name' => 'Mónica D.',
                'location' => 'Málaga',
                'service_type' => 'tarot_24h',
                'rating' => 5,
                'text' => 'Necesitaba una respuesta urgente sobre un tema familiar y me contestó por WhatsApp en menos de una hora. Profesional, empática y muy acertada.',
                'featured' => true,
                'approved' => true,
                'sort' => 6,
            ],
            [
                'name' => 'Patricia L.',
                'location' => 'Zaragoza',
                'service_type' => 'ritual',
                'rating' => 5,
                'text' => 'El pack de amarre de amor eterno vino con instrucciones clarísimas. Lo hice siguiendo cada paso y a los 40 días la persona volvió. Aún estoy en shock.',
                'featured' => false,
                'approved' => true,
                'sort' => 7,
            ],
            [
                'name' => 'Alba F.',
                'location' => 'Granada',
                'service_type' => 'lectura',
                'rating' => 5,
                'text' => 'La Lectura Baraja Gitana fue increíble. María José tiene una sensibilidad especial, no juzga y te acompaña en todo momento. Salí de la consulta mucho más tranquila.',
                'featured' => false,
                'approved' => true,
                'sort' => 8,
            ],
            [
                'name' => 'Cristina M.',
                'location' => 'Palma de Mallorca',
                'service_type' => 'producto',
                'rating' => 5,
                'text' => 'Compré la pulsera de código sagrado de San Miguel y desde entonces me siento más protegida. La calidad es excelente y el empaquetado con mucho mimo.',
                'featured' => false,
                'approved' => true,
                'sort' => 9,
            ],
            [
                'name' => 'Elena J.',
                'location' => 'Murcia',
                'service_type' => 'ritual',
                'rating' => 5,
                'text' => 'Hice el Ritual Billete de Prosperidad y a las pocas semanas me llegó una oferta de trabajo inesperada. María José explica que hay que mantener la fe y funciona.',
                'featured' => false,
                'approved' => true,
                'sort' => 10,
            ],
            [
                'name' => 'Silvia C.',
                'location' => 'Córdoba',
                'service_type' => 'bola_cristal',
                'rating' => 5,
                'text' => 'Vi videos suyos en TikTok y decidí probar la bola de cristal. Superó todas mis expectativas. Me dijo cosas que solo sabe mi madre. Recomiendo 100%.',
                'featured' => false,
                'approved' => true,
                'sort' => 11,
            ],
            [
                'name' => 'Rocío A.',
                'location' => 'Cádiz',
                'service_type' => 'lectura',
                'rating' => 5,
                'text' => 'Después de una ruptura muy dura, la lectura de María José me ayudó a ver la situación desde otra perspectiva. Es un ángel. Totalmente recomendada.',
                'featured' => false,
                'approved' => true,
                'sort' => 12,
            ],
        ];

        foreach ($testimonials as $t) {
            Testimonial::updateOrCreate(
                ['name' => $t['name'], 'location' => $t['location']],
                $t
            );
        }

        $this->command->info('Importados '.count($testimonials).' testimonios.');
    }
}
