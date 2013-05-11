<?php
namespace TFox\MpdfPortBundle\Service;

use Symfony\Component\HttpFoundation\Response;
include_once __DIR__.'/../mpdf/mpdf.php';


class MpdfService {
	private $addDefaultConstructorArgs = true;
	
	/**
	 * Get an instance of mPDF class
	 * @param array $constructorArgs arguments for mPDF constror
	 * @return \mPDF
	 */
	public function getMpdf($constructorArgs = array()) 
	{
		$allConstructorArgs = $constructorArgs;
		if($this->getAddDefaultConstructorArgs()) {
			$allConstructorArgs = array_merge($allConstructorArgs, array('utf-8', 'A4'));
		}		

		$reflection = new \ReflectionClass('\mPDF');
		$mpdf = $reflection->newInstanceArgs($allConstructorArgs);
		
		return $mpdf;
	}
	
	/**
	 * Returns a string which content is a PDF document
	 */
	public function generatePdf($html, array $argOptions = array())
	{
		//Calculate arguments
		$defaultOptions = array(
			'constructorArgs' => array(),
			'writeHtmlMode' => null,
			'writeHtmlInitialise' => null,
			'writeHtmlClose' => null,
			'outputFilename' => null,
			'outputDest' => null
		);		
		$options = array_merge($defaultOptions, $argOptions);
		extract($options);
		
		$mpdf = $this->getMpdf($constructorArgs);
		
		//Add argguments to AddHtml function
		$writeHtmlArgs = array($writeHtmlMode, $writeHtmlInitialise, $writeHtmlClose);
		$writeHtmlArgs = array_filter($writeHtmlArgs, function($x) { return !is_null($x); });
		$writeHtmlArgs['html'] = $html;
		
		call_user_func_array(array($mpdf, 'WriteHTML'), $writeHtmlArgs);
		
		//Add arguments to Output function
		$outputArgs = array($outputFilename, $outputDest);
		$outputArgs = array_filter($outputArgs, function($x) { return !is_null($x); });
		$content = call_user_func_array(array($mpdf, 'Output'), $outputArgs);
		
		return $content;
	}
	
	/**
	 * Generates an instance of Response class with PDF document
	 * @param unknown $argContent
	 * @param array $argOptions
	 */
	public function generatePdfResponse($html, array $argOptions = array())
	{
		$response = new Response();		
		$response->headers->set('Content-Type', 'application/pdf');
		
		$content = $this->generatePdf($html, $argOptions);
		$response->setContent($content);
		
		return $response;
	}
	
	//Getters and setters
	
	public function setAddDefaultConstructorArgs($val)
	{
		$this->addDefaultConstructorArgs = $val;
		return $this;
	}
	
	public function getAddDefaultConstructorArgs()
	{
		return $this->addDefaultConstructorArgs;
	}
}