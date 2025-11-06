<?php

namespace App\Services;

class Helpers
{
    public static function convertHtmlToWhatsApp($html)
    {
        $text = ($html);

        // Substitui as formatações
        $text = str_replace('<hr contenteditable="false">', '|', $text); // Negrito
        $text = preg_replace('/<strong>(.*?)<\/strong>/', '*$1*', $text); // Negrito
        $text = preg_replace('/<em>(.*?)<\/em>/', '_$1_', $text); // Itálico
        $text = preg_replace('/<u>(.*?)<\/u>/', '~$1~', $text); // Sublinhado
        $text = str_replace('<br>', "\n\n", $text); // Quebra de linha
        $text = str_replace('&nbsp;', "\n", $text);

        $text = strip_tags($text);

        // Substitui emojis ou caracteres especiais conforme necessário
        // $text = str_replace('⚖️', '[⚖️]', $text); // Exemplo de como incluir emoji de maneira que não se perca
        // $text = str_replace('????', '[?]', $text); // Exemplo de substituição para caracteres especiais

        return ($text);
    }
}
