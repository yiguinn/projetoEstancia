<?php
class conexaoDb {
    private $pdo;
    private $host = 'localhost';
    private $dbname = 'dbprojetoEstancia';
    private $user = 'root';
    private $senha = '';

    public function conectar()
        {
               try{        
                    $this->pdo = new PDO("mysql:dbname=".$this->dbname.";host=".$this->host 
                    ,$this->user, $this->senha);
                    }
                catch (PDOException $e){

                    echo "ERRO DE CONEXÃO NO PDO: ".$e->getMessage();
                     exit();
                }
                catch (Exception $e){
                    echo "ERRO não passou da conexao: ".$e->getMessage();
                    exit();
                }
                return $this->pdo;
            }
}
?>