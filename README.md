Installation
==============================================
### Using Composer (Symfony 2.x, Symfony 3.0.x)

* Run a command
<pre><code>composer require tfox/mpdf-port-bundle
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
<pre><code>public function indexAction()
{
   return new \TFox\MpdfPortBundle\Response\PDFResponse($this->getMpdfService()->generatePdf('Hello World'));
}
</code></pre>

### Generate a variable with PDF content
Sometimes it is necessary to get a variable which content is PDF document.
<pre><code>$myVar = $this->getMpdfService()->generatePdf('Hello World');
</code></pre>

### How to get an instance of \mPDF class
If you would like to work with mPDF class itself, you can use a getMpdf method:
<pre><code>$mpdf = new \Mpdf\Mpdf();</code></pre>

Additional options
==============================================
Additional options might be passed via the second argument:

<pre><code>public function indexAction()
{
    return new \TFox\MpdfPortBundle\Response\PDFResponse($this->getMpdfService()->generatePdf('Hello World', array(
            'format' => 'A4-L' // A4 page, landscape orientation
    )));
}
</code></pre>

Detailed description is available on official manual page: https://mpdf.github.io/

