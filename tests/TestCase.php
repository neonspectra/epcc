<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\TestResponse;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();
        $this->ensureTestDatabase();
    }

    /**
     * Test that the response is good, and exactly matches the json in a file
     *
     * @param string $uri
     * @param string $jsonFile
     * @return TestResponse
     */
    function validateJson(string $uri, string $jsonFile)
    {
        $response = $this->get($uri);
        $response->assertStatus(200);
        $response->assertJson(json_decode(file_get_contents($jsonFile), true));
        return $response;
    }

    private function ensureTestDatabase(): void
    {
        $dbPath = base_path('database/database.sqlite');
        if (file_exists($dbPath)) {
            return;
        }

        if (!is_dir(dirname($dbPath))) {
            mkdir(dirname($dbPath), 0777, true);
        }

        touch($dbPath);
        $sql = file_get_contents(base_path('database/database.sql'));
        $sql = str_replace("\\n", " ", $sql);

        $pdo = new \PDO('sqlite:' . $dbPath);
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $pdo->exec($sql);
    }
}
