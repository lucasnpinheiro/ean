<?php

namespace Lucasnpinheiro\test\Ean;

use InvalidArgumentException;
use Lucasnpinheiro\Ean\EanExtractor;
use PHPUnit\Framework\TestCase;

class EanExtractorTest extends TestCase
{
    /**
     * Teste Unitário: Verifica se o código EAN é extraído corretamente.
     */
    public function testEanCode123456789012(): void
    {
        $eanCode = '123456789012';
        $extractor = new EanExtractor($eanCode);

        // Testa a extração correta do código EAN
        $this->assertEquals('123456789012', $extractor->eanCode());

        // Testa regras específicas do código EAN
        $this->assertFalse($extractor->isScaleProduct());
        $this->assertFalse($extractor->hasInternationalNumber());
        $this->assertFalse($extractor->isCustomCode999());
        $this->assertFalse($extractor->isCustomCode2());
    }

    /**
     * Teste de Integração: Verifica a interação de códigos EAN menores com as funcionalidades.
     */
    public function testEanCode9123456(): void
    {
        $eanCode = '9123456';
        $extractor = new EanExtractor($eanCode);

        // Verifica se o produto é de balança, que envolve uma regra específica de integração
        $this->assertTrue($extractor->isScaleProduct());

        // Outras validações do código EAN
        $this->assertFalse($extractor->hasInternationalNumber());
        $this->assertFalse($extractor->isCustomCode999());
        $this->assertFalse($extractor->isCustomCode2());
    }

    /**
     * Teste de Regressão: Verifica se a mudança no código não afeta o comportamento esperado.
     */
    public function testEanCode1234567(): void
    {
        $eanCode = '1234567';
        $extractor = new EanExtractor($eanCode);

        // Verifica que as regras ainda se aplicam corretamente
        $this->assertFalse($extractor->isScaleProduct());
        $this->assertFalse($extractor->hasInternationalNumber());
        $this->assertFalse($extractor->isCustomCode999());
        $this->assertFalse($extractor->isCustomCode2());
    }

    /**
     * Teste Funcional: Verifica se o código EAN completo gera o comportamento correto.
     */
    public function testEanCode020842098119(): void
    {
        $eanCode = '020842098119';
        $extractor = new EanExtractor($eanCode);

        // Verifica funcionalidades completas sem considerar integração externa
        $this->assertFalse($extractor->isScaleProduct());
        $this->assertFalse($extractor->hasInternationalNumber());
        $this->assertFalse($extractor->isCustomCode999());
        $this->assertFalse($extractor->isCustomCode2());
    }

    /**
     * Teste Unitário com código EAN com 8 dígitos.
     */
    public function testEanCode12345678(): void
    {
        $eanCode = '12345678';
        $extractor = new EanExtractor($eanCode);

        // Testa que o comportamento esperado se mantém para um código menor
        $this->assertFalse($extractor->isScaleProduct());
        $this->assertFalse($extractor->hasInternationalNumber());
        $this->assertFalse($extractor->isCustomCode999());
        $this->assertFalse($extractor->isCustomCode2());
    }

    /**
     * Teste de Aceitação: Valida a regra de customização para códigos que começam com '999'.
     */
    public function testEanCode9991234567890(): void
    {
        $eanCode = '9991234567890';
        $extractor = new EanExtractor($eanCode);

        // Verifica se a regra para código customizado (999) é aplicada corretamente
        $this->assertFalse($extractor->isScaleProduct());
        $this->assertFalse($extractor->hasInternationalNumber());
        $this->assertTrue($extractor->isCustomCode999());
        $this->assertFalse($extractor->isCustomCode2());
    }

    /**
     * Teste de Regressão: Garante que a mudança no código não afete a regra anterior.
     */
    public function testEanCode123456789012Again(): void
    {
        $eanCode = '123456789012';
        $extractor = new EanExtractor($eanCode);

        // Verifica se o código EAN funciona como no teste original
        $this->assertFalse($extractor->isScaleProduct());
        $this->assertFalse($extractor->hasInternationalNumber());
        $this->assertFalse($extractor->isCustomCode999());
        $this->assertFalse($extractor->isCustomCode2());
    }

    /**
     * Teste Funcional com Regras de EAN Customizado (2): Valida a separação correta de código e valor.
     */
    public function testEanCode2018740009892(): void
    {
        $eanCode = '2018740009892';
        $extractor = new EanExtractor($eanCode);

        // Verifica que a regra de código customizado 2 é aplicada
        $this->assertFalse($extractor->isScaleProduct());
        $this->assertFalse($extractor->hasInternationalNumber());
        $this->assertFalse($extractor->isCustomCode999());
        $this->assertTrue($extractor->isCustomCode2());

        // Verifica a extração correta dos valores
        $this->assertEquals('01874', $extractor->code());
        $this->assertEquals('000989', $extractor->value());
    }

    /**
     * Teste Unitário com EAN inválido (número longo).
     */
    public function testEanCode3018740009892(): void
    {
        $eanCode = '3018740009892';
        $extractor = new EanExtractor($eanCode);

        // Testa que não é código customizado
        $this->assertFalse($extractor->isScaleProduct());
        $this->assertFalse($extractor->hasInternationalNumber());
        $this->assertFalse($extractor->isCustomCode999());
        $this->assertFalse($extractor->isCustomCode2());
    }
}