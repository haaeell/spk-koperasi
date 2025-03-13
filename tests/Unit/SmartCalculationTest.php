<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Koperasi;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use App\Models\Alternatif;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\PenilaianController;
use PHPUnit\Framework\Attributes\Test;

class SmartCalculationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
    }

    #[Test]
    public function it_correctly_calculates_smart_values()
    {
        $koperasi = Koperasi::first();
        $kriteria = Kriteria::first();
        $subKriteria = SubKriteria::where('kriteria_id', $kriteria->id)->first();
        $alternatif = Alternatif::where('koperasi_id', $koperasi->id)->first();

        $this->assertNotNull($koperasi, "Data koperasi tidak ditemukan di database.");
        $this->assertNotNull($kriteria, "Data kriteria tidak ditemukan di database.");
        $this->assertNotNull($subKriteria, "Data sub-kriteria tidak ditemukan di database.");
        $this->assertNotNull($alternatif, "Data alternatif tidak ditemukan di database.");

        $controller = new PenilaianController();
        $result = $this->invokeMethod($controller, 'hitungPerhitungan');

        $this->assertArrayHasKey('nilaiAkhirTotal', $result);
        $this->assertNotEmpty($result['nilaiAkhirTotal']);
        $this->assertGreaterThan(0, $result['nilaiAkhirTotal'][$koperasi->id]);
    }

    #[Test]
    public function it_handles_cost_criteria_correctly()
    {
        $koperasi = Koperasi::first();
        $kriteria = Kriteria::where('jenis', 'cost')->first();
        $subKriteria = SubKriteria::where('kriteria_id', optional($kriteria)->id)->first();
        $alternatif = Alternatif::where('koperasi_id', optional($koperasi)->id)->first();

        $this->assertNotNull($koperasi, "Data koperasi tidak ditemukan di database.");
        $this->assertNotNull($kriteria, "Data kriteria jenis cost tidak ditemukan di database.");
        $this->assertNotNull($subKriteria, "Data sub-kriteria tidak ditemukan di database.");
        $this->assertNotNull($alternatif, "Data alternatif tidak ditemukan di database.");

        $controller = new PenilaianController();
        $result = $this->invokeMethod($controller, 'hitungPerhitungan');

        $this->assertArrayHasKey('nilaiAkhirTotal', $result);
        $this->assertNotEmpty($result['nilaiAkhirTotal']);
    }

    protected function invokeMethod(&$object, $methodName, array $parameters = [])
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
}
