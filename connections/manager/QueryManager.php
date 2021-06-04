<?php

class QueryManager
{
    private static $id;
    private static $data;
    private static $table;
    private static $Conn;
    private static $dbc;
    private static $sql;
    private static $fields = '';
    private static $values = '';
    private static $new_value;
    private static $value_array = [];
    private static $response;
    private static $lid;
    private static $params;
    private static $openquery;
    private static $sanitize;

    public static function insert($table,$data,$Conn=null)
    {
        self::$data  = $data;
        self::$table = $table;
        self::$Conn  = $Conn;

        if(count($data) > 1){
            foreach(self::$data as $key=>$value){
                self::$fields .= $key.',';
                self::$values .= $value.",~|~";
            }

            self::$fields = substr(self::$fields,0,-1);
            self::$values = substr(self::$values,0,-4);
            self::$values = explode(',~|~',self::$values);
            
            foreach(self::$values as $value_string){
                $value_string = str_replace($value_string,'?',$value_string);
                array_push(self::$value_array,$value_string);
            }
            self::$new_value = implode(',',self::$value_array);
        }
        else{
            self::$values = [];
            foreach(self::$data as $key=>$value){
                self::$fields = $key;
                self::$values = [$value];
            }
            self::$new_value = '?';
        }
        
        try{
            self::$dbc = self::$Conn;
            self::$sql = "INSERT INTO ".self::$table."(".self::$fields.")VALUES(".self::$new_value.");";
            self::$response = self::$dbc->prepare(self::$sql);
            self::$response->execute(self::$values);
            self::$lid = self::$dbc->lastInsertId();

            return (object)[
                'code' => 1,
                'id' => self::$lid
            ]; /*Query ok*/
        }
        catch (\PDOException $e){
            return  3; /*La Llave dentro del array mal escrita*/
        }
    }

    public static function update($table,$data,$where,$id,$Conn=null)
    {
        self::$id    = $id;
        self::$data  = $data;
        self::$table = $table;
        self::$Conn  = $Conn;

        if(empty(self::$id)){
            return 5; /*Falta el identificador (id).*/
        }
        
        if(count($data) > 1){
            foreach(self::$data as $key=>$value){
                //self::$fields .= self::$table.'.'.$key.'=?,';
                self::$fields .= $key.'=?,';
                array_push(self::$value_array,$value);
            }
            array_push(self::$value_array,self::$id);
            self::$fields = substr(self::$fields,0,-1);
        }
        else{
            foreach(self::$data as $key=>$value){
                self::$fields = $key.'=?';
                array_push(self::$value_array,$value);
            }
            array_push(self::$value_array,self::$id);
        }

        try{
            self::$dbc = self::$Conn;
            self::$sql = "UPDATE ".self::$table." SET ".self::$fields." WHERE ".self::$table.".$where = ?;";
            self::$response = self::$dbc->prepare(self::$sql);
            self::$response->execute(self::$value_array);

            if(self::$response->rowCount()>0) return 1; /*Query ok*/
            
            return 2; /* no hay resultados.*/
        }
        catch (\PDOException $e){
            return  3; /* Llave dentro del array mal escrita*/
        }
    }

    public static function getAll($table,$Conn=null)
    {
        self::$table = $table;
        self::$Conn  = $Conn;

        try{
            self::$dbc = self::$Conn;
            self::$sql = "SELECT * FROM ".self::$table.";";
            self::$response = self::$dbc->query(self::$sql);

            return self::$response->fetchAll(\PDO::FETCH_OBJ);
        }
        catch (\PDOException $e){
            return  3;
        }
    }

    public static function getAllById($table,$where,$id,$Conn=null)
    {
        self::$id    = $id;
        self::$table = $table;
        self::$Conn  = $Conn;

        if(empty(self::$id)){
            return 5; /*Falta el identificador (id).*/
        }

        try{
            self::$dbc = self::$Conn;
            self::$sql = "SELECT * FROM ".self::$table." WHERE $where = ?;";

            //self::$response = self::$dbc->prepare(self::$sql);
            self::$response = self::$dbc->prepare(self::$sql, [\PDO::ATTR_CURSOR => \PDO::CURSOR_SCROLL]);

            self::$response->execute([self::$id]);
            
            if(self::$response->rowCount()>0) return self::$response->fetchAll(\PDO::FETCH_OBJ)[0];
            
            return 2; /* no hay resultados.*/
        }
        catch (\PDOException $e){
            return  3; /* Llave dentro del array mal escrita*/
        }
    }

    public static function getSelectedColumnById($table,$data,$id,$Conn=null)
    {
        self::$id    = $id;
        self::$data = $data;
        self::$table = $table;
        self::$Conn  = $Conn;

        if(empty(self::$id)){
            return 5; /*Falta el identificador (id).*/
        }

        foreach(self::$data as $value){
            self::$fields .= self::$table.'.'.$value.", ";
        }
        self::$fields = substr(trim(self::$fields),0,-1);

        try{
            self::$dbc = self::$Conn;
            self::$sql = "SELECT ".self::$fields." FROM ".self::$table." WHERE id = ".(int)self::$id.";";
            //self::$response = self::$dbc->prepare(self::$sql);
            self::$response = self::$dbc->prepare(self::$sql, [\PDO::ATTR_CURSOR => \PDO::CURSOR_SCROLL]);
            self::$response->execute();
            
            if(self::$response->rowCount()>0) return self::$response->fetchAll(\PDO::FETCH_OBJ)[0];
            
            return 2; /* no hay resultados.*/
        }
        catch (\PDOException $e){
            return  3; /* Llave dentro del array mal escrita*/
            exit;
        }
    }

    public static function delete($table,$id,$Conn=null)
    {
        self::$id    = $id;
        self::$table = $table;
        self::$Conn  = $Conn;

        if(empty(self::$id)){
            return 5; /*Falta el identificador (id).*/
        }

        try{
            self::$dbc = self::$Conn;
            self::$sql = "DELETE FROM ".self::$table." WHERE id = ?;";
            self::$response = self::$dbc->prepare(self::$sql);
            self::$response->execute([self::$id]);

            if(self::$response->rowCount()>0) return 1; /*Query ok.*/
            
            return 2; /* no hay resultados.*/
        }
        catch (\PDOException $e){
            return  3; /*La Llave dentro del array mal escrita*/
        }
    }

    public static function map($params='')
    {
        self::$params = $params;
        return (object)[
            'select'    => "SELECT "     .self::$params."",
            'from'      => " FROM "      .self::$params."",
            'leftjoin'  => " LEFT JOIN " .self::$params."",
            'rightjoin' => " RIGHT JOIN ".self::$params."",
            'outerjoin' => " OUTER JOIN ".self::$params."",
            'innerjoin' => " INNER JOIN ".self::$params."",
            'join'      => " JOIN "      .self::$params."",
            'on'        => " ON "        .self::$params."",
            'where'     => " WHERE "     .self::$params."",
            'and'       => " AND "       .self::$params."",
            'groupby'   => " GROUP BY "  .self::$params."",
            'orderby'   => " ORDER BY "  .self::$params."",
            'in'        => " IN ("       .self::$params.")",
            'notin'     => " NOT IN ("   .self::$params.")",
            'like'      => " LIKE "      .self::$params."",
            'between'   => " BETWEEN "   .self::$params."",
            'or'        => " OR "        .self::$params."",
            'limit'     => " LIMIT "     .self::$params."",
            'top'       => " TOP ("      .self::$params.")",
            'equal'     => " = "         .self::$params."",
        ];
    }

    public static function openquery($openquery,$Conn=null)
    {
        self::$openquery = $openquery;
        self::$Conn = $Conn;

        try{
            self::$dbc = self::$Conn;
            
            $verbs = ['delete','drop','alter','create','describe'];

            foreach( $verbs as $verb ){
                $compare = strpos(strtolower(self::$openquery), strtolower($verb));
                if( $compare !== false ){
                    exit(json_encode([400,'Error', 'El método ::openquery() no puede ser utilizado para: (delete, drop, alter, create o describe)', 'Exiten métodos para delete y update en: (db/qmp/) ::update(), ::delete()']));
                }
            }

            self::$response = self::$dbc->query(self::$openquery);

            return self::$response->fetchAll(\PDO::FETCH_OBJ);
        }
        catch (\PDOException $e){
            return  3; /* 'Error en la consulta.'*/;
        }
    }

    public static function openquery_pagination($openquery,$Conn=null)
    {
        self::$openquery = $openquery;
        self::$Conn = $Conn;

        try{
            self::$dbc = self::$Conn;
            
            $verbs = ['delete','drop','update','alter','create','describe'];

            foreach( $verbs as $verb ){
                $compare = strpos(strtolower(self::$openquery), strtolower($verb));
                if( $compare !== false ){
                    exit(json_encode([400,'Error', 'El método ::openquery() no puede ser utilizado para: (delete, drop, update, alter, create o describe)', 'Exiten métodos para delete y update en: (db/qmp/) ::update(), ::delete()']));
                }
            }

            self::$response = self::$dbc->query(self::$openquery);

            return (object) [
                'data' => self::$response->fetchAll(\PDO::FETCH_OBJ),
                'rows' => self::$response->rowCount()
            ];
        }
        catch (\PDOException $e){
            return  3; /* 'Error en la consulta.'*/;
        }
    }

    public static function sanitize($sanitize)
    {
        self::$sanitize = $sanitize;
        self::$sanitize = preg_replace("/[^\wáéíóúñäëïöüÁÉÍÓÚÑÄËÏÖÜ@$#!%-:;+,.\"\/\s]/",'',trim(self::$sanitize));
        return html_entity_decode(self::$sanitize);
    }
}