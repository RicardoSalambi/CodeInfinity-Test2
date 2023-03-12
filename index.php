<?php  
    
    

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

        $handle = fopen('output/output.csv', 'w');
    
        // Write column headers
        fputcsv($handle, array('Id', 'Name', 'Surname', 'Initials', 'Age', 'DateOfBirth'));

        // Initialize array to store generated records
        $records = array();

        
        while (count($records) < $numRecords) {
        // for ($index = 0; $index < $numRecords; $index++) {
            $name = $names[array_rand($names)];
            $surname = $surnames[array_rand($surnames)];
            $age = rand(18, 100);
            $dob = date('d/m/Y', strtotime('-' . rand(18, 60) . ' years'));
            $id = generateUniqueId();
            $initials = strtoupper(substr($name, 0, 1) . substr($surname, 0, 1));


            // Check if record already exists
            $recordExists = false;

            foreach ($records as $record) {
                if ($record['Name'] == $name && $record['Surname'] == $surname && $record['Age'] == $age && $record['DateOfBirth'] == $dob) {
                    $recordExists = true;
                    break;
                }
            }
    
            // Write data to file
            if (!$recordExists) {
                fputcsv($handle, array($id, $name, $surname, $initials, $age, $dob));
                $records[] = array('Name' => $name, 'Surname' => $surname, 'Age' => $age, 'DateOfBirth' => $dob);
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

    if (isset($_POST['submit'])) {
        generateCSV($_POST['nor']);

        echo " File found at " . __DIR__ . "/output/" . "output.csv";
    }

    

?>

<html>
    <head>
        <!-- style=" background-color: rgb(61, 65, 61); color: white" -->
        <div class="header"> 
            <h2>Proficieny Test 2</h2>
        </div>

        <link rel="stylesheet" href="style.css">

    </head>

    <body>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
            
            <div class="fields">

                <div><input type="text" id="nor" name="nor" placeholder="Number of Rows"></div>

                <div><button type="submit" name="submit"> Generate CSV File </button></div>

                <div><input type="file" name="csv_file" id="csv_file" placeholder="upload file"></div>                

                <div><button name="cancel"> Import CSV File to SQLite Database </button></div>

            </div>
            

        </form>
        

    </body>
    


    
    
</html>