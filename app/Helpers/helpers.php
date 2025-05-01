<?php

/**
 * Formata números para o formato K (mil) ou M (milhão)
 * Exemplo: 1200 se tornaria 1.2K, 1200000 se tornaria 1.2M
 * 
 * @param int $number O número a ser formatado
 * @param int $precision O número de casas decimais (padrão: 1)
 * @return string O número formatado
 */
if (!function_exists('format_views')) {
    function format_views($number, $precision = 1)
    {
        if ($number < 1000) {
            // Retorna o número sem formatação se for menor que 1000
            return $number;
        } elseif ($number < 1000000) {
            // Formato K para milhares
            return round($number / 1000, $precision) . 'K';
        } elseif ($number < 1000000000) {
            // Formato M para milhões
            return round($number / 1000000, $precision) . 'M';
        } else {
            // Formato B para bilhões
            return round($number / 1000000000, $precision) . 'B';
        }
    }
}

/**
 * Alias alternativo para format_views para compatibilidade
 */
if (!function_exists('formatViews')) {
    function formatViews($number, $precision = 1)
    {
        return format_views($number, $precision);
    }
}