<?php

namespace TFox\MpdfPortBundle\Service;

use Symfony\Component\HttpFoundation\Response;

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
	        $allConstructorArgs = array(array_merge(array('utf-8', 'A4'), $allConstructorArgs));
	    }		

        $reflection = new \ReflectionClass('Mpdf\Mpdf');
        $mpdf = $reflection->newInstanceArgs($allConstructorArgs);

        return $mpdf;
    }	     
	
    /**
     * Returns a string which content is a PDF document
     * @param string $html Html content
     * @param array $argOptions Options for the constructor.
     *
     * @return PDF file.
     */
    public function generatePdf($html, array $argOptions = array())
    {
        //Calculate arguments
        $defaultOptions = array(
            'constructorArgs'      => array(),
            'writeHtmlMode'        => null,
            'writeHtmlInitialise'  => null,
            'writeHtmlClose'       => null,
            'outputFilename'       => '',
            'outputDest'           => 'S',
            'mpdf'                 => null
        );                
	
        $options = array_merge($defaultOptions, $argOptions);
        extract($options);

        if (null == $mpdf) {
            $mpdf = $this->getMpdf($constructorArgs);
        }

        //Add arguments to AddHtml function
        $writeHtmlArgs = array($writeHtmlMode, $writeHtmlInitialise, $writeHtmlClose);
        $writeHtmlArgs = array_filter($writeHtmlArgs, function($x) { 
            return !is_null($x); 
        });

        $writeHtmlArgs['html'] = $html;

        @call_user_func_array(array($mpdf, 'WriteHTML'), $writeHtmlArgs);

        //Add arguments to Output function
        $content = $mpdf->Output($outputFilename, $outputDest);
	
        return $content;
    }
	
    /**
     * Generates an instance of Response class with PDF document
     * @param string $html
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
	
   /**
    * Set the defaults argumnets to the constructor.
    * @param $array $val
    */
    public function setAddDefaultConstructorArgs($val)
    {
        $this->addDefaultConstructorArgs = $val;
        
        return $this;
    }
	
   /**
    * Get defaults arguntments.
    */
    public function getAddDefaultConstructorArgs()
    {
	    return $this->addDefaultConstructorArgs;
    }
}
