<?php

namespace App\Http\Controllers;

use App\Model\DeputadoModel;
use App\Model\RedeModel;
use Illuminate\Http\JsonResponse;

class RedesController extends Controller
{
    /**
     * @var RedeModel
     */
    protected $modelRede;

    /**
     * RedesController constructor.
     */
    public function __construct()
    {
        $this->modelRede = new RedeModel();
    }


    /**
     * Persiste as redes mais utilizadas pelos deputados
     *
     * @param $ano
     * @param $mes
     * @return JsonResponse
     */
    public function inserirRedesDeputados()
    {
        // $ret = $this->requestRedesDeputados();
        // print_r($ret); die;
        /* Obtem a listagem da redes mais utilizadas de cada deputados no mes e ano informado */
        $resultado = $this->requestRedesDeputados();

        $arrayRedes = array();

        /* Persiste a listagem de redes */
        foreach ($resultado->list as $contatos) {
          $id_deputado = $contatos->id;
          foreach ($contatos->redesSociais as $redes) {
            $arrayRedes[] = array(
                'id_rede' => $redes->redeSocial->id,
                'id_deputado' => $id_deputado,
                'nome' => $redes->redeSocial->nome,
                'url' => $redes->url
            );
          }
        }
        $this->modelRede->insert($arrayRedes);

        $jsonReturn = array(
            'error' => false,
            'mensagem' => 'As redes foram inseridas.',
            'status' => JsonResponse::HTTP_OK,
            'data' => $arrayRedes
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
    public function obterRedesDeputados($ano, $mes)
    {
        ini_set('max_execution_time', 300); //aumenta o tempo de conexão ou alterar no arquivo php.ini max_execution_time
        $arrayRedes = array();

        $listaDeputados = DeputadoModel::all(); // busca listagem dos deputados

        foreach ($listaDeputados as $deputado) {
            $arrayRedes[] = array(
                'id_deputado' => $deputado->id_deputado,
                // 'valor' => collect( $this->requestDespesasDeputados($deputado->id_deputado, $ano, $mes)->list )->sum('valor'),
                'mes' => $mes,
                'ano' => $ano
            );
        }

        return $arrayRedes;
    }

    /**
     * Efetua o Request no Webservice
     *
     * @param $id
     * @param $ano
     * @param $mes
     * @return mixed
     */
    public function requestRedesDeputados()
    {
        $url = 'http://dadosabertos.almg.gov.br/ws/deputados/lista_telefonica?formato=json';
        $ch = curl_init(); // Inicia a sessão cURL
        curl_setopt($ch, CURLOPT_URL, $url); // Informa a URL onde será enviada a requisição
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Se true retorna o conteúdo em forma de string para uma variável

        $resultado = json_decode(curl_exec($ch)); // Envia a requisição e realiza um json decode
        // print_r($resultado->list); die;

        if (curl_errno($ch)) {
           echo 'error: ' . curl_error($ch);
        }

        curl_close($ch); // Finaliza a sessão

        return $resultado;
    }
}
