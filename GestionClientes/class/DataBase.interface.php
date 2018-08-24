<?php
    interface IDataBase
    {
        public function conectar($_host, $_user, $_password, $_database);
        public function query($sql);
        public function nonReturnQuery($sql);
            //public function desconectar();
    }
?>