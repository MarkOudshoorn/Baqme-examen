<?php
class Connection
{
    public $conn;
    private $dsn;
    private $host;
    private $dbname;
    private $dbusername;
    private $dbpassword;

    public function __construct($_dsn, $_host, $_dbname, $_dbusername, $_dbpassword = NULL)
    {
        if(!empty($_dsn) && !empty($_host) && !empty($_dbname) && !empty($_dbusername))
        {
            $this->dsn = $_dsn;
            $this->host = $_host;
            $this->dbname = $_dbname;
            $this->dbusername = $_dbusername;
            $this->dbpassword = $_dbpassword;

            $this->conn = new PDO(
                "{$this->dsn}:
                host={$this->host};
                dbname={$this->dbname}",
                $this->dbusername,
                $this->dbpassword);
        }
    }

    public function executeQuery($query, $params = [])
    {
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt;
    }
}

$db = new Connection("mysql", "localhost", "warehousedashboard", "root", "");

