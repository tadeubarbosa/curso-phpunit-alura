<?php

namespace Alura\Leilao\Service;

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Service\Avaliador;

use PHPUnit\Framework\TestCase;


class AvaliadorTest extends TestCase
{

  public function test_avaliador_deve_encontrar_maior_valor_em_ordem_crescente()
  {
    // arrange - given
    // arruma a casa para o teste
    $leilao = new Leilao('Fiat 147');

    $maria = new Usuario('Maria');
    $joao = new Usuario('João');

    $leilao->recebeLance(new Lance($joao, 2000));
    $leilao->recebeLance(new Lance($maria, 2500));

    // act - when
    // executa o teste a ser testada
    $leiloeiro = new Avaliador();
    $leiloeiro->avalia($leilao);

    $maiorValor = $leiloeiro->getMaiorValor();

    self::assertEquals(2500, $maiorValor);
  }

  public function test_avaliador_deve_encontrar_maior_valor_em_ordem_decrescente()
  {
    // arrange - given
    // arruma a casa para o teste
    $leilao = new Leilao('Fiat 147');

    $maria = new Usuario('Maria');
    $joao = new Usuario('João');

    $leilao->recebeLance(new Lance($maria, 2500));
    $leilao->recebeLance(new Lance($joao, 2000));

    // act - when
    // executa o teste a ser testada
    $leiloeiro = new Avaliador();
    $leiloeiro->avalia($leilao);

    $maiorValor = $leiloeiro->getMaiorValor();

    self::assertEquals(2500, $maiorValor);
  }
}