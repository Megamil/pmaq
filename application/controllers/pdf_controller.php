<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class pdf_controller extends CI_Controller {

	public function impressao_relatorio_total_subdimensao(){


		$dados = array (

			'pack' => $this->model_perguntas->relatorio_subdimensoes($this->uri->segment(3)),

		);
		
		$this->load->view('telas/relatorios/impressao_relatorio_total_subdimensao.php',$dados);


	}

		public function impressao_relatorio_total_subdimensao_resumo(){


		$dados = array (

			'pack' => $this->model_perguntas->relatorio_subdimensoes($this->uri->segment(3)),

		);
		
		$this->load->view('telas/relatorios/impressao_relatorio_total_subdimensao_resumo.php',$dados);


	}

		public function exportar()
	{

		$this->load->model("Model_Excel");
		$sql = $this->Model_Excel->exportar($this->uri->segment(3));

		// Instanciamos a classe
		$PHPExcel = new PHPExcel();

		// Definimos o estilo da fonte
		$PHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

		// Criamos as colunas
		$PHPExcel->setActiveSheetIndex(0)
		            ->setCellValue('A1', 'Nome da unidade' )
		            ->setCellValue('B1', "Dimensão" )
		            ->setCellValue("C1", "Subdimensao" )
		            ->setCellValue("D1", "Pergunta" )
		            ->setCellValue("E1", "Resposta" )
		            ->setCellValue("F1", "Responsavel" )
		            ->setCellValue("G1", "Total SUB" );

		// Podemos configurar diferentes larguras paras as colunas como padrão
		$PHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);

		$linha = 2;
		$coluna = 0;
		$valor = 0;
		$perguntas = 0;
		$sub = 0;

		foreach ($sql->result() as $unidade) {

			if($sub != 0 && $sub != $unidade->cod_subdimensao){

				$PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, ($linha-1),(($valor / ($perguntas*100))*100));

				$sub = $unidade->cod_subdimensao;
				$valor = 0;
				$perguntas = 0;

			} else {

				$sub = $unidade->cod_subdimensao;

			}


			$PHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $unidade->nome_unidade);
			$PHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $unidade->dimensao);
			$PHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $unidade->subdimensao);
			$PHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $unidade->pergunta);
			$PHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $unidade->resposta);
			$PHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $unidade->responsavel);

			$valor = $valor + $unidade->valor;

			$perguntas++;
			$coluna = 0;
			$linha++;

		}

		$PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, ($linha-1),(($valor / ($perguntas*100))*100));

		// Podemos renomear o nome das planilha atual, lembrando que um único arquivo pode ter várias planilhas
		$PHPExcel->getActiveSheet()->setTitle('Unidades');

		// Cabeçalho do arquivo para ele baixar
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Export_unidade_id_'.$this->uri->segment(3).'.xls"');
		header('Cache-Control: max-age=0');
		// Se for o IE9, isso talvez seja necessário
		header('Cache-Control: max-age=1');

		// Acessamos o 'Writer' para poder salvar o arquivo
		$objWriter = PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel5');

		// Salva diretamente no output, poderíamos mudar arqui para um nome de arquivo em um diretório ,caso não quisessemos jogar na tela
		$objWriter->save('php://output'); 

		exit;

	}


}