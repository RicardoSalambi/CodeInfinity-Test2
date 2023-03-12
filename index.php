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

        
        
        for ($index = 0; $index < $numRecords; $index++) {
            $name = $names[array_rand($names)];
            $surname = $surnames[array_rand($surnames)];
            $age = rand(18, 100);
            $dob = date('d/m/Y', strtotime('-' . rand(18, 60) . ' years'));
            $id = generateUniqueId();
            $initials = strtoupper(substr($name, 0, 1) . substr($surname, 0, 1));
    
            // Write data to file
            fputcsv($handle, array($id, $name, $surname, $initials, $age, $dob));
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

    generateCSV(3);

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
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            
            <div class="fields">

                <div><input type="text" id="name" name="name" placeholder="Name" value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>"></div>
                
                <div><input type="text" id="surname" name="surname" placeholder="Surname" value="<?php echo isset($_POST['surname']) ? $_POST['surname'] : ''; ?>"></div>

                <div><input type="number" id="id" name="id" placeholder="ID Number" maxlength="13" value="<?php echo isset($_POST['id']) ? $_POST['id'] : ''; ?>"></div>

                <div><input type="text" id="dob" name="dob" placeholder="Date of Birth" value="<?php echo isset($_POST['dob']) ? $_POST['dob'] : ''; ?>"></div>

                <div><button type="submit" name="submit"> Submit </button></div>

                <div><button name="cancel"> Cancel </button></div>

            </div>
            

        </form>
        

    </body>
    


    
    
</html>