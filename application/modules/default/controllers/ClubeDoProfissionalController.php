<?php

class Default_ClubeDoProfissionalController extends Default_Controller_Action {

    public function indexAction() {

    }

    public function cursoAction() {
        $slug = $this->_getParam('slug');
        $CursosModel = new Cursos_Model();
        $curso = $CursosModel->getBySlug($slug);
        $this->view->curso = $curso;
    }

    public function cursosAction() {
        $CidadesModel = new Cidades_Model();
        $cidades = $CidadesModel->buscaComCurso();
        $this->view->cidades = $cidades;
    }

    public function listacursoAction() {
        $slug = $this->_getParam('slug');
        $CursosModel = new Cursos_Model();
        $cursos = $CursosModel->buscaPorCidade($slug);
        if (!empty($cursos)):
            ?>
            <table class="table-formulario" id="cursos">
                <thead>
                    <tr>
                        <th>Curso</th>
                        <th>Local</th>
                        <th>Data</th>
                        <th>Vagas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($cursos AS $curso):
                        $curso = $CursosModel->adjustToView($curso);
                        ?>
                        <tr>
                            <td><a href="/clube-do-profissional/curso/<?php echo $curso['slug']; ?>"><?php echo $curso['nome']; ?> [+]</a></td>
                            <td><?php echo $curso['local']; ?><br /><?php echo $curso['cidade']; ?></td>
                            <td><?php echo $curso['data']; ?></td>
                            <td><?php echo $curso['vagas']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php
        endif;
        exit();
    }

}
