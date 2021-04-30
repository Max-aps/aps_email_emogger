<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Shopping24\CSSBeautifier\CSSBeautifier;

final class CSSBeautifierTest extends TestCase
{
    /**
     * Check the correct structure of tags.
     *
     * @test
     */
    public function testSimpleTagBeautified()
    {
        self::assertEquals(
            file_get_contents('tests/files/simpleTagBeautified.css'),
            CSSBeautifier::run(file_get_contents('tests/files/simpleTagUglified.css'))
        );
    }

    /**
     * Check the correct intend if @media and @supports are in the game.
     *
     * @test
     */
    public function testThreeIntendCase()
    {
        self::assertEquals(
            file_get_contents('tests/files/threeIntendBeautified.css'),
            CSSBeautifier::run(file_get_contents('tests/files/threeIntendUglified.css'))
        );
    }

    /**
     * Check the repair of a structure with lost semicolons.
     *
     * @test
     */
    public function testAttributesWithoutSemicolons()
    {
        self::assertEquals(
            file_get_contents('tests/files/attributesWithoutSemicolonBeautified.css'),
            CSSBeautifier::run(file_get_contents('tests/files/attributesWithoutSemicolonUglified.css'))
        );
    }

    /**
     * Check that the beautifier don't break a healthy structure.
     *
     * @test
     */
    public function testSimpleTagDoubleBeautified()
    {
        self::assertEquals(
            file_get_contents('tests/files/simpleTagBeautified.css'),
            CSSBeautifier::run(CSSBeautifier::run(file_get_contents('tests/files/simpleTagUglified.css')))
        );
    }

    /**
     * Beautify a complex structure.
     *
     * @test
     */
    public function testComplex()
    {
        self::assertEquals(
            trim(file_get_contents('tests/files/complexBeautified.css')),
            trim(CSSBeautifier::run(file_get_contents('tests/files/complexUglified.css'), false))
        );
    }

    /**
     * Check that the beautifier don't break a complex healthy structure.
     *
     * @test
     */
    public function testComplexDoubleBeautified()
    {
        self::assertEquals(
            trim(file_get_contents('tests/files/complexBeautified.css')),
            trim(CSSBeautifier::run(CSSBeautifier::run(file_get_contents('tests/files/complexUglified.css'), false), false))
        );
    }

    /**
     * Beautify a complex structure.
     *
     * @test
     */
    public function testComplexRepair()
    {
        self::assertEquals(
            trim(file_get_contents('tests/files/complexBeautifiedRepaired.css')),
            trim(CSSBeautifier::run(file_get_contents('tests/files/complexUglified.css')))
        );
    }
}
