<?php

namespace Tests\Feature;

use App\Creator\EPCharacterCreator;
use Tests\TestCase;

class HighLevelCreatorControllerTest extends TestCase
{
    /**
     * Create a new (empty) character to run these tests against
     */
    protected function setUp(): void
    {
        parent::setUp();
        session()->put('cc', new EPCharacterCreator(1000));
    }

    public static function saveProvider(): array
    {
        $dir   = __DIR__ . '/HighLevelCreatorController/saves/';
        $saves = [];
        $saves['save.json'] = [json_decode(file_get_contents(__DIR__ . '/HighLevelCreatorController/save.json'), true)];
        foreach (scandir($dir) as $fileName) {
            $fullName = $dir . $fileName;
            if (is_file($fullName)) {
                $saves[$fileName] = [json_decode(file_get_contents($fullName), true)];
            }
        }
        return $saves;
    }

    public function testSave()
    {
        $response = $this->get('/api/creator/save');
        $response->assertStatus(200);

        $actual = $this->normalizeSavePack(json_decode($response->getContent(), true));
        $expected = $this->normalizeSavePack(json_decode(file_get_contents(__DIR__ . '/HighLevelCreatorController/save.json'), true));

        foreach (['versionName', 'versionNumber', 'versionCommit'] as $key) {
            if (array_key_exists($key, $actual)) {
                $expected[$key] = $actual[$key];
            }
        }

        $this->assertEquals($expected, $actual);
    }

    private function normalizeSavePack($data)
    {
        if (is_string($data) && is_numeric($data)) {
            return $data + 0;
        }

        if (!is_array($data)) {
            return $data;
        }

        $normalized = [];
        foreach ($data as $key => $value) {
            if ($key === 'atomUid') {
                continue;
            }
            if ($key === 'maxValueSoftgearMod' && $value === null) {
                $value = 0;
            }
            $normalized[$key] = $this->normalizeSavePack($value);
        }

        return $normalized;
    }

    public function testGet()
    {
        $this->validateJson('/api/creator/', __DIR__ . '/HighLevelCreatorController/get.json');
    }

    /**
     * Test loading a character from a save file
     * TODO:  Maybe more tests to make sure it succeeded (Perhaps check the values)
     * @dataProvider saveProvider
     */
    public function testUpdate(array $saveJson)
    {
        $response = $this->postJson('/api/creator/load', ['file' => $saveJson, 'creationMode' => true]);
        $response->assertStatus(200);
    }

    public function testValidateCharacter()
    {
        $this->validateJson('/api/creator/validate', __DIR__ . '/HighLevelCreatorController/validate.json');
    }

    /**
     * Test creating a new Character via the API
     * TODO:  Maybe more tests to make sure it succeeded
     * @throws \Exception
     */
    public function testStore()
    {
        $cp = random_int(700, 1500);
        $response = $this->postJson('/api/creator/', ['creationPoints' => $cp]);
        $response->assertStatus(200);
        $this->assertEquals(session()->get('cc')->initialCreationPoints, $cp);
    }
}
