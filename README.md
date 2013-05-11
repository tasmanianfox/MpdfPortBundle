 Installation using Composer
==============================================
1. Add a new line to your composer.json file:

<pre><code>
"require": {
		...
        
        "tfox/mpdf-port-bundle": "1.1.*"
}
</code></pre>

2. Run a command
php composer.phar update

3. Add a new line to app/AppKernel.php:
<pre><code>
$bundles = array(
  ...
  "tfox/mpdf-port-bundle": "1.1.*"
)
</code></pre>

 A Quick Start guide
==============================================

1. How to create a Response object

This small example creates a PDF document with format A4 and portrait orientation:

<pre><code>
$mpdfService = $this->get('tfox.mpdfport');
$html = "<html><head></head><body>Hello World!</body></html>";
$response = $mpdfService->generatePdfResponse($html);
</code></pre>

2. Generate a variable with PDF content
Sometimes it is necessary to get a variabe which content is PDF document. Obviously, you might generate a response from the previous example and then call a method:
<pre><code>
$response->getContent()
</code></pre>
But there is a shorter way to get a raw content:
<pre><code>
$mpdfService = $this->get('tfox.mpdfport');
$html = "<html><head></head><body>Hello World!</body></html>";
$content = $mpdfService->generatePdf($html);
</code></pre>

3. How to get an instance of \mPDF class
If you would like to work with mPDF class itself, you can use a getMpdf method:
<pre><code>
$mpdfService = $this->get('tfox.mpdfport');
$mPDF = $mpdfService->getMpdf();
</code></pre>

Warning
==============================================

1. By default the bundle adds to constructor of mPDF class two attributes 'utf-8' and 'A4'. To turn off these options, use setAddDefaultConstructorArgs method:
<pre><code>
$mpdfService->setAddDefaultConstructorArgs(false);
</code></pre>

2. As the bundle inserts by default the first two arguments to mPDF constructor, additional constructor arguments should start from the 3rd argument (default_font_size).

3. If setAddDefaultConstructorArgs(false) method is called, additional arguments for constructor should start from the first one (mode).

 Additional arguments
==============================================
As the bundle uses methods of mPDF class, some additional parameters can be added to these methods. There are 3 mPDF methods used in the bundle:
1. Constructor. Documentation: http://mpdf1.com/manual/index.php?tid=184
2. WriteHTML. Documentation:  http://mpdf1.com/manual/index.php?tid=121
3. Output. Documentation:  http://mpdf1.com/manual/index.php?tid=125

To pass additional arguments, an array with arguments should be created:
<pre><code>
$arguments = array(
	'constructorArgs' => array(), //Constructor arguments. Numeric array. Don't forget about points 2 and 3 in Warning section!
	'writeHtmlMode' => null, //$mode argument for WriteHTML method
	'writeHtmlInitialise' => null, //$mode argument for WriteHTML method
	'writeHtmlClose' => null, //$close argument for WriteHTML method
	'outputFilename' => null, //$filename argument for Output method
	'outputDest' => null //$dest argument for Output method
);
</code></pre>
It is NOT necessary to have all the keys in array.
This array might be passed to the generatePdf and generatePdfResponse methods as the secund argument:
<pre><code>
$mpdfService->generatePdf($html, $arguments);
$mpdfService->generatePdfResponse($html, $arguments);
</code></pre>
