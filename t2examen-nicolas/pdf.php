<?php
require('/var/www/html/github/servidorphp/fpdf/fpdf.php');

class PDF extends FPDF
{
    protected $B = 0;
    protected $I = 0;
    protected $U = 0;
    protected $HREF = '';

    function WriteHTML($html)
    {
        // Intérprete de HTML
        $html = str_replace("\n", ' ', $html);
        $a = preg_split('/<(.*)>/U', $html, -1, PREG_SPLIT_DELIM_CAPTURE);
        foreach ($a as $i => $e) {
            if ($i % 2 == 0) {
                // Text
                if ($this->HREF)
                    $this->PutLink($this->HREF, $e);
                else
                    $this->Write(5, $e);
            } else {
                // Etiqueta
                if ($e[0] == '/')
                    $this->CloseTag(strtoupper(substr($e, 1)));
                else {
                    // Extraer atributos
                    $a2 = explode(' ', $e);
                    $tag = strtoupper(array_shift($a2));
                    $attr = array();
                    foreach ($a2 as $v) {
                        if (preg_match('/([^=]*)=["\']?([^"\']*)/', $v, $a3))
                            $attr[strtoupper($a3[1])] = $a3[2];
                    }
                    $this->OpenTag($tag, $attr);
                }
            }
        }
    }

    function OpenTag($tag, $attr)
    {
        // Etiqueta de apertura
        if ($tag == 'B' || $tag == 'I' || $tag == 'U')
            $this->SetStyle($tag, true);
        if ($tag == 'A')
            $this->HREF = $attr['HREF'];
        if ($tag == 'BR')
            $this->Ln(5);
    }

    function CloseTag($tag)
    {
        // Etiqueta de cierre
        if ($tag == 'B' || $tag == 'I' || $tag == 'U')
            $this->SetStyle($tag, false);
        if ($tag == 'A')
            $this->HREF = '';
    }

    function SetStyle($tag, $enable)
    {
        // Modificar estilo y escoger la fuente correspondiente
        $this->$tag += ($enable ? 1 : -1);
        $style = '';
        foreach (array('B', 'I', 'U') as $s) {
            if ($this->$s > 0)
                $style .= $s;
        }
        $this->SetFont('', $style);
    }

    function PutLink($URL, $txt)
    {
        // Escribir un hiper-enlace
        $this->SetTextColor(0, 0, 255);
        $this->SetStyle('U', true);
        $this->Write(5, $txt, $URL);
        $this->SetStyle('U', false);
        $this->SetTextColor(0);
    }
}


$pdf = new PDF();

// Agregar una página al documento
$pdf->AddPage();

// Establecer la fuente y el tamaño del texto
$pdf->SetFont('Arial', 'B', 16);

// Agregar un título
$pdf->Cell(0, 10, 'Ejemplo de Documento PDF', 0, 1, 'C');

// Agregar un párrafo de texto
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Este es un ejemplo de cómo crear un documento PDF utilizando FPDF en PHP.', 0, 1);

// Agregar una imagen
$pdf->Image('logo.png', 10, 50, 100);

// Establecer los márgenes
$pdf->SetMargins(20, 20, 20);

// Establecer el color del texto
$pdf->SetTextColor(255, 0, 0);

// Agregar más texto
$pdf->Ln(10); // Salto de línea
$pdf->Write(5, 'Este es otro párrafo de texto en rojo.');

//crear una tabla
$pdf->Cell(30, 10, "texto", 1, 0, 'C', true);
$pdf->Cell(30, 10, "texto", 1, 0, 'C', true);
$pdf->Cell(30, 10, "texto", 1, 0, 'C', true);
$pdf->Cell(30, 10, "texto", 1, 0, 'C', true);


// Guardar el documento PDF
//ruta
$archivo_pdf = '/var/www/html/github/servidorphp/jabones/temporal/' . uniqid('pdf_') . '.pdf';
//guardar
$pdf->Output('F', $archivo_pdf);

echo 'Documento PDF generado exitosamente.';

?>