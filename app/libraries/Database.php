<?php

class Database
{
    /* It's a way to define a variable with a default value. */
    private string $dbHost = DB_HOST;
    private string $dbUser = DB_USER;
    private string $dbPass = DB_PASS;
    public string $dbName = DB_NAME;

    /* It's a way to define a variable with a default value. */
    private PDOStatement $statement;
    private PDO $dbHandler;
    private string $error;

    /**
     * It creates a connection to the database
     */
    public function __construct()
    {
        /* Define the connection to the database. */
        $conn = 'mysql:host=' . $this->dbHost . ';dbname=' . $this->dbName;
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        /* It's a way to catch an error. */
        try {
            $this->dbHandler = new PDO($conn, $this->dbUser, $this->dbPass, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }

    /**
     * > The function `query` takes a string as an argument and prepares a statement using the string
     *
     * @param sql The SQL query you want to run.
     */
    public function query($sql)
    {
        $this->statement = $this->dbHandler->prepare($sql);
    }


    /**
     * It's a function that will create a SQL query based on the given parameters
     *
     * @param object data The data that will be used to build the SQL query.
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

        /* It's a way to define a variable with a default value. */
        $sql = 'SELECT ';

        /* It's a way to check if the `$data->columns` is set. If it's set, it will add the columns to the SQL query. If
        it's not set, it will add `*` to the SQL query. */
        if (isset($data->columns)) {
            $sql .= implode(', ', $data->columns);
        } else {
            $sql .= '*';
        }

        /* It's adding the table to the SQL query. */
        $sql .= ' FROM ' . $data->table;

        /* It's adding the `WHERE` clause to the SQL query. */
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

        /* It's adding the `ORDER BY` clause to the SQL query. */
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

        /* It's checking if the `$data->limit` is set. If it's set, it will add the limit to the SQL query. */
        if (isset($data->limit)) {
            if (is_array($data->limit)) {
                $sql .= ' LIMIT ' . $data->limit[0] . ', ' . $data->limit[1];
            } else {
                $sql .= ' LIMIT ' . $data->limit;
            }
        }

        /* It's preparing the SQL query. */
        $this->query($sql);

        /* It's binding the values to the SQL query. */
        if (isset($data->where)) {
            foreach ($data->where as $key => $value) {
                $this->statement->bindValue(':' . $key, $this->encrypt($value, $key));
            }
        }

        /* It's executing the SQL query. */
        $this->statement->execute();
    }

    /**
     * It's inserting data into a database
     *
     * @param object data It's an object that contains the table name and the values to insert.
     */
    public function insert(object $data)
    {
        /**
         * Exemple of $data :
         *
         * table = 'users' (required)
         * values = ['name' => 'John', 'email' => 'john@die.com'] (required)
         */

        /* It's adding the table to the SQL query. */
        $sql = 'INSERT INTO ' . $data->table . ' (';

        /* It's adding the columns to the SQL query. */
        $i = 0;
        foreach ($data->values as $key => $value) {
            if ($i > 0) {
                $sql .= ', ';
            }
            $sql .= $key;
            $i++;
        }

        /* It's adding `) VALUES (` to the SQL query. */
        $sql .= ') VALUES (';

        /* It's adding the values to the SQL query. */
        $i = 0;
        foreach ($data->values as $key => $value) {
            if ($i > 0) {
                $sql .= ', ';
            }
            $sql .= ':' . $key;
            $i++;
        }

        /* It's adding `)` to the SQL query. */
        $sql .= ')';

        /* It's preparing the SQL query. */
        $this->query($sql);

        /* It's binding the values to the SQL query. */
        if (isset($data->values)) {
            foreach ($data->values as $key => $value) {
                $this->statement->bindValue(':' . $key, $this->encrypt($value, $key));
            }
        }

        /* It's executing the SQL query. */
        $this->statement->execute();
    }

    /**
     * It's updating a row in a table
     *
     * @param object data It's an object that contains the following parameters:
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

        /* It's adding the table to the SQL query. */
        $sql = 'UPDATE ' . $data->table . ' SET ';

        /* It's adding the values to the SQL query. */
        $i = 0;
        foreach ($data->values as $key => $value) {
            if ($i > 0) {
                $sql .= ', ';
            }
            $sql .= $key . ' = :' . $key . 'value';
            $i++;
        }

        /* It's adding ` WHERE ` to the SQL query. */
        $sql .= ' WHERE ';

        /* It's adding the `WHERE` clause to the SQL query. */
        $i = 0;
        foreach ($data->where as $key => $value) {
            if ($i > 0) {
                $sql .= ' AND ';
            }
            $sql .= $key . ' = :' . $key . 'where';
            $i++;
        }

        /* It's preparing the SQL query. */
        $this->query($sql);

        /* It's binding the values to the SQL query. */
        if (isset($data->values)) {
            foreach ($data->values as $key => $value) {
                $this->statement->bindValue(':' . $key . 'value', $this->encrypt($value, $key));
            }
        }

        /* It's binding the values to the SQL query. */
        if (isset($data->where)) {
            foreach ($data->where as $key => $value) {
                $this->statement->bindValue(':' . $key . 'where', $this->encrypt($value, $key));
            }
        }

        /* It's executing the SQL query. */
        $this->statement->execute();
    }

    /**
     * It's deleting a row from a table
     *
     * @param object data It's an object that contains the following properties:
     */
    public function delete(object $data)
    {
        /**
         * Exemple of $data :
         *
         * table = 'users' (required)
         * where = ['id' => 1] (required)
         */

        /* It's adding the table to the SQL query. */
        $sql = 'DELETE FROM ' . $data->table . ' WHERE ';

        /* It's adding the `WHERE` clause to the SQL query. */
        $i = 0;
        foreach ($data->where as $key => $value) {
            if ($i > 0) {
                $sql .= ' AND ';
            }
            $sql .= $key . ' = :' . $key;
            $i++;
        }

        /* It's preparing the SQL query. */
        $this->query($sql);

        /* It's binding the values to the SQL query. */
        if (isset($data->where)) {
            foreach ($data->where as $key => $value) {
                $this->statement->bindValue(':' . $key, $this->encrypt($value, $key));
            }
        }

        /* It's executing the SQL query. */
        $this->statement->execute();
    }


    /**
     * It's binding the value to the SQL query
     *
     * @param parameter The parameter is the name of the placeholder in the SQL statement.
     * @param value The value to bind to the parameter.
     * @param type The data type of the parameter, which is optional. PDO::PARAM_STR is the default value.
     */
    public function bind($parameter, $value, $type = null)
    {
        /* It's encrypting the data before it's inserted into the database. */
        $value = $this->encrypt($value);

        /* It's checking the type of the value and setting the type of the value. */
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

        /* It's binding the value to the SQL query. */
        $this->statement->bindValue($parameter, $value, $type);
    }


    /**
     * It's returning the result of the SQL query
     *
     * @return bool The result of the SQL query.
     */
    public function execute(): bool
    {
        /* It's returning the result of the SQL query. */
        return $this->statement->execute();
    }

    /**
     * Decrypt the data
     *
     * @param encrypted The encrypted data.
     */
    public function decrypt($encrypted)
    {
        /* Decrypting the encrypted password. */
        if (DB_CRYPT) {
            /* It's decrypting the data. */
            $decrypted = openssl_decrypt($encrypted, DB_CIPHER_ALGO, DB_CRYPT_KEY);
            return !$decrypted ? $encrypted : $decrypted;
        } else {
            /* It's returning the encrypted data. */
            return $encrypted;
        }
    }

    /**
     * > If the column name doesn't contain the word "id" or "nocrypt" and the DB_CRYPT constant is set to true, then
     * encrypt the data using the DB_CIPHER_ALGO and DB_CRYPT_KEY constants
     *
     * @param decrypted The data that is going to be encrypted.
     * @param column The column name that is being encrypted.
     */
    public function encrypt($decrypted, $column = null)
    {
        /* Checking if the column is not an id column or a nocrypt column and if the DB_CRYPT is set to true. */
        if ((!strpos($column, 'id') || !strpos($column, 'nocrypt')) && DB_CRYPT) {
            /* Encrypting the data before it is stored in the database. */
            $encrypted = openssl_encrypt($decrypted, DB_CIPHER_ALGO, DB_CRYPT_KEY);
            return !$encrypted ? $decrypted : $encrypted;
        }

        /* It's returning the decrypted data. */
        return $decrypted;
    }



    /**
     * > This function fetches all the data from the database and decrypts it
     *
     * @return An array of all the rows in the database.
     */
    public function fetchAll()
    {
        /* Fetching all the data from the database. */
        $this->execute();
        $response = $this->statement->fetchAll();

        /* Decrypting the data in the response. */
        foreach ($response as $key => $value) {
            foreach ($value as $key2 => $value2) {
                $response[$key][$key2] = $this->decrypt($value2);
            }
        }

        return $response;
    }


    /**
     * It fetches the data from the database, decrypts it, and returns it
     *
     * @return The response from the server.
     */
    public function fetch()
    {
        /* Fetching the data from the database. */
        $this->execute();
        $response = $this->statement->fetch();

        /* Decrypting the response from the server. */
        foreach ($response as $key => $value) {
            $response[$key] = $this->decrypt($value);
        }

        return $response;
    }

    /**
     * Returning the number of rows affected by the last SQL statement
     *
     * @return int The number of rows affected by the last SQL statement.
     */
    public function rowCount(): int
    {
        /* Returning the number of rows affected by the last SQL statement. */
        return $this->statement->rowCount();
    }
}