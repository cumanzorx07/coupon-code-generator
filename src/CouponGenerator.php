<?php

namespace CouponGenerator;

use Exception;

class CouponGenerator
{
    /* Config parameters */
    /**
     * Number of parts of the code.
     *
     * @var integer
     */
    private int $sections;

    /**
     * Length of each part.
     *
     * @var integer
     */
    private int $sectionLength;

    private string $prefix;


    /**
     * Symbols to use on the random generator
     * @var string
     */
    private string $symbols = '0123456789ABCDEFGHJKLMNPQRSTUVWXY';


    private array $badWords = [
        'SHPX', 'PHAG', 'JNAX', 'JNAT', 'CVFF', 'PBPX', 'FUVG', 'GJNG', 'GVGF', 'SNEG', 'URYY',
        'ZHSS', 'QVPX', 'XABO', 'NEFR', 'FUNT', 'GBFF', 'FYHG', 'GHEQ', 'FYNT', 'PENC', 'CBBC',
        'OHGG', 'SRPX', 'OBBO', 'WVFZ', 'WVMM', 'CUNG', 'TETA', 'PUTA', 'TIT', 'Z0RR'
    ];

    /**
     * Private Constructor.
     *
     * @param int    $sections
     * @param int    $sectionLength
     * @param string $prefix
     */
    private function __construct(int $sections, int $sectionLength, string $prefix = '')
    {
        $this->sections = $sections;
        $this->sectionLength = $sectionLength;
        $this->prefix = $prefix;
    }

    /**
     * Creates an instance of CouponGenerator object
     *
     * @param int    $sections
     * @param int    $sectionLength
     * @param string $prefix
     *
     * @return CouponGenerator
     */
    static function getInstance(int $sections = 4, int $sectionLength = 5, string $prefix = ''): CouponGenerator
    {
        return new self($sections, $sectionLength, $prefix);
    }


    /**
     * You can change the symbols to use at the coupons code generation process
     *
     * @param string $symbolSet
     *
     * @return $this
     */
    public function setSymbols(string $symbolSet): CouponGenerator
    {
        if(!empty($symbolSet))
        {
            $this->symbols = $symbolSet;
        }

        return $this;
    }

    /**
     * Generates a code, unique for your coupon
     * @return string
     * @throws Exception
     */
    public function generateCode(): string
    {
        $results = empty($this->prefix) ? [] : [$this->prefix];
        $plaintext = $this->generateRandomString($this->sectionLength * $this->sections, $this->symbols);

        for($part = 0; $part < $this->sections;)
        {
            $currentPart = substr($plaintext, $part * $this->sectionLength, $this->sectionLength);
            if (!$currentPart || strlen($currentPart) !== $this->sectionLength) {
                throw new Exception('Unable to generate code, random string is too small');
            }
            if($this->isBadWordPresent($currentPart))
            {
                continue;
            }
            $part++;
            $results[] = $currentPart;
        }

        return implode('-', $results);
    }

    /**
     * Generates a random string based on current symbols and the sum of elements required
     *
     * @param int    $length
     * @param string $symbols
     *
     * @return string
     * @throws Exception
     */
    private function generateRandomString(int $length, string $symbols): string {
        $pieces = [];
        $max = mb_strlen($symbols, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $pieces [] = $symbols[random_int(0, $max)];
        }
        return implode('', $pieces);
    }

    /**
     * Verifies if bad word is present using ROT13 array.
     *
     * @param string $sectionToCheck
     *
     * @return bool
     */
    private function isBadWordPresent(string $sectionToCheck): bool
    {
        foreach ($this->badWords as $badWordToCheck)
        {
            $pos = stripos($sectionToCheck, $badWordToCheck);
            if ($pos !== false) {
                return true;
            }
        }
        return false;
    }
}