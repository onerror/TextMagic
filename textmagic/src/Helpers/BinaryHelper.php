<?php

namespace App\Helpers;

class BinaryHelper
{
    public const int BYTES_IN_INTEGER = 32;
    public static function generateBitmask(array $selectedOptions): int
    {
        // Initialize a binary string padded to known maximum number of bits
        $binaryString = str_pad('', self::BYTES_IN_INTEGER, '0');  // todo 32 is magic constant represents max bits you want, potgresql integer is 32.
        // I assume no more than 32 variants is shown to the user, it would be not reasonable
        
        for ($i = 1; $i <= self::BYTES_IN_INTEGER; $i++) {
            $alias = 'x' . $i;
            if (in_array($alias, array_map(function ($option) {
                return $option->getAlias();
            }, $selectedOptions))) {
                $binaryString = '1' . substr($binaryString, 0, -1);
            } else {
                $binaryString = '0' . substr($binaryString, 0, -1);
            }
        }
        // Convert the binary string to an integer
        $bitmask = bindec($binaryString);
        return $bitmask;
    }
    
    public static function isBinaryAnswerFitsAnswerFormula(int $answerBinaryMask, string $answerFormula): bool
    {
        $rightAnswerVariants = explode(',',$answerFormula);
        foreach ($rightAnswerVariants as $rightAnswerVariant){
            if ($answerBinaryMask===(int)$rightAnswerVariant){
                return true;
            }
        }
        
        return false;
    }
}