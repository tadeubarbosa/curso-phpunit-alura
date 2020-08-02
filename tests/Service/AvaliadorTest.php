<?php

namespace Alura\Leilao\Service;

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Service\Avaliador;
use DomainException;
use PHPUnit\Framework\TestCase;

class AvaliadorTest extends TestCase
{
  /** @var Avaliador */
  private $avaliador;

  protected function setUp(): void
  {
    $this->avaliador = new Avaliador();
  }

  /**
   * @dataProvider leilaoEmOrdemCrescente
   * @dataProvider leilaoEmOrdemDecrescente
   * @dataProvider leilaoEmOrdemAleatoria
   * @param Leilao $leilao
   * @return void
   */
  public function test_avaliador_deve_encontrar_maior_valor(Leilao $leilao)
  {
    $this->avaliador->avalia($leilao);

    $maiorValor = $this->avaliador->getMaiorValor();

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
    $this->avaliador->avalia($leilao);

    $menorValor = $this->avaliador->getMenorValor();

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
    $this->avaliador->avalia($leilao);

    $maiores = $this->avaliador->getMaioresLances();

    static::assertCount(3, $maiores);
    static::assertEquals(2500, $maiores[0]->getValor());
    static::assertEquals(2000, $maiores[1]->getValor());
    static::assertEquals(1700, $maiores[2]->getValor());
  }

  public function test_leilao_vazio_nao_pode_ser_avaliado()
  {
    $this->expectException(\DomainException::class);
    $this->expectExceptionMessage("Não é possível avaliar um leilão vazio!");

    $leilao = new Leilao('Fusca Azul');
    $this->avaliador->avalia($leilao);
  }

  public function test_leilao_finalizado_nao_pode_ser_avaliado()
  {
    $this->expectException(DomainException::class);
    $this->expectExceptionMessage("Leilão já está finalizado!");

    $leilao = new Leilao('Fiat 147');
    $leilao->recebeLance(new Lance(new Usuario('Ana'), 2000));

    $leilao->finaliza();

    $this->avaliador->avalia($leilao);
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
      'ordem-crescente' => [$leilao]
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
      'ordem-decrescente' => [$leilao]
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
      'ordem-aleatoria' => [$leilao]
    ];
  }

}