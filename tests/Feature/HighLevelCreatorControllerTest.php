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

    public function testSave(): void
    {
        $response = $this->get('/api/creator/save');
        $response->assertStatus(200);

        $actual = $this->normalizeSavePack(json_decode($response->getContent(), true));
        $expected = $this->normalizeSavePack(json_decode(file_get_contents(__DIR__ . '/HighLevelCreatorController/save.json'), true));

        $this->assertEquals($expected, $actual);
        $this->assertSame('Argonaut', $actual['versionName']);
        $this->assertSame(2.02, $actual['versionNumber']);
        $this->assertSame('na', $actual['versionCommit']);
    }

    public function testNightlyDisplayMetadataDoesNotLeakIntoSaveMetadata(): void
    {
        config([
            'epcc.versionName' => 'Argonaut',
            'epcc.versionNumber' => 2.02,
            'epcc.buildCommit' => '0123456789abcdef',
            'epcc.displayVersionName' => 'nightly',
            'epcc.displayVersion' => 'fedcba9876543210',
            'epcc.displayCommit' => 'fedcba9876543210',
        ]);

        $this->get('/api/version')
            ->assertOk()
            ->assertJsonPath('versionName', 'nightly')
            ->assertJsonPath('version', 'fedcba9876543210')
            ->assertJsonPath('commit', 'fedcba9876543210');

        $this->get('/api/creator/save')
            ->assertOk()
            ->assertJsonPath('versionName', 'Argonaut')
            ->assertJsonPath('versionNumber', 2.02)
            ->assertJsonPath('versionCommit', '0123456789abcdef');
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
    public function testUpdate(array $saveJson): void
    {
        $response = $this->postJson('/api/creator/load', ['file' => $saveJson, 'creationMode' => true]);

        $response
            ->assertOk()
            ->assertJson(['Success' => true])
            ->assertJsonMissing(['Errors' => ['Incompatible file version!']]);
        $this->assertInstanceOf(EPCharacterCreator::class, session()->get('cc'));
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
