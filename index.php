<?php  
    // Set maximum allowed file size to 50 MB
    ini_set('upload_max_filesize', '50M');

    // Set maximum allowed POST data size to 100 MB
    ini_set('post_max_size', '50M');

    // Set maximum execution time to 300 seconds
    ini_set('max_execution_time', '300');

    // Set memory limit to 512 MB
    ini_set('memory_limit', '-1');

    function generateCSV($numRecords) {

        $names = array(
            'Emma',
            'Liam',
            'Olivia',
            'Noah',
            'Ava',
            'William',
            'Sophia',
            'Mason',
            'Isabella',
            'James',
            'Mia',
            'Benjamin',
            'Charlotte',
            'Jacob',
            'Amelia',
            'Michael',
            'Evelyn',
            'Elijah',
            'Abigail',
            'Ethan'
        );

        $surnames = array(
            'Smith',
            'Johnson',
            'Williams',
            'Jones',
            'Brown',
            'Garcia',
            'Miller',
            'Davis',
            'Rodriguez',
            'Martinez',
            'Hernandez',
            'Lopez',
            'Gonzalez',
            'Wilson',
            'Anderson',
            'Thomas',
            'Jackson',
            'White',
            'Harris',
            'Martin'
        );

        // Output folder
        $output_folder = 'output';

        // Check if the output folder exists, and create it if it doesn't
        if (!file_exists($output_folder)) {
            mkdir($output_folder);
        }

        $handle = fopen('output/output.csv', 'w');
    
        // Write column headers
        $headers = array('Id', 'Name', 'Surname', 'Initials', 'Age', 'DateOfBirth');
        fwrite($handle, implode(',', $headers) . "\n");

        // Initialize array to store generated records
        $records = array();

        
        while (count($records) < $numRecords) {
        // for ($index = 0; $index < $numRecords; $index++) {
            $name = $names[array_rand($names)];
            $surname = $surnames[array_rand($surnames)];
            $age = rand(18, 100);
            $dob = date('d/m/Y', strtotime('-' . rand(18, 100) . ' years'));
            $id = generateUniqueId();
            $initials = strtoupper(substr($name, 0, 1) . substr($surname, 0, 1));

            // Check if record already exists
            if (!isset($records[$id])) {
                // Write data to file
                $data = array($id, $name, $surname, $initials, $age, $dob);
                fwrite($handle, implode(',', $data) . "\n");
                $records[$id] = array('Name' => $name, 'Surname' => $surname, 'Age' => $age, 'DateOfBirth' => $dob);
            }
        }
        
        fclose($handle);

    }

    function generateUniqueId() {
        // Define possible characters for ID
        $characters = '0123456789';
    
        // Generate random ID string
        $id = '';
        for ($index = 0; $index < 13; $index++) {
            $id .= $characters[rand(0, strlen($characters) - 1)];
        }
    
        return $id;
    }

    function importIntoDB($csvFilePath){
        // Open the SQLite database
        $dbfile = "test.db";
        $db = new PDO("sqlite:" . $dbfile);

        // Create the table
        $db->exec("CREATE TABLE IF NOT EXISTS csv_import (
                    Id TEXT PRIMARY KEY,
                    Name TEXT,
                    Surname TEXT,
                    Initials TEXT,
                    Age INTEGER,
                    DateOfBirth TEXT)");

        // Open the CSV file
        $file = fopen($csvFilePath, "r");

        // Read and discard the header row
        $header = fgetcsv($file);

        // Loop through each row in the CSV file
        while (($data = fgetcsv($file)) !== FALSE) {

            // Insert the row into the database table
            $stmt = $db->prepare("INSERT INTO csv_import (Id, Name, Surname, Initials, Age, DateOfBirth) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt -> bindParam(1, $data[0]);
            $stmt->bindParam(2, $data[1]);
            $stmt->bindParam(3, $data[2]);
            $stmt->bindParam(4, $data[3]);
            $stmt->bindParam(5, $data[4]);
            $stmt->bindParam(6, $data[5]);
            $stmt->execute();

        }

        // Close the file and database connection
        fclose($file);
        $db = null;

        echo "Data imported successfully.";
    }

    if (isset($_POST['submit'])) {

        if(empty($_POST['nor'])) {
            echo 'Please input the number of rows needed';
        } else {
            generateCSV($_POST['nor']);
            echo " File found at " . __DIR__ . "/output/" . "output.csv";
        }      
        
        
    }

    if (isset($_POST['import'])) {

        // print_r($_FILES['file']);
        
        if(!empty($_FILES['file']['name'])) {
            // file has been submitted
            importIntoDB($_FILES['file']['tmp_name']);
        } else {
            echo "file has not been submitted";
        }

    }

    

?>

<html>
    <head>       

        <link rel="stylesheet" href="style.css">

    </head>

    <body>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
            
            <div class="fields">

                <div class="header"> <h2>Proficieny Test 2</h2> </div>

                <div><input type="number" id="nor" name="nor" placeholder="Number of Rows"></div>

                <div><button type="submit" name="submit"> Generate CSV File </button></div>

                <div><input type="file" name="file" placeholder="upload file"></div>                

                <div><button name="import"> Import CSV File to SQLite Database </button></div>

                <div><input class="errorsArea" type="textarea" name="errors" value="<?php echo isset($_POST['errors']) ? $_POST['errors'] : ''; ?>"></div>

            </div>
            

        </form>
        

    </body>
    


    
    
</html>