<?php
namespace App\Services;

use GuzzleHttp\Client;

class PlacesService
{
    protected $key;
    protected $client;

    public function __construct()
    {
        $this->key = config('services.places.key', env('GOOGLE_PLACES_KEY'));
        $this->client = new Client(['base_uri' => 'https://maps.googleapis.com/maps/api/place/']);
    }

    public function getPlaceDetails(string $placeId): ?array
    {
        $res = $this->client->get('details/json', [
            'query' => [
                'place_id' => $placeId,
                'key' => $this->key,
                'fields' => 'name,rating,reviews,formatted_address,place_id'
            ],
            'http_errors' => false,
        ]);

        $code = $res->getStatusCode();
        $body = json_decode($res->getBody()->getContents(), true);

        if ($code !== 200 || ($body['status'] ?? '') !== 'OK') {
            return null;
        }

        return $body['result'] ?? null;
    }

    public function saveReviewsTxt(array $placeResult, string $filename)
    {
        $lines = ["Place: {$placeResult['name']} ({$placeResult['place_id']})"];
        foreach ($placeResult['reviews'] ?? [] as $r) {
            $lines[] = "{$r['author_name']} | {$r['rating']} | {$r['time']} | " . str_replace(["\r", "\n"], [' ', ' '], $r['text']);
        }
        \Illuminate\Support\Facades\Storage::disk('local')->put($filename, implode(PHP_EOL, $lines));
    }

    public static function getMockedReviews(): array
    {
        return [
            [
                'id' => 1,
                'author_name' => 'Valeria Aguiar',
                'profile' => '10 comentários • 0 fotos',
                'rating' => 5,
                'date' => 'Há 26 semanas',
                'text' => '',
                'reply' => null,

                'photo_url' => 'https://lh3.googleusercontent.com/a-/ALV-UjXt4RwJDYIaULhN85H8CDsvLTTScpOOVF0JMYc1ttrm0uR8d4ZE=s50-c-rp-mo-br100',
            ],
            [
                'id' => 2,
                'author_name' => 'Luciane Nascimento',
                'profile' => 'guia local • 14 comentários • 9 fotos',
                'rating' => 5,
                'date' => 'Há 34 semanas',
                'text' => 'A Cássia é uma ótima profissional, esclareceu todas as minhas dúvidas , conseguiu resolver o meu caso de maneira prática. Ótima profissional super gentil.',
                'reply' => null,
                'photo_url' => 'https://lh3.googleusercontent.com/a-/ALV-UjWzq0LP8Knb5R3Lrw3M8noVvn_NzMKHEH9Yyoc3FJKSRNKdVDkitA=s50-c-rp-mo-ba2-br100',
            ],
            [
                'id' => 3,
                'author_name' => 'Richard Novais',
                'profile' => '2 comentários • 0 fotos',
                'rating' => 5,
                'date' => 'Há 46 semanas',
                'text' => '',
                'reply' => null,
                'photo_url' => 'https://lh3.googleusercontent.com/a-/ALV-UjUt1g-AVYtijEL06MB9y0pLfRfpCrNVJTFuS4kBXDCRtMzvgYM7lg=s50-c-rp-mo-br100',
            ],
            [
                'id' => 4,
                'author_name' => 'Gabriel Guarizi costa',
                'profile' => 'guia local • 9 comentários • 1 foto',
                'rating' => 5,
                'date' => '08/08/2024',
                'text' => 'Muita atenciosa e com grande conhecimento! Recomendo',
                'reply' => null,
                'photo_url' => 'https://lh3.googleusercontent.com/a/ACg8ocLeDzkbUGwD_cbID7aHxIWvjfecDuOsWakoVn3b3GoqZlVL7A=s50-c-rp-mo-ba2-br100',
            ],
            [
                'id' => 5,
                'author_name' => 'Nelson Marques',
                'profile' => '1 comentário • 0 fotos',
                'rating' => 5,
                'date' => '28/06/2024',
                'text' => '',
                'reply' => null,
                'photo_url' => 'https://lh3.googleusercontent.com/a/ACg8ocIu_0lskJq-jfEultNy1-Ujh8RNDjo7vl9Q59fA0Z1Bd88r3Q=s50-c-rp-mo-br100',
            ],
            [
                'id' => 6,
                'author_name' => 'Andrea Luiza Silva Rosa',
                'profile' => '6 comentários • 0 fotos',
                'rating' => 5,
                'date' => '28/06/2024',
                'text' => 'Acabei de ser atendida p dra Cassia, eu adorei dialogar c ela pq ela transmitiu com grande segurança e endentimento... Ver crítica completa',
                'reply' => null,
                'photo_url' => 'https://lh3.googleusercontent.com/a/ACg8ocKcTa-jSbv8CxSavOU00ehXR2Pg4gcT2ojqCzsAIxajoVNIXg=s50-c-rp-mo-br100',
            ],
            [
                'id' => 7,
                'author_name' => 'Livia Mara Silva Rosa',
                'profile' => '4 comentários • 0 fotos',
                'rating' => 5,
                'date' => '28/06/2024',
                'text' => 'Fui muito bem atendida pela Dra. Cássia Souza. A Dra. Cássia estudou meu caso e se empenhou para responder com segurança... Ver crítica completa',
                'reply' => null,
                'photo_url' => 'https://lh3.googleusercontent.com/a/ACg8ocIw_9skRu4-clJh8_AMJ19Awxs_B4_3grE8KhCUk3q8xrqBcA=s50-c-rp-mo-br100',
            ],
            [
                'id' => 8,
                'author_name' => 'Rita Ferreira',
                'profile' => '3 comentários • 0 fotos',
                'rating' => 5,
                'date' => '27/06/2024',
                'text' => 'Excelente profissional! Muito correta e atualizada, confio de olhos fechados!',
                'reply' => null,
                'photo_url' => 'https://lh3.googleusercontent.com/a/ACg8ocICF5HvxN2pcjHSS-wWHg2ijcf-v3H9WKKwnvmUF2hljoD3_g=s50-c-rp-mo-br100',
            ],
            [
                'id' => 9,
                'author_name' => 'Udini Silva',
                'profile' => 'guia local • 37 comentários • 18 fotos',
                'rating' => 5,
                'date' => '26/06/2024',
                'text' => 'Profissional muito capacitada e qualificada tenho acompanhado as redes sociais e aprendido muito sobre tributação.',
                'reply' => 'Agradecemos muito pelo seu interesse e por acompanhar nossas redes sociais! Estamos sempre compartilhando conteúdos relevantes e informativos sobre questões tributárias.',
                'photo_url' => 'https://lh3.googleusercontent.com/a-/ALV-UjWFLxIC1R1UCnCIPDkbuce1q_pKQIaR6tyFy0QR4LzyOe7R_Xs=s50-c-rp-mo-ba3-br100',
            ],
            [
                'id' => 10,
                'author_name' => 'Adriana Souza',
                'profile' => '1 comentário • 0 fotos',
                'rating' => 5,
                'date' => '26/06/2024',
                'text' => 'Atendimento excelente!!! Super eficiente',
                'reply' => 'Agradecemos sinceramente pelo seu feedback. Estamos comprometidos em proporcionar uma experiência jurídica excelente e personalizada para cada cliente.',
                'photo_url' => 'https://lh3.googleusercontent.com/a/ACg8ocLCavsdLtkjl4mqqrdkj7Xm0glhmAyh19Gfiga0AZEIqI5xqhc=s50-c-rp-br100',
            ],
            [
                'id' => 11,
                'author_name' => 'Simone Alves da Silva Cardoso',
                'profile' => '9 comentários • 7 fotos',
                'rating' => 5,
                'date' => '26/06/2024',
                'text' => 'Excelente atendimento! A consultória atendeu as minhas... Ver crítica completa',
                'reply' => 'Agradecemos imensamente suas palavras gentis. Nosso objetivo é sempre oferecer um serviço jurídico de alta qualidade. Continuaremos trabalhando duro para manter esse padrão.',
                'photo_url' => 'https://lh3.googleusercontent.com/a-/ALV-UjUUiuwh8PnVujauWOcJ0nnlmRQx0AiacNa-dDHuPqhULCSKLlCNWw=s50-c-rp-mo-br100',
            ],
        ];
    }
}
