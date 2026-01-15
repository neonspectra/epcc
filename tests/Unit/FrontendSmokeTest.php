<?php

namespace Tests\Unit;

use Tests\TestCase;

class FrontendSmokeTest extends TestCase
{
    public function test_welcome_page_buttons_use_explicit_uikit_targets(): void
    {
        $welcome = file_get_contents(base_path('resources/js/pages/Welcome.vue'));
        $this->assertNotFalse($welcome, 'Unable to read Welcome.vue');

        $this->assertStringContainsString('uk-toggle="target: #new-character-modal"', $welcome);
        $this->assertStringContainsString('uk-toggle="target: #load-modal"', $welcome);
        $this->assertStringContainsString('uk-toggle="target: #settings-modal"', $welcome);
    }

    public function test_main_menu_buttons_use_explicit_uikit_targets(): void
    {
        $mainMenu = file_get_contents(base_path('resources/js/components/MainMenu.vue'));
        $this->assertNotFalse($mainMenu, 'Unable to read MainMenu.vue');

        $this->assertStringContainsString('uk-toggle="target: #load-modal"', $mainMenu);
        $this->assertStringContainsString('uk-toggle="target: #validation-modal"', $mainMenu);
        $this->assertStringContainsString('uk-toggle="target: #new-character-modal"', $mainMenu);
        $this->assertStringContainsString('uk-toggle="target: #settings-modal"', $mainMenu);
    }

    public function test_new_character_modal_imports_axios_and_uses_window_helpers(): void
    {
        $modal = file_get_contents(base_path('resources/js/components/modals/NewCharacterModal.vue'));
        $this->assertNotFalse($modal, 'Unable to read NewCharacterModal.vue');

        $this->assertStringContainsString("import axios from 'axios';", $modal);
        $this->assertStringContainsString('window.startLoading', $modal);
        $this->assertStringContainsString('window.endLoading', $modal);
        $this->assertStringContainsString('axios.post', $modal);
    }

    public function test_load_dialog_imports_axios_and_uses_window_read_json(): void
    {
        $modal = file_get_contents(base_path('resources/js/components/modals/LoadDialog.vue'));
        $this->assertNotFalse($modal, 'Unable to read LoadDialog.vue');

        $this->assertStringContainsString("import axios from 'axios';", $modal);
        $this->assertStringContainsString('window.readJsonFile', $modal);
        $this->assertStringContainsString('window.startLoading', $modal);
        $this->assertStringContainsString('axios.post', $modal);
    }
}
