<?php
namespace Php;

class DbImport 
{ 

    // Function to the database and tables and fill them with the default data
    function createDatabase($data = [])
    {
        // Connect to the database
        @$mysqli = new \mysqli($data['hostname'], $data['username'], $data['password'], '');

        // Check for errors
        if (mysqli_connect_errno()){
            return false;
        } else {
			return true;
		}
    }

    // Function to create the tables and fill them with the default data
    function createTables($data = [])
    {
        // Connect to the database
        @$mysqli = new \mysqli(
            $data['hostname'],
            $data['username'],
            $data['password'],
            $data['database']
        );

        // Check for errors
        if (mysqli_connect_errno())
            return false;

        // Open the default SQL file
        $query = file_get_contents('sql/install.sql');

        // Execute a multi query
        $multi_query = $mysqli->multi_query($query);

        // Close the connection
        $mysqli->close();

        if ($multi_query){
            return true;
        } else {
            return false;
        }
    }

    // Function to insert data
    function insertData($data = [])
    {
        // Connect to the database
        @$mysqli = new \mysqli(
            $data['hostname'],
            $data['username'],
            $data['password'],
            $data['database']
        );

        // Check for errors
        if (mysqli_connect_errno())
            return false;

        // Open the default SQL file
        $query = file_get_contents('sql/data.sql');

        // Execute a multi query
        $multi_query = $mysqli->multi_query($query);

        // Close the connection
        $mysqli->close();

        if ($multi_query){
            return true;
        } else {
            return false;
        }
    }

}
    