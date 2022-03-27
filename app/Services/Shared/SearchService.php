<?php

namespace App\Services\Shared;

use NlpTools\Tokenizers\WhitespaceAndPunctuationTokenizer;

class SearchService
{
    private function stripPunctuation($string): string
    {
        $string = strtolower($string);
        $string = preg_replace(   '/[[:punct:]]/'   ," ", $string);
        return trim($string);
    }

    public function convertToSeparatedTokens($string): string
    {
        $string = $this->stripPunctuation($string);
        $tokenizer = new WhitespaceAndPunctuationTokenizer();
        $tokens = $tokenizer->tokenize($string);
        array_walk($tokens, function(&$value) {
            if($value) {
                $value = $value . '*';
            }
        });
        return implode(' ', $tokens);
    }
}
