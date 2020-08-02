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

  public function test_avaliador_deve_encontrar_menor_valor_em_ordem_crescente()
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

    $menorValor = $leiloeiro->getMenorValor();

    self::assertEquals(2000, $menorValor);
  }

  public function test_avaliador_deve_encontrar_menor_valor_em_ordem_decrescente()
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

    $menorValor = $leiloeiro->getMenorValor();

    self::assertEquals(2000, $menorValor);
  }

  public function test_avaliador_deve_buscar_tres_maiores_valores()
  {
    $leilao = new Leilao('Fiat 147');

    $joao = new Usuario('Joao');
    $maria = new Usuario('Maria');
    $joana = new Usuario('Joana');
    $jorge = new Usuario('Jorge');

    $leilao->recebeLance(new Lance($joao, 1500));
    $leilao->recebeLance(new Lance($maria, 1000));
    $leilao->recebeLance(new Lance($joana, 2000));
    $leilao->recebeLance(new Lance($jorge, 1700));

    $leiloeiro = new Avaliador();
    $leiloeiro->avalia($leilao);

    $maiores = $leiloeiro->getMaioresLances();

    static::assertCount(3, $maiores);
    static::assertEquals(2000, $maiores[0]->getValor());
    static::assertEquals(1700, $maiores[1]->getValor());
    static::assertEquals(1500, $maiores[2]->getValor());
  }

}