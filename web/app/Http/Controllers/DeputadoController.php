<?php

namespace App\Http\Controllers;

use App\Model\DeputadoModel;
use Illuminate\Http\JsonResponse;

class DeputadoController extends Controller
{
    /**
     * @var DeputadoModel
     */
    protected $modelDeputado;

    /**
     * DeputadoController constructor.
     */
    public function __construct()
    {
        $this->modelDeputado = new DeputadoModel();
    }

    /**
     * Persiste os dados dos deputados
     *
     * @param $ano
     * @return JsonResponse
     */
    public function inserirDadosDeputados($ano)
    {
        /* Obtem a listagem dos deputados */
        $dtoDepuados = $this->obterDeputados($ano);

        /* Persiste os dados obtidos */
        $this->modelDeputado->insert($dtoDepuados);

        $jsonReturn = array(
            'error' => false,
            'message' => 'success',
            'code' => JsonResponse::HTTP_OK,
            'data' => $dtoDepuados
        );

        return response()->json($jsonReturn);
    }

    /**
     * Busca os dados dos deputados
     *
     * @param $ano
     * @return array
     */
    public function obterDeputados($ano)
    {
        $arrayDeputados = array();
        $dataIni = $ano . '0101';
        $dataFim = $ano . '1231';

        $listaDeputados = $this->requestBuscaDeputados($dataIni, $dataFim);

        foreach ($listaDeputados as $key => $valor) {
            foreach ($valor as $item) {
                $arrayDeputados[] = array(
                    'id_deputado' => $item->id,
                    'nome' => $item->nome,
                );
            }
        }
        return $arrayDeputados;
    }

    /**
     * Efetua o Request no Webservice
     *
     * @param $dataIni
     * @param $dataFim
     * @return mixed
     */
    public function requestBuscaDeputados($dataIni, $dataFim)
    {
        $url = 'http://dadosabertos.almg.gov.br/ws/deputados/proposicoes/sumario?ini=' . $dataIni . '&fim=' . $dataFim . '&formato=json';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $retorno = json_decode(curl_exec($ch));

        if (curl_errno($ch)) {
            $jsonReturn = array(
                'error' => true,
                'message' => curl_error($ch),
                'code' => JsonResponse::HTTP_OK,
                'data' => array()
            );
            return response()->json($jsonReturn);
        }

        curl_close($ch);

        return $retorno;
    }
}
