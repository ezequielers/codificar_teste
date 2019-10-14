<?php

namespace App\Http\Controllers;

use App\Model\DeputadoModel;
use App\Model\DespesaModel;
use Illuminate\Http\JsonResponse;

class DespesaController extends Controller
{
    /**
     * @var DespesaModel
     */
    protected $modelDespesa;

    private $mesNomes = array(
        "01" => "Janeiro",
        "02" => "Fevereiro",
        "03" => "Março",
        "04" => "Abril",
        "05" => "Maio",
        "06" => "Junho",
        "07" => "Julho",
        "08" => "Agosto",
        "09" => "Setembro",
        "10" => "Outubro",
        "11" => "Novembro",
        "12" => "Dezembro"
    );

    /**
     * DespesaController constructor.
     */
    public function __construct()
    {
        $this->modelDespesa = new DespesaModel();
    }


    /**
     * Persiste as despesas dos deputados
     *
     * @param $ano
     * @param $mes
     * @return JsonResponse
     */
    public function inserirDespesasDeputados($ano, $mes)
    {
        if ($mes >= 1 && $mes <= 12) {
            /* Obtem a listagem de despesas de cada deputados no mes e ano informado */
            $arrayDespesas = $this->obterDespesasDeputados($ano, $mes);

            /* Persiste a listagem de despsesas */
            $this->modelDespesa->insert($arrayDespesas);

            $jsonReturn = array(
                'error' => false,
                'mensagem' => 'As despesas do mês "' . $this->mesNomes[$mes] . '" foram inseridas.',
                'status' => JsonResponse::HTTP_OK,
                'data' => $arrayDespesas
            );
            return response()->json($jsonReturn);
        }

        $jsonReturn = array(
            'error' => true,
            'mensagem' => 'O mês tem que ser um número entre 1 e 12.',
            'status' => JsonResponse::HTTP_OK,
            'data' => $arrayDespesas
        );

        return response()->json($jsonReturn);
    }

    /**
     * Obtem a lista de despesas dos deputados
     *
     * @param $ano
     * @param $mes
     * @return array
     */
    public function obterDespesasDeputados($ano, $mes)
    {
        ini_set('max_execution_time', 300); //aumenta o tempo de conexão ou alterar no arquivo php.ini max_execution_time
        $arrayDespesas = array();

        $listaDeputados = DeputadoModel::all(); // busca listagem dos deputados

        foreach ($listaDeputados as $deputado) {
            $arrayDespesas[] = array(
                'id_deputado' => $deputado->id_deputado,
                'valor' => collect( $this->requestDespesasDeputados($deputado->id_deputado, $ano, $mes)->list )->sum('valor'),
                'mes' => $mes,
                'ano' => $ano
            );
        }

        return $arrayDespesas;
    }

    /**
     * Efetua o Request no Webservice
     *
     * @param $id
     * @param $ano
     * @param $mes
     * @return mixed
     */
    public function requestDespesasDeputados($id, $ano, $mes)
    {
        $url = 'http://dadosabertos.almg.gov.br/ws/prestacao_contas/verbas_indenizatorias/deputados/' . $id . '/' . $ano . '/' . $mes . '?formato=json';
        $ch = curl_init(); // Inicia a sessão cURL
        curl_setopt($ch, CURLOPT_URL, $url); // Informa a URL onde será enviada a requisição
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Se true retorna o conteúdo em forma de string para uma variável

        $resultado = json_decode(curl_exec($ch)); // Envia a requisição e realiza um json decode

        if (curl_errno($ch)) {
           echo 'error: ' . curl_error($ch);
        }

        curl_close($ch); // Finaliza a sessão

        return $resultado;
    }
}
