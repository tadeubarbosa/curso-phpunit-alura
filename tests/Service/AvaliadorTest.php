<?php

namespace Alura\Leilao\Service;

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Service\Avaliador;

use PHPUnit\Framework\TestCase;


class AvaliadorTest extends TestCase
{

  /**
   * @dataProvider leilaoEmOrdemCrescente
   * @dataProvider leilaoEmOrdemDecrescente
   * @dataProvider leilaoEmOrdemAleatoria
   * @param Leilao $leilao
   * @return void
   */
  public function test_avaliador_deve_encontrar_maior_valor(Leilao $leilao)
  {
    $leiloeiro = new Avaliador();
    $leiloeiro->avalia($leilao);

    $maiorValor = $leiloeiro->getMaiorValor();

    self::assertEquals(2500, $maiorValor);
  }

  /**
   * @dataProvider leilaoEmOrdemCrescente
   * @dataProvider leilaoEmOrdemDecrescente
   * @dataProvider leilaoEmOrdemAleatoria
   * @param Leilao $leilao
   * @return void
   */
  public function test_avaliador_deve_encontrar_menor_valor(Leilao $leilao)
  {
    $leiloeiro = new Avaliador();
    $leiloeiro->avalia($leilao);

    $menorValor = $leiloeiro->getMenorValor();

    self::assertEquals(1700, $menorValor);
  }

  /**
   * @dataProvider leilaoEmOrdemCrescente
   * @dataProvider leilaoEmOrdemDecrescente
   * @dataProvider leilaoEmOrdemAleatoria
   * @param Leilao $leilao
   * @return void
   */
  public function test_avaliador_deve_buscar_tres_maiores_valores(Leilao $leilao)
  {
    $leiloeiro = new Avaliador();
    $leiloeiro->avalia($leilao);

    $maiores = $leiloeiro->getMaioresLances();

    static::assertCount(3, $maiores);
    static::assertEquals(2500, $maiores[0]->getValor());
    static::assertEquals(2000, $maiores[1]->getValor());
    static::assertEquals(1700, $maiores[2]->getValor());
  }

  public function leilaoEmOrdemCrescente()
  {
    $leilao = new Leilao('Fiat 147');

    $maria = new Usuario('Maria');
    $joao = new Usuario('João');
    $ana = new Usuario('Ana');

    $leilao->recebeLance(new Lance($ana, 1700));
    $leilao->recebeLance(new Lance($joao, 2000));
    $leilao->recebeLance(new Lance($maria, 2500));

    return [
      [$leilao]
    ];
  }

  public function leilaoEmOrdemDecrescente()
  {
    $leilao = new Leilao('Fiat 147');

    $maria = new Usuario('Maria');
    $joao = new Usuario('João');
    $ana = new Usuario('Ana');

    $leilao->recebeLance(new Lance($maria, 2500));
    $leilao->recebeLance(new Lance($joao, 2000));
    $leilao->recebeLance(new Lance($ana, 1700));

    return [
      [$leilao]
    ];
  }

  public function leilaoEmOrdemAleatoria()
  {
    $leilao = new Leilao('Fiat 147');

    $maria = new Usuario('Maria');
    $joao = new Usuario('João');
    $ana = new Usuario('Ana');

    $leilao->recebeLance(new Lance($joao, 2000));
    $leilao->recebeLance(new Lance($maria, 2500));
    $leilao->recebeLance(new Lance($ana, 1700));

    return [
      [$leilao]
    ];
  }

}