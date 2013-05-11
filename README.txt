 Installation
==============================================
1. Add MpdfPortBundle repository to your deps file:

[MpdfPortBundle]
    git=https://github.com/tasmanianfox/MpdfPortBundle.git
    target=/bundles/TFox/Bundle/MpdfPortBundle

2. Run Vendors install utility in your Symfony2 directory:

php bin/vendors install

3. Register MpdfPortBundle's namespace in /app/autoload.php:

$loader->registerNamespaces(array(
    'TFox'			=> __DIR__.'/../vendor/bundles'
    /*
     * Another declarations here
     */
));

4. Register MpdfPortBundle in /app/AppKernel.php:

public function registerBundles()
    {
        $bundles = array(
               /*
     		* Another declarations here
   	        */
        	new TFox\MpdfPortBundle\MpdfPortBundle()
        );

5. Add a link to bundle in configuration file /app/config/config.yml:
imports:
    #Another declarations here
    - { resource: @MpdfPortBundle/Resources/config/services.yml }


==============================================
How to use
==============================================

To create an instance of mPDF class, call mpdfport service's method getMpdf():

$mpdf = $this->get('mpdfport')->getMpdf();

Further information about mPDF class usage you can find on mPDF's manual page:
http://mpdf1.com/manual/index.php


==============================================
Example
==============================================
Here is a small example of PDF file generation:

    /**
     * Defining action inside some controller
     * @Route("/document.pdf")
     */
    public function pdfAction() {
	//Obtaining an object of mPDF class
    	$mpdf = $this->get('mpdfport')->getMpdf(); 
    	 
        //Declaration of PDF document's contents
    	$html = "<html><head></head><body>Hello World!</body></html>";
	//Writing contents into mPDF object
    	$mpdf->WriteHTML($html, 0);
	//Receiving generated PDF document
    	$content = $mpdf->Output('', 'S');
    	
	/*
         * Generation of response object, assigning content of respone and setting response's MIME-type to PDF
         */
    	$response = new Response();
    	$response->setContent($content);
    	$response->headers->set('Content-Type', 'application/pdf');
    	return $response;
    }
