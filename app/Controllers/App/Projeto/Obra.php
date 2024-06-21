<?php

namespace App\Controllers\App\Projeto;

use App\Controllers\BaseController;

use App\Traits\ProjetoTrait;
use Dompdf\Dompdf;
use Dompdf\Options;

class Obra extends BaseController
{
    use ProjetoTrait;
    public function index()
    {
        $data = [
            'card_title' => 'RELAÇÃO DOS PROJETOS',
        ];
        return view('modulo/projeto/obra', $data);
    }

    public function view(string $serial = null)
    {
        $obra = $this->setObra(null, $serial);

        $data = [
            'card_title' => 'GESTÃO DA OBRA: ' . date("Y", strtotime($obra->created_at)) . completeComZero(esc($obra->id), 8),
            'obra' => $obra,
            'locais' => $this->setLocalObra($obra->id),
        ];
        return view('modulo/projeto/obra_view', $data);
    }


    public function view_aprova(string $serial = null)
    {
        $obra = $this->setArrayObra($serial);

        $data = [
            'card_title' => 'GESTÃO DA OBRA: ' . date("Y", strtotime($obra['data'])) . completeComZero(esc($obra['cod_obra']), 8),
            'obra' => $obra
        ];

        return view('modulo/projeto/obra_aprova', $data);
    }

    public function andamento()
    {
        $data = [
            'card_title' => 'RELAÇÃO DAS OBRAS EM ANDAMENTO',
        ];
        return view('modulo/projeto/andamento', $data);
    }

    public function andamento_view(string $serial = null)
    {
        $obra = $this->setObra(null, $serial);

        $data = [
            'card_title' => 'GESTÃO DA OBRA: ' . date("Y", strtotime($obra->created_at)) . completeComZero(esc($obra->id), 8),
            'obra' => $obra,
            'locais' => $this->setLocalObra($obra->id),
        ];
        return view('modulo/projeto/obra_view', $data);
    }

    public function finalizada()
    {
        $data = [
            'card_title' => 'RELAÇÃO DAS OBRAS FINALIZADAS',
        ];
        return view('modulo/projeto/finalizada', $data);
    }

    public function finalizada_view(string $serial = null)
    {
        $obra = $this->setObra(null, $serial);

        $data = [
            'card_title' => 'GESTÃO DA OBRA: ' . date("Y", strtotime($obra->created_at)) . completeComZero(esc($obra->id), 8),
            'obra' => $obra,
            'locais' => $this->setLocalObra($obra->id),
        ];
        return view('modulo/projeto/obra_view', $data);
    }

    public function aprova_pdf(string $serial = null)
    {
        $obra = $this->setArrayObra($serial);

        $data = [
            'card_title' => 'GESTÃO DA OBRA: ' . date("Y", strtotime($obra['data'])) . completeComZero(esc($obra['cod_obra']), 8),
            'obra' => $obra,
            'urlLogo' => site_url('dist/img/' . dadosEmpresa()->emp_icone)
        ];

        $options = new Options();
        $options->set('defaultFont', 'Courier');
        $options->set('isRemoteEnabled', TRUE);
        $options->set('debugKeepTemp', TRUE);
        $options->set('isHtml5ParserEnabled', TRUE);
        $options->set('chroot', '/');

        // $options->set('defaultFont', 'Courier');
        // $options->set('defaultMediaType', 'all');
        // $options->set('isFontSubsettingEnabled', false);
        // $options->set('isPhpEnabled', false);
        // $options->set('default_media_type', true);

        // $dompdf_options = array(
        //     "default_media_type" => 'print', 
        //     "default_paper_size" => 'a4', 
        //     "enable_unicode" => DOMPDF_UNICODE_ENABLED, 
        //     "enable_php" => DOMPDF_ENABLE_PHP, 
        //     "enable_remote" => true, 
        //     "enable_css_float" => true, 
        //     "enable_javascript" => true, 
        //     "enable_html5_parser" => DOMPDF_ENABLE_HTML5PARSER, 
        //     "enable_font_subsetting" => DOMPDF_ENABLE_FONTSUBSETTING);
        // $dompdf = new DOMPDF();

        $dompdf = new Dompdf($options);
        // $dompdf->loadHtml('teste');
        $dompdf->loadHtml(view('modulo/projeto/pdf/projeto_aprova', $data));
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $output = $dompdf->output();

        // file_put_contents('Arquivos/Obras/' . $serial . ".pdf", $output);
        $dompdf->stream('Projeto-' . $serial . '-' . date("Y-m-d") . '.pdf', array("Attachment" => false));

    }

}
