<?php


class User
{
    /* Creating a private variable called $db that is an instance of the Database class. */
    private Database $db;

    /**
     * The constructor function is called when the class is instantiated. It creates a new instance of the Database class
     */
    public function __construct()
    {
        /* Creating a new instance of the Database class. */
        $this->db = new Database();
    }

    /**
     * It takes the username and password entered by the user, selects the user from the database, gets the hashed password
     * from the database, checks if the password entered by the user matches the hashed password in the database, and
     * returns the row from the database if it does, or false if it doesn't
     *
     * @param username The username entered by the user.
     * @param password The password entered by the user.
     *
     * @return The row from the database.
     */
    public function login($username, $password)
    {
        /* Creating a new object called $query and setting the table and where properties. */
        $query = new stdClass();
        $query->table = 'users';
        $query->where = ['u_username' => $username];

       /* Selecting the user from the database and fetching the row. */
         $this->db->select($query);
        $row = $this->db->fetch();

        /* Getting the password from the database and storing it in a variable called $hashedPassword. */
        $hashedPassword = $row['u_password'];

        /* Checking if the password entered by the user matches the hashed password in the database. If it does, it returns
        the row from the database. If it doesn't, it returns false. */
        if(password_verify($password, $hashedPassword)){
            return $row;
        } else {
            return false;
        }
    }

    /**
     * It creates a new object called $query, sets the table and values properties, and then returns the result of the
     * insert function in the Database class
     *
     * @param data An array of the data that is being passed to the function.
     *
     * @return The result of the insert function in the Database class.
     */
    public function register($data)
    {
        /* Creating a new object called $query and setting the table and values properties. */
        $query = new stdClass();
        $query->table = 'users';
        $query->values = [
            'u_username' => $data['username'],
            'u_email' => $data['email'],
            'u_password' => $data['password']
        ];

       /* Returning the result of the insert function in the Database class. */
         return $this->db->insert($query);
    }

    /**
     * It checks if the user exists in the database
     *
     * @param email The email address of the user.
     *
     * @return bool a boolean value.
     */
    public function findUserByEmail($email): bool
    {
        /* Creating a new object called $query, setting the table and where properties, and then returning the result of
        the
                insert function in the Database class. */
        $query = new stdClass();
        $query->table = 'users';
        $query->where = ['u_email' => $email];

        /* Selecting the user from the database. */
        $this->db->select($query);

        /* Checking if the row count is greater than 0. If it is, it returns true. If it isn't, it returns false. */
        if($this->db->rowCount() > 0){
            return true;
        } else {
            return false;
        }
    }
}