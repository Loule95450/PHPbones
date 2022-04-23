<?php

/**
 * Class Database
 * Gère les requêtes à la bdd
 */
class Database
{
    /**
     * @var string
     * @access private
     */
    private string $dbHost = DB_HOST;
    private string $dbUser = DB_USER;
    private string $dbPass = DB_PASS;
    public string $dbName = DB_NAME;

    /**
     * Instance de PDO
     *
     * @var PDO
     * @var PDOStatement
     * @var string
     * @access private
     * @see http://php.net/manual/fr/book.pdo.php
     */
    private PDOStatement $statement;
    private PDO $dbHandler;
    private string $error;

    /**
     * Database constructor.
     */
    public function __construct()
    {
        $conn = 'mysql:host=' . $this->dbHost . ';dbname=' . $this->dbName;
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );
        try {
            $this->dbHandler = new PDO($conn, $this->dbUser, $this->dbPass, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }

    /**
     * Query the database
     *
     * @param $sql
     * @return void
     * @see http://php.net/manual/fr/pdo.prepare.php
     */
    public function query($sql)
    {
        $this->statement = $this->dbHandler->prepare($sql);
    }

    /**
     * Select request with parameters
     *
     * @param $data Object
     * @return void
     */
    public function select(object $data)
    {
        /**
         * Exemple of $data :
         *
         * table = 'users' (required)
         * columns = ['id', 'name'] (optional)
         * where = ['id' => 1] (optional)
         * orderBy = 'id' (optional)
         * order = ['id' => 'ASC', 'name' => 'DESC'] (optional)
         * limit = [0, 10] (optional)
         */

        $sql = 'SELECT ';
        if (isset($data->columns)) {
            $sql .= implode(', ', $data->columns);
        } else {
            $sql .= '*';
        }

        $sql .= ' FROM ' . $data->table;

        if (isset($data->where)) {
            $sql .= ' WHERE ';
            $i = 0;
            foreach ($data->where as $key => $value) {
                if ($i > 0) {
                    $sql .= ' AND ';
                }
                $sql .= $key . ' = :' . $key;
                $i++;
            }
        }

        if (isset($data->order)) {
            $sql .= ' ORDER BY ';
            $i = 0;
            foreach ($data->order as $key => $value) {
                if ($i > 0) {
                    $sql .= ', ';
                }
                $sql .= $key . ' ' . $value;
                $i++;
            }
        }

        if (isset($data->limit)) {
            if (is_array($data->limit)) {
                $sql .= ' LIMIT ' . $data->limit[0] . ', ' . $data->limit[1];
            } else {
                $sql .= ' LIMIT ' . $data->limit;
            }
        }

        $this->query($sql);
        if (isset($data->where)) {
            foreach ($data->where as $key => $value) {
                $this->statement->bindValue(':' . $key, $this->encrypt($value, $key));
            }
        }
        $this->statement->execute();
    }

    /**
     * Insert request with parameters
     *
     * @param $data Object
     * @return void
     */
    public function insert(object $data)
    {
        /**
         * Exemple of $data :
         *
         * table = 'users' (required)
         * values = ['name' => 'John', 'email' => 'john@die.com'] (required)
         */

        $sql = 'INSERT INTO ' . $data->table . ' (';
        $i = 0;
        foreach ($data->values as $key => $value) {
            if ($i > 0) {
                $sql .= ', ';
            }
            $sql .= $key;
            $i++;
        }
        $sql .= ') VALUES (';
        $i = 0;
        foreach ($data->values as $key => $value) {
            if ($i > 0) {
                $sql .= ', ';
            }
            $sql .= ':' . $key;
            $i++;
        }
        $sql .= ')';

        $this->query($sql);
        if (isset($data->values)) {
            foreach ($data->values as $key => $value) {
                $this->statement->bindValue(':' . $key, $this->encrypt($value, $key));
            }
        }
        $this->statement->execute();
    }

    /**
     * Update request with parameters
     *
     * @param $data Object
     * @return void
     */
    public function update(object $data)
    {
        /**
         * Exemple of $data :
         *
         * table = 'users' (required)
         * values = ['name' => 'John', 'email' => 'john@doe.com'], (required)
         * where = ['id' => 1] (required)
         */

        $sql = 'UPDATE ' . $data->table . ' SET ';
        $i = 0;
        foreach ($data->values as $key => $value) {
            if ($i > 0) {
                $sql .= ', ';
            }
            $sql .= $key . ' = :' . $key . 'value';
            $i++;
        }
        $sql .= ' WHERE ';
        $i = 0;
        foreach ($data->where as $key => $value) {
            if ($i > 0) {
                $sql .= ' AND ';
            }
            $sql .= $key . ' = :' . $key . 'where';
            $i++;
        }

        $this->query($sql);
        if (isset($data->values)) {
            foreach ($data->values as $key => $value) {
                $this->statement->bindValue(':' . $key . 'value', $this->encrypt($value, $key));
            }
        }
        if (isset($data->where)) {
            foreach ($data->where as $key => $value) {
                $this->statement->bindValue(':' . $key . 'where', $this->encrypt($value, $key));
            }
        }
        $this->statement->execute();
    }

    /**
     * Delete request with parameters
     *
     * @param $data Object
     * @return void
     */
    public function delete(object $data)
    {
        /**
         * Exemple of $data :
         *
         * table = 'users' (required)
         * where = ['id' => 1] (required)
         */

        $sql = 'DELETE FROM ' . $data->table . ' WHERE ';
        $i = 0;
        foreach ($data->where as $key => $value) {
            if ($i > 0) {
                $sql .= ' AND ';
            }
            $sql .= $key . ' = :' . $key;
            $i++;
        }

        $this->query($sql);
        if (isset($data->where)) {
            foreach ($data->where as $key => $value) {
                $this->statement->bindValue(':' . $key, $this->encrypt($value, $key));
            }
        }
        $this->statement->execute();
    }


    /**
     * Get the last inserted id
     *
     * @param $parameter
     * @param $value
     * @param null $type
     * @return void
     */
    public function bind($parameter, $value, $type = null)
    {
        $value = $this->encrypt($value);

        switch (is_null($type)) {
            case is_int($value):
                $type = PDO::PARAM_INT;
                break;
            case is_bool($value):
                $type = PDO::PARAM_BOOL;
                break;
            case is_null($value):
                $type = PDO::PARAM_NULL;
                break;
            default:
                $type = PDO::PARAM_STR;
        }
        $this->statement->bindValue($parameter, $value, $type);
    }

    /**
     * Get the last inserted id
     *
     * @return bool
     */
    public function execute(): bool
    {
        return $this->statement->execute();
    }

    /**
     * Decrypt the data
     *
     * @param $encrypted
     * @return mixed|string
     */
    public function decrypt($encrypted)
    {
        if (DB_CRYPT) {
            $decrypted = openssl_decrypt($encrypted, DB_CIPHER_ALGO, DB_CRYPT_KEY);
            return !$decrypted ? $encrypted : $decrypted;
        } else {
            return $encrypted;
        }
    }

    /**
     * Encrypt the data
     *
     * @param $decrypted
     * @return mixed|string
     */
    public function encrypt($decrypted, $column = null)
    {
        if ((!strpos($column, 'id') || !strpos($column, 'nocrypt')) && DB_CRYPT) {
            $encrypted = openssl_encrypt($decrypted, DB_CIPHER_ALGO, DB_CRYPT_KEY);
            return !$encrypted ? $decrypted : $encrypted;
        }

        return $decrypted;
    }


    /**
     * Get the last inserted id
     *
     * @return array|false
     */
    public function fetchAll()
    {
        $this->execute();
        $response = $this->statement->fetchAll();

        // Decrypt the data
        foreach ($response as $key => $value) {
            foreach ($value as $key2 => $value2) {
                $response[$key][$key2] = $this->decrypt($value2);
            }
        }

        return $response;
    }

    /**
     * Get the last inserted id
     *
     * @return void
     */
    public function fetch()
    {
        $this->execute();
        $response = $this->statement->fetch();

        // Decrypt the data
        foreach ($response as $key => $value) {
            $response[$key] = $this->decrypt($value);
        }

        return $response;
    }

    /**
     * Get the last inserted id
     *
     * @return int
     */
    public function rowCount(): int
    {
        return $this->statement->rowCount();
    }
}