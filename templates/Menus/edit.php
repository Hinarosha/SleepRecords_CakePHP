<div class="menus form content">
    <?= $this->Form->create($menu) ?>
    <fieldset>
        <legend><?= __('Modifier le Menu') ?></legend>
        <?php
            echo $this->Form->control('ordre', ['type' => 'number']);
            echo $this->Form->control('required_permission', [
                'type' => 'number',
                'label' => 'Permission minimale requise (0 = normal, 2 = admin)',
                'min' => 0,
                'max' => 2,
            ]);
            echo $this->Form->control('intitule');
            echo $this->Form->control('lien');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Enregistrer')) ?>
    <?= $this->Form->end() ?>
</div> 