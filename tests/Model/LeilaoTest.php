<?php

namespace Alura\Leilao\Tests\Model;

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use PHPUnit\Framework\TestCase;

class LeilaoTest extends TestCase
{
  /**
   * @dataProvider geraLances
   * @param integer $qtdLances
   * @param Leilao $leilao
   * @param array $valores
   * @return void
   */
  public function testLeilaoDeveReceberLances(
    int $qtdLances,
    Leilao $leilao,
    array $valores
  ) {
    static::assertCount($qtdLances, $leilao->getLances());

    foreach ($valores as $index => $valorEsperado) {
      static::assertEquals($valorEsperado, $leilao->getLances()[$index]->getValor());
    }
  }

  public function testLeilaoNaoDeveReceberLancesRepetidos()
  {
    $leilao = new Leilao('Variante');
    $ana = new Usuario('Ana');

    $leilao->recebeLance(new Lance($ana, 1000));
    $leilao->recebeLance(new Lance($ana, 1500));

    static::assertCount(1, $leilao->getLances());
    static::assertEquals(1000, $leilao->getLances()[0]->getValor());
  }

  public function geraLances()
  {
    $joao = new Usuario('Joao');
    $maria = new Usuario('Maria');

    $leilaoComDoisLances = new Leilao('Fiat 147');
    $leilaoComDoisLances->recebeLance(new Lance($joao, 1000));
    $leilaoComDoisLances->recebeLance(new Lance($maria, 2000));

    $leilaoComUmLance = new Leilao('Fusca 1972');
    $leilaoComUmLance->recebeLance(new Lance($maria, 5000));

    return [
      '2-lances' => [2, $leilaoComDoisLances, [1000, 2000]],
      '1-lance' => [1, $leilaoComUmLance,    [5000]]
    ];
  }
}