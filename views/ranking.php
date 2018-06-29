<div class="container">
    <div class="row">
        <div class="col-sm-12">
        <table class="table mt-1">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Nome do pet</th>
                <th scope="col">Pontuação</th>
                </tr>
            </thead>
            <tbody>
            <?php $resultado = $conexao->listarPets(); ?>
                <tr>
                <?php foreach ($resultado as $item) { ?>
                <th scope="row"><?php echo $item["id"]; ?></th>
                <td><?php echo $item["name"]; ?></td>
                <td><?php echo $item["pontos"]; ?></td>
                </tr>
                <?php } ?>
            </tbody>
            </table>
        </div>
    </div>
</div>