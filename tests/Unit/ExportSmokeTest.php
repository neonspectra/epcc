<?php

namespace Tests\Unit;

use App\Creator\EPCharacterCreator;
use App\Creator\Exporters\pdfExporterV2_fpdf;
use Tests\TestCase;

class ExportSmokeTest extends TestCase
{
    public function test_pdf_export_returns_pdf_bytes(): void
    {
        session()->put('cc', new EPCharacterCreator(1000));

        ob_start();
        $exporter = new pdfExporterV2_fpdf();
        $result = $exporter->export();
        $output = ob_get_clean();

        $this->assertTrue($result);
        $this->assertNotEmpty($output);
        $this->assertStringStartsWith('%PDF-', $output);
    }

    public function test_txt_export_returns_plain_text(): void
    {
        session()->put('cc', new EPCharacterCreator(1000));

        ob_start();
        include app_path('Creator/Exporters/txtExporter.php');
        $output = ob_get_clean();

        $this->assertNotEmpty($output);
        $this->assertStringContainsString('EGO', $output);
        $this->assertStringContainsString('Aptitudes', $output);
    }
}
