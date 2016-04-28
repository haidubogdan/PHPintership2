<?php ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<?php foreach ($this->json_scripts as $jsons): ?> 
<script src="public/Js/<?=$jsons?>"></script>
<?php endforeach;?>
</body>

</html>