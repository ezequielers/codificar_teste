<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServicoRequest;
use App\Model\DeputadoModel;
use App\Model\DespesaModel;
use App\Model\RedeModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServicosController extends Controller
{

    /**
     * @var DespesaModel
     */
    protected $despesaModel;

    /**
     * @var DeputadoModel
     */
    protected $deputadoModel;

    /**
     * @var RedeModel
     */
    protected $redeModel;

    /**
     * ServicosController constructor.
     */
    public function __construct()
    {
        $this->despesaModel = new DespesaModel();
        $this->deputadoModel = new DeputadoModel();
        $this->redeModel = new RedeModel();
    }

    /**
     * Retorna os dados da pesquisa
     *
     * @param ServicoRequest $request
     * @return JsonResponse
     */
    public function listaDeputadosDespesas(ServicoRequest $request)
    {
        if ($request->mes >= 1 && $request->mes <= 12) {

            /* busca a lista com os dados das despesas dos deputados */
            $resultado = $this->buscaDespesasDeputados($request->mes, $request->ano, $request->limit);

            return response()->json(array(
                'mensagem' => 'Dados listados com sucesso',
                'status' => JsonResponse::HTTP_OK,
                'data' => $resultado
            ));
        }

        return response()->json(array('mensagem' => 'O mês informado não é valido! Favor informa um numero referente ao mês entre 1 a 12', 'status' => 'error'));
    }


    /**
     * Lista as despesas dos deputados do mes a ser pesquisado
     *
     * @param $mes
     * @param $limit
     * @return mixed
     */
    public function buscaDespesasDeputados($mes, $ano, $limit)
    {
        return $this->deputadoModel
                ->select(
                    'deputado.id_deputado as id',
                    'deputado.nome as nome',
                    DB::raw('FORMAT(despesa.valor, 2) as valor'),
                    DB::raw('(CASE despesa.mes
                                   WHEN 1  THEN "Janeiro"
                                   WHEN 2  THEN "Fevereiro"
                                   WHEN 3  THEN "Março"
                                   WHEN 4  THEN "Abril"
                                   WHEN 5  THEN "Maio"
                                   WHEN 6  THEN "Junho"
                                   WHEN 7  THEN "Julho"
                                   WHEN 8  THEN "Agosto"
                                   WHEN 9  THEN "Setembro"
                                   WHEN 10 THEN "Outubro"
                                   WHEN 11 THEN "Novembro"
                                   WHEN 12 THEN "Dezembro"
                                   END)  as mes ')
                )
                ->join('despesa', 'despesa.id_deputado', '=', 'deputado.id_deputado')
                ->where('despesa.mes', '=', $mes)
                ->where('despesa.ano', '=', $ano)
                ->limit($limit)
                ->orderBy('despesa.valor', 'DESC')
                ->get();
    }


    /**
     * Lista todas as despesas detalhadas durante o mes e ano a ser pesquisado
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function buscaTodasDespesasDetalhadas()
    {
        return $this->deputadoModel->with('despesas')->get();
    }

    /**
     * Retorna os dados da pesquisa
     *
     * @param ServicoRequest $request
     * @return JsonResponse
     */
    public function listaRedes()
    {
        $listaRedes = $this->redeModel
            ->select('nome', DB::raw('count(*) as total'))
            ->groupBy('nome')
            ->get();

        $jsonReturn = array(
            'error' => false,
            'mensagem' => 'success',
            'status' => JsonResponse::HTTP_OK,
            'data' => $listaRedes->sortByDesc('total')->values()->all()
        );
        return response()->json($jsonReturn);
    }
}
