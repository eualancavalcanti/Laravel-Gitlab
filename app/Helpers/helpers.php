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

/**
 * Formata uma data timestamp em formato legível
 * 
 * @param string|int|DateTime $date A data a ser formatada
 * @param string $format O formato desejado (padrão: d/m/Y H:i)
 * @return string A data formatada
 */
if (!function_exists('format_date')) {
    function format_date($date, $format = 'd/m/Y H:i')
    {
        if (empty($date)) {
            return '';
        }
        
        if (is_numeric($date)) {
            return date($format, $date);
        }
        
        if ($date instanceof \DateTime) {
            return $date->format($format);
        }
        
        // Tentar converter a string para timestamp
        try {
            return date($format, strtotime($date));
        } catch (\Exception $e) {
            // Se falhar, retornar a string original
            return $date;
        }
    }
}