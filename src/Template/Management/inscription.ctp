<section class="large-6">
    <h4>Inscription</h4>
<?php
echo $this->Form->create();
echo $this->Form->input("login");
echo $this->Form->input("password");
echo $this->Form->input("password_checking",array('type'=>'password'));
echo $this->Form->submit();
echo $this->Form->end();
?>
</section>

