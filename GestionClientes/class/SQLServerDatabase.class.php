<?php

require_once('DataBase.interface.php');

class SQLServerDatabase implements IDataBase {

    
    var $database = "prueba";
    var $host = "localhost";
    var $user = "root";
    var $pass = "";
    
   /*producion
    var $database = "TelemercadeoClaro";
    var $host = "10.32.2.137";   
    var $user = "Telemercadeo";
    var $pass = "T#13Meac#d3o2017*";
*/
    var $conn;
    var $numRows;

    function __construct() {
    
        $this->conectar($this->host, $this->user, $this->pass, $this->database);
        
    }
//    public function conectar($_host, $_user, $_password, $_database) {
//        //echo $_host." , ". $_user." , ". $_password ;
//        $this->conn = mssql_connect($_host, $_user, $_password) or die(mssql_get_last_message());
//        mssql_select_db($this->database, $this->conn) or die(mssql_get_last_message());
//    }
    public function conectar($_host, $_user, $_password, $_database) {
        //echo $_host." , ". $_user." , ". $_password ;
        $this->conn = mysqli_connect($_host, $_user, $_password) or die(mysqli_connect_error());
        mysqli_init($this->conn);
        mysqli_select_db($this->conn,$this->database) or die(mysqli_connect_error());
    }
    
//     function query($sql) {
//        mssql_query('SET ANSI_WARNINGS ON', $this->conn) or die(mssql_get_last_message());
//        mssql_query('SET ANSI_NULLS ON', $this->conn) or die(mssql_get_last_message());
//
//        $result = mssql_query($sql, $this->conn) or die(mssql_get_last_message());
//        $resultados = array();
//        while ($row = mssql_fetch_array($result))
//            $resultados[] = $row;
//        return $resultados;
//    } 
    
    function query($sql) {
//       mysqli_query($this->conn,'SET ANSI_WARNINGS ON') or die(mysqli_connect_error());
//        mysqli_query($this->conn,'SET ANSI_NULLS ON') or die(mysqli_connect_error());

        $result = mysqli_query($this->conn,$sql) or die(mysqli_connect_error());
        
        $resultados = array();
        while ($row = mysqli_fetch_array($result))
            $resultados[] = $row;
        return $resultados;
        
    } 

//    function exportQuery($sql) {
//        mssql_query('SET ANSI_WARNINGS ON', $this->conn) or die(mssql_get_last_message());
//        mssql_query('SET ANSI_NULLS ON', $this->conn) or die(mssql_get_last_message());
//
//        $result = mssql_query($sql, $this->conn) or die(mssql_get_last_message());
//        return $result;
//    }

    function nonReturnQuery($sql) {
        //mssql_query($sql, $this->conn) or die(mssql_get_last_message());
        mysqli_query($sql) or die(mysqli_connect_error());
    }
};
    /**
     * Realiza una consulta en la basa de datos segun parametros
     * 
     * @version 1,0
     * @author Fabio Quintero 2014-01-17
     * @author Ivan Camilo Cano <Co-Author>
     * @param String $tabla Tabla valida de la base de datos
     * @param Array $campos Campos de la tabla para seleccionar
     * @param Array $parametros Default NULL, campos por los cuales se va a filtrar
     * @param Array $operadores Default NULL, operadores  =, !=, >, >=, <, <=, LIKE
     * @param Array $valores Default NULL, valores de busqueda
     * @param Array $operadoresLogico Default NULL, And , Or
     * @param String $orderBy Description Default NULL, cvampo por el cual se av aordenar la consulta
     * @param String $orderMethod Default ASC, Asc, Desc
     * @return Array resultados de la busqueda
     * 
     * @throws Exception
     */
//    function SelectSimple($tabla, $campos, $parametros = null, $operadores = null, $valores = null, $operadoresLogico = null, $orderBy = null, $orderMethod = "ASC") {
//
//        if (empty($tabla) || is_null($tabla))
//            throw new Exception("La tabla no puede ser vacia");
//        $sql = "Select ";
//        $whereStr = "WHERE ";
//
//        if (!is_array($campos) || count($campos) == 0)
//            throw new Exception("Los campos deben ser un arreglo con longitud > 1");
//
//        $sql .= implode(",", $campos) . " FROM $tabla ";
//
//        // if(!is_null($operadoresLogico)&& !is_array($operadoresLogico) || count($operadoresLogico) == 0) throw new Exception ("se espera al menos un ooperador logico");
//
//        if (!is_null($parametros) && !is_null($operadores) && !is_null($valores)) {
//            if ($paramVals = array_combine($parametros, $valores)) {
//
//                //Operador tiene un posicion o tiene la misma cantidad que el paramVals
//                if (count($operadores) == 1) {
//                    $operador = $operadores[0];
//                } else if (count($operadores) != count($paramVals))
//                    throw new Exception("cantidad de parametros con operadores no coincide");
//
//                if ((count($paramVals) > 1)) {
//                    if (count($operadoresLogico) == 0)
//                        throw new Exception("Operadores logicos esperados");
//                    else if (count($operadoresLogico) == 1)
//                        $operadorLogico = $operadoresLogico[0];
//                    else if (!count($operadoresLogico) != (count($paramVals) - 1))
//                        throw new Exception("Operadores logicos debe ser count(paramvals -1");
//                }
//
//                $index = 0;
//                foreach ($paramVals as $parametro => $valor) {
//
//
//                    $whereStr .= isset($operador) ? $parametro . " " . $operador : $parametro . " " . $operadores[$index];
//                    $whereStr .="'" . $valor . "' ";
//                    $whereStr .= isset($operadorLogico) && $index < count($paramVals) - 1 ? $operadorLogico . " " : $operadoresLogico[$index] . " ";
//                    $index++;
//                }
//            }
//            else
//                throw new Exception("No se puede combinar parametros y valores");
//        }
//
//        $sql .= $whereStr;
//        if (!is_null($orderBy))
//            $sql .= " ORDER BY " . $orderBy . " " . $orderMethod;
//
//
//        $result = mssql_query($sql, $this->conn) or die(mssql_get_last_message());
//        $resultados = array();
//        while ($row = mssql_fetch_array($result))
//            array_push($resultados, $row);
//
//        return $resultados;
//    }
//
//    /**
//     * Realiza una consulta en la basa de datos segun parametros y retorna un combo
//     * 
//     * @version 1,0
//     * @author Ivan Camilo Cano
//     * @param String $idCombo Id del combo a crear
//     * @param String $tabla Tabla valida de la base de datos
//     * @param Array $campos Areglo donde recibe en la posicion 0 EL id y en la posicion 1 El nombre o descripcion de la base
//     * @param Array $parametros Default NULL, campos por los cuales se va a filtrar
//     * @param Array $operadores Default NULL, operadores  =, !=, >, >=, <, <=, LIKE
//     * @param Array $valores Default NULL, valores de busqueda
//     * @param Array $operadoresLogico Default NULL, And , Or
//     * @param String $orderBy Description Default NULL, cvampo por el cual se av aordenar la consulta
//     * @param String $orderMethod Default ASC, Asc, Desc
//     * @return Array objeto Html con option y values
//     * 
//     * @throws Exception
//     */
//    function SelectCombo($tabla, $campos, $parametros = null, $operadores = null, $valores = null, $operadoresLogico = null, $orderBy = null, $orderMethod = "ASC") {
//
//        if (empty($tabla) || is_null($tabla))
//            throw new Exception("La tabla no puede ser vacia");
//        $sql = "Select ";
//        $whereStr = "WHERE ";
//
//        if (!is_array($campos) || count($campos) == 0)
//            throw new Exception("Los campos deben ser un arreglo con longitud > 1");
//
//        $sql .= implode(",", $campos) . " FROM $tabla ";
//
//        // if(!is_null($operadoresLogico)&& !is_array($operadoresLogico) || count($operadoresLogico) == 0) throw new Exception ("se espera al menos un ooperador logico");
//
//        if (!is_null($parametros) && !is_null($operadores) && !is_null($valores)) {
//            if ($paramVals = array_combine($parametros, $valores)) {
//
//                //Operador tiene un posicion o tiene la misma cantidad que el paramVals
//                if (count($operadores) == 1) {
//                    $operador = $operadores[0];
//                } else if (count($operadores) != count($paramVals))
//                    throw new Exception("cantidad de parametros con operadores no coincide");
//
//                if ((count($paramVals) > 1)) {
//                    if (count($operadoresLogico) == 0)
//                        throw new Exception("Operadores logicos esperados");
//                    else if (count($operadoresLogico) == 1)
//                        $operadorLogico = $operadoresLogico[0];
//                    else if (!count($operadoresLogico) != (count($paramVals) - 1))
//                        throw new Exception("Operadores logicos debe ser count(paramvals -1");
//                }
//
//                $index = 0;
//                foreach ($paramVals as $parametro => $valor) {
//
//
//                    $whereStr .= isset($operador) ? $parametro . " " . $operador : $parametro . " " . $operadores[$index];
//                    $whereStr .="'" . $valor . "' ";
//                    $whereStr .= isset($operadorLogico) && $index < count($paramVals) - 1 ? $operadorLogico . " " : $operadoresLogico[$index] . " ";
//                    $index++;
//                }
//            }
//            else
//                throw new Exception("No se puede combinar parametros y valores");
//        }
//
//        $sql .= $whereStr;
//        if (!is_null($orderBy))
//            $sql .= " ORDER BY " . $orderBy . " " . $orderMethod;
//
//
//        $result = mssql_query($sql, $this->conn) or die(mssql_get_last_message());
//        $resultados = array();
//        while ($row = mssql_fetch_array($result))
//            array_push($resultados, $row);
//
//
//
//
//
//        $htmlObject .= '<option value="-1">Seleccione...</option>';
//
//        for ($i = 0; $i < count($resultados); $i++)
//            $htmlObject .= '<option value="' . $resultados[$i][$campos[0]] . '">' . utf8_encode($resultados[$i][$campos[1]]) . '</option>';
//
//
//        return $htmlObject;
//    }
//
//    /**
//     * Realiza una insercion simple a una base de datos.
//     * 
//     * Los campos y los valores deben estar en el mismo orden para una insercion exitosa
//     * 
//     * @version 1,0
//     * @author Camilo Cano  <iccano@vyscolombia.com>
//     * @param String $tabla Tabla valida para la insercion
//     * @param Array $campos campos validos apra la insercion de los datos
//     * @param Array $valores valores a insertar
//     * @return True o numero de filas afectadas
//     * @throws Exception
//     */
//    function Insert($tabla, $campos, $valores) {
//
//        $mapCamVal = array_combine($campos, $valores);
//
//        if (empty($tabla) || is_null($tabla))
//            throw new Exception("La tabla no puede ser vacia");
//        if (!is_array($campos) || count($campos) == 0)
//            throw new Exception("Los campos deben ser un arreglo con longitud > 1");
//        if (!is_array($valores) || count($valores) == 0)
//            throw new Exception("Los valores deben ser un arreglo con longitud > 1");
//
//        $sqlCampos = array();
//        $sqlValores = array();
//        foreach ($mapCamVal as $key => $value) {
//
//            if ($value !== "" && $value != null && $value != "null") {
//
//                array_push($sqlCampos, $key);
//                array_push($sqlValores, "'" . escapar($value) . "'");
//            }
//        }
//        $sql = "Insert into $tabla (" . implode(',', $sqlCampos) . ") values (" . implode(',', $sqlValores) . "); SELECT SCOPE_IDENTITY() AS Id";
//          
//        try {
//            $estado = mssql_query(utf8_decode($sql), $this->conn);
//
//            if ($estado === false)
//                throw new Exception(mssql_get_last_message() . " check this: " . $sql);
//        } catch (Exception $e) {
//            throw $e;
//            //die();
//        }
//        if ($estado === true) {
//            return true;
//        } else {
//
//            $estado = mssql_fetch_array($estado);
//
//            return $estado["Id"];
//        }
//    }
//        function Insertar($sql) {
//        $sql = $sql . "; SELECT SCOPE_IDENTITY() AS Id";
//        try {
//            $estado = mssql_query(utf8_decode($sql), $this->conn);
//            if ($estado === false)
//                throw new Exception(mssql_get_last_message() . " check this: " . $sql);
//        } catch (Exception $e) {
//            throw $e;
//        }
//        if ($estado === true) {
//            return true;
//        } else {
//            $estado = mssql_fetch_array($estado);
//            return $estado["Id"];
//        }
//    }
//
//    /**
//     * Realiza una actualizacion simple a una Tabla de base de datos.
//     * 
//     * Los campos y los valores deben estar en el mismo orden para una actualizacion exitosa
//     * 
//     * @version 1,0
//     * @author Camilo Cano  <iccano@vyscolombia.com>
//     * @param String $tabla Tabla valdia para actualizacion de los datos
//     * @param Array $campos Campos validos a actualizar de la tabla
//     * @param Array $valores Valores para actualizar los campos
//     * @param String $condicion Default="" Condicion para actualizacion Ejem: "Documento=123"
//     * @return True Tambien puede retornar numero de filas afectadas
//     * @throws Exception
//     */
//    function Update($tabla, $campos, $valores, $condicion = "") {
//
//        if (empty($tabla) || is_null($tabla))
//            throw new Exception("La tabla no puede ser vacia");
//        if (!is_array($campos) || count($campos) == 0)
//            throw new Exception("Los campos deben ser un arreglo con longitud > 1");
//        if (!is_array($valores) || count($valores) == 0)
//            throw new Exception("Los valores deben ser un arreglo con longitud > 1");
//
//        $mapCamVal = array_combine($campos, $valores);
//        $arraySql = array();
//        $sql = "Update $tabla set ";
//        $where;
//        foreach ($mapCamVal as $key => $value) {
//            
//            array_push($arraySql, "$key='".ereg_replace("'",'"',escapar($value))."'");
//        }
//
//        if ($condicion != "") {
//            $where = "Where $condicion";
//        } else {
//            $where = "";
//        }
//
//        $sql .=implode(",", $arraySql) . " $where";
//      
//        try {
//            $estado = mssql_query(utf8_decode($sql), $this->conn);
//            if (!$estado)
//                throw new Exception(mssql_get_last_message() . " check this: " . $sql);
//        } catch (Exception $e) {
//            throw $e;
//            //die();
//        }
//        if ($estado === true) {
//            return true;
//        } else {
//            return mssql_rows_affected($estado);
//        }
//    }
//    function Inserta($sql) {
//        $sql = $sql . "; SELECT SCOPE_IDENTITY() AS Id";
//        try {
//            $estado = mssql_query(utf8_decode($sql), $this->conn);
//            if ($estado === false)
//                throw new Exception(mssql_get_last_message() . " check this: " . $sql);
//        } catch (Exception $e) {
//            throw $e;
//        }
//        if ($estado === true) {
//            return true;
//        } else {
//            $estado = mssql_fetch_array($estado);
//            return $estado["Id"];
//        }
//    }
//
//}
//function escapar($string) {
//
//    $string = trim($string);
//    //Esta parte se encarga de eliminar cualquier caracter extraño
//    $string = str_replace(
//            array("'"), '', $string
//    );
//    return $string;
//}
?>
