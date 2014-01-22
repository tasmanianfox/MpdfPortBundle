Installation
==============================================
### Using Composer (Symfony 2.1+)

* Add a new line to your `composer.json` file:
<pre><code>"require": {
		...
        
        "tfox/mpdf-port-bundle": "1.2.*"
}
</code></pre>

* Run a command
<pre><code>php composer.phar update
</code></pre>

* Add a new line to `app/AppKernel.php`:
<pre><code>$bundles = array(
  ...
  new TFox\MpdfPortBundle\TFoxMpdfPortBundle(),
)
</code></pre>



### Using deps-file (Symfony 2.0.x)

* Add a new entry to your `deps` file:
<pre><code>[TFoxMpdfPortBundle]
    git=https://github.com/tasmanianfox/MpdfPortBundle.git
    target=/bundles/TFox/MpdfPortBundle 
</code></pre>

* Add a new line to `app/AppKernel.php`:
<pre><code>new TFox\MpdfPortBundle\TFoxMpdfPortBundle(), 
</code></pre>

* Add a new line to `app/autoload.php`:
<pre><code>'TFox' => __DIR__.'/../vendor/bundles',
</code></pre>

* Run a command
<pre><code>php bin/vendors install
</code></pre>

A Quick Start guide
==============================================
### How to create a Response object
This small example creates a PDF document with format A4 and portrait orientation:
<pre><code>$mpdfService = $this->get('tfox.mpdfport');
$html = "<html><head></head><body>Hello World!</body></html>";
$response = $mpdfService->generatePdfResponse($html);
</code></pre>

### Generate a variable with PDF content
Sometimes it is necessary to get a variabe which content is PDF document. Obviously, you might generate a response from the previous example and then call a method:
<pre><code>$response->getContent()
</code></pre>
But there is a shorter way to get a raw content:
<pre><code>$mpdfService = $this->get('tfox.mpdfport');
$html = "<html><head></head><body>Hello World!</body></html>";
$content = $mpdfService->generatePdf($html);
</code></pre>

### How to get an instance of \mPDF class
If you would like to work with mPDF class itself, you can use a getMpdf method:
<pre><code>$mpdfService = $this->get('tfox.mpdfport');
$mPDF = $mpdfService->getMpdf();
</code></pre>



Warning
==============================================
* By default the bundle adds the two attributes 'utf-8' and 'A4' to the mPDF class constructor. To turn off these options, use the `setAddDefaultConstructorArgs` method:
<pre><code>$mpdfService->setAddDefaultConstructorArgs(false);
</code></pre>

* As the bundle inserts the first two arguments to the mPDF constructor by default, additional constructor arguments should start from the 3rd argument (default_font_size).

* If the `setAddDefaultConstructorArgs(false)` method is called, additional arguments for constructor should start from the first one (mode).



Additional arguments
==============================================
As the bundle uses methods of mPDF class, some additional parameters can be added to these methods. There are 3 mPDF methods used in the bundle:
* Constructor. Documentation: http://mpdf1.com/manual/index.php?tid=184
* WriteHTML. Documentation:  http://mpdf1.com/manual/index.php?tid=121
* Output. Documentation:  http://mpdf1.com/manual/index.php?tid=125

To pass additional arguments, an array with arguments should be created:
<pre><code>$arguments = array(
	'constructorArgs' => array(), //Constructor arguments. Numeric array. Don't forget about points 2 and 3 in Warning section!
	'writeHtmlMode' => null, //$mode argument for WriteHTML method
	'writeHtmlInitialise' => null, //$mode argument for WriteHTML method
	'writeHtmlClose' => null, //$close argument for WriteHTML method
	'outputFilename' => null, //$filename argument for Output method
	'outputDest' => null //$dest argument for Output method
);
</code></pre>
It is NOT necessary to have all the keys in array.
This array might be passed to the `generatePdf` and `generatePdfResponse` methods as the second argument:
<pre><code>$mpdfService->generatePdf($html, $arguments);
$mpdfService->generatePdfResponse($html, $arguments);
</code></pre>
