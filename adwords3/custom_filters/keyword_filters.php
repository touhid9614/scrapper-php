<?php

add_filter('filter_keywords', 'filter_keywords', 10, 3);

function filter_keywords($orig_keywords, $car, $directive)
{
    $keywords = [];

    # Filter keywords for invalid characters
    $invalid_pattern = '/[^A-Z a-z0-9\-\+\?\[\]\"\$\,\.]/';

    foreach ($orig_keywords as $keyword) {
        $keywords[] = preg_replace($invalid_pattern, "", $keyword);
    }

    $additional_keywords = [];
    $engine              = $car['engine'];

    if (stripos($engine, ' ') > 0) {
        $engine = substr($engine, 0, stripos($engine, ' '));
    }

    if (endsWith($engine, ',')) {
        $engine = substr($engine, 0, strlen($engine) - 1);
    }

    $car['engine'] = $engine;

    if ($directive == 'search') {
        for ($i = 0; $i < count($keywords); $i++) {
			// BMM not allowed now
            // $keywords[$i] = preg_replace('/([\S]+)/', '+${1}', $keywords[$i]);

            if ($car['make'] == 'Mercedes-Benz') {
                $additional_keywords[] = str_replace('-Benz', '', $keywords[$i]);
            }
        }

        // if (startsWith($car['model'], 'Silverado') && $car['model'] != 'Silverado') {
            // $additional_keywords[] = preg_replace('/([\S]+)/', '+${1}', processTextTemplate('[year] [make] Silverado', $car));
        // }

        // if (startsWith($car['model'], 'Ram') && $car['model'] != 'Ram') {
            // $additional_keywords[] = preg_replace('/([\S]+)/', '+${1}', processTextTemplate('[year] [make] Ram', $car));
        // }
    }

    if ($directive == 'display' || $directive == 'combined') {
        $keyword_templates = [
            '[year] [make] [model] [engine]',
            '[year] [make] [model] [body_style]',
            '[year] [make] [model] [body_style] [engine]',
        ];

        foreach ($keyword_templates as $template) {
            $keyword = str_replace("\n", '', processTextTemplate($template, $car, true));

            if ($keyword) {
                $additional_keywords[] = $keyword;
            }
        }
    }

    if ($directive == 'color') {
        $keyword_templates = array(
            "[year] [make] [model] [color]",
            "[make] [model] [color]",
            "[color] [year] [make] [model]",
        );

        foreach ($keyword_templates as $template) {
            $keyword = str_replace("\n", '', processTextTemplate($template, $car, true));

            if ($keyword) {
                $additional_keywords[] = $keyword;
            }

            // for Mercedes-Benz add an additional keyword for just Mercedes
            if ($car['make'] == 'Mercedes-Benz') {
                $additional_keywords[] = str_replace('-Benz', '', $keyword);
            }
        }

        // For color campaigns we need a custom set of keywords
        return $additional_keywords;
    }

    return array_merge($keywords, $additional_keywords);
}
