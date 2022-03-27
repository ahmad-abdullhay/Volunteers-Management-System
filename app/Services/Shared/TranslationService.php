<?php


namespace App\Services\Shared;


class TranslationService
{
    /**
     * Get all translation key of column.
     * @param array $columns
     * @param array $payload
     */
    public function getAllTranslationKey(array $columns, array $payload)
    {
        // Get all locales from app configuration.
        $locales = config('translatable.locales');
        // loop on locales and set values of this locales.
        foreach ($locales as $locale){
            $payload[$locale] = [];
            foreach ($columns as $column){
                // Get src from payload.
                $src = $column . '_' . $locale;
                // Check if value set on payload.
                if (isset($payload[$src])){
                    $payload[$locale][$column] = $payload[$column . '_' . $locale];
                    unset($payload[$src]);
                }
            }
        }
        return $payload;
    }
}
