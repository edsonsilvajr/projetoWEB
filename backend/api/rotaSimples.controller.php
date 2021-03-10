<?php
if (str_contains($metodo, 'POST')) {
    echo 'Cadastrar um feedback...';
} else if (str_contains($metodo, 'GET')) {
    echo 'Lista de feedbacks...';
} else if (str_contains($metodo, 'PUT')) {
    echo 'Atualizar um feedback...';
} else if (str_contains($metodo, 'DELETE')) {
    echo 'Remover um feedback...';
}
