 Installation
==============================================
*  Add MpdfPortBundle repository to your deps file:

<pre><code>[MpdfPortBundle]
    git=https://github.com/tasmanianfox/MpdfPortBundle.git
    target=/bundles/TFox/Bundle/MpdfPortBundle
</code></pre>

*  Run Vendors install utility in your Symfony2 directory:

<pre><code>php bin/vendors install</code></pre>

*  Register MpdfPortBundle's namespace in /app/autoload.php:

<pre><code>$loader->registerNamespaces(array(
    'TFox'  		=> __DIR__.'/../vendor/bundles'
    /*
     * Another declarations here
     */
));</code></pre>

*  Register MpdfPortBundle in /app/AppKernel.php:

<pre><code>
public function registerBundles()
    {
        $bundles = array(
            /*
         	   * Another declarations here
       	     */
            new TFox\Bundle\MpdfPortBundle\MpdfPortBundle()
        );
    }
</code></pre>

*  Add a link to bundle in configuration file /app/config/config.yml:
<pre><code>
imports:
&nbsp;&nbsp;&nbsp;&nbsp;#Another declarations here
&nbsp;&nbsp;&nbsp;&nbsp;\- { resource: @MpdfPortBundle/Resources/config/services.yml }
</code></pre>

How to use
==============================================

To create an instance of mPDF class, call mpdfport service's method getMPdf():

<pre><code>
$mpdf = $this->get('mpdfport')->getMPdf();
</code></pre>

Further information about mPDF class usage you can find on mPDF's manual page:
http://mpdf1.com/manual/index.php


Example
==============================================
Here is a small example of PDF file generation:
<pre><code>
    /**
     * Defining action inside some controller
     * @Route("/document.pdf")
     */
    public function pdfAction() {
    	//Obtaining an object of mPDF class
    	$mpdf = $this->get('mpdfport')->getMPdf(); 
    	 
     //Declaration of PDF document's contents
    	$html = "&lt;html&gt;&lt;head&gt;&lt;/head&gt;&lt;body&gt;Hello World!&lt;/body&gt;&lt;/html&gt;";
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
</code></pre>