<?php

class Cidades_Db extends Erp_Db_Table {

    protected $_name = 'cidades';

    public function verifyToDel($id) {
        $query = $this->select()
                ->setIntegrityCheck(false)
                ->from(array('c' => 'cidades'), array(''))
                ->joinLeft(array('l' => 'lojas'), 'c.id = l.cidade_id', array('childs' => 'COUNT(l.id)'))
                ->group('c.id')
                ->where('c.id = ?', $id);
        $item = $query->query()->fetch();
        if ($item['childs'] > 0):
            return false;
        else:
            return true;
        endif;
    }
}
