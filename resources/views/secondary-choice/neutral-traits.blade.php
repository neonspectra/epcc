<?php
declare(strict_types=1);

use App\Creator\DisplayHelpers\Helpers;

?>
<ul class="mainlist" id="postraits">
    <?php
        $currentTraits = creator()->getCurrentTraits();
        $defaultTraits = creator()->getCurrentDefaultEgoTraits();
         foreach(EpDatabase()->getTraits() as $m){
            if($m->isNeutral() && $m->isEgo()) {
                echo Helpers::getDynamicTraitLi($m,$currentTraits,$defaultTraits,'neuTrait','addSelNeuTrait');
            }
         }
    ?>
</ul>









