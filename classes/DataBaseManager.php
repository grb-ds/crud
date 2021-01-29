<?php

// This class will manage the connection to the database
// It will be passed on the other classes who need it
class DatabaseManager
{
    // These are private: only this class needs them
    private $host;
    private $user;
    private $password;
    private $dbname;
    // This one is public, so we can use it outside of this class
    // We could also use a private variable and a getter (but let's not make things too complicated at this point)
    public $connection;

    public function __construct(string $host, string $user, string $password, string $dbname)
    {
        // TODO: Set any user and password information
        $this->host = $host;
        $this->user = $user;
        $this->password =$password;
        $this->dbname = $dbname;
    }

    public function connect()
    {
        // TODO: make the connection to the database
        $this->connection = new mysqli($this->host, $this->user, $this->password, $this->dbname);

        if ( $this->connection->connect_errno) {

            printf("connection failed: %s\n",  $this->connection->connect_error());
            exit();
        }
    }

    public function executeQuery($query)
    {
        $res = $this->connection->query($query);

        if (!$res) {
            echo "failed to execute query: $query\n";
        } else {
            echo "Query: $query executed\n";
            echo $res;
        }

        if (is_object($res)) {
            $res->close();
        }
    }

    public function executeSelectStatement($query)
    {
        if ($statement = $this->connection->prepare($query)) {
            $statement->execute();
            $result = $statement->get_result();
            $statement->close();
            //$result->fetch_all(MYSQLI_ASSOC); //one row
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            echo "failed to fetch data\n";
            return false;
        }
    }

    public function executeQueryStatement($query)
    {
        if ($statement = $this->connection->prepare($query)) {
            $statement->execute();
            $statement->close();
            echo $this->connection->info;
          //  return $statement->affected_rows;
        } else {
            echo "Error query\n";
            return false;
        }
    }
}