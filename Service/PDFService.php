<?php

namespace TFox\MpdfPortBundle\Service;

use Mpdf\Mpdf;
use Mpdf\Output\Destination;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PDFService {

    /**
     * @var string
     */
    private $cacheDir;

    /**
     * MpdfService constructor.
     * @param string $cacheDir
     */
    public function __construct(string $cacheDir)
    {
        $this->cacheDir = $cacheDir;
    }

    /**
     * @param string $html
     * @param array $options
     * @return string
     * @throws \Mpdf\MpdfException
     */
    public function generatePdf($html, $options = array())
    {
        $resolver = new OptionsResolver();
        $resolver
            ->setDefined(array_keys($options))
            ->setDefaults(array(
                'mode' => 'utf-8',
                'format' => 'A4',
                'tempDir' => $this->cacheDir
            ));
        $options = $resolver->resolve($options);
        $mpdf = new Mpdf($options);
        $mpdf->WriteHTML($html);

        return $mpdf->Output(null, Destination::STRING_RETURN);
    }
}
