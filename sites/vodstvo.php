<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="styles/trenerji-vodstvo.css">

    <title>Trenerji</title>
</head>
<body>

    <?php 
    
    include"navigation.php";
    
    $profiles = [
        ['name' => 'John Doe', 'roles' => 'Software Developer, Team Lead'],
        ['name' => 'Jane Smith', 'roles' => 'Product Manager, UX Designer'],
        ['name' => 'Chris Evans', 'roles' => 'DevOps Engineer, Cloud Architect'],
        ['name' => 'Emily Johnson', 'roles' => 'Frontend Developer, UI Designer'],
        ['name' => 'Michael Brown', 'roles' => 'Backend Developer, Database Admin'],
        ['name' => 'Sarah Davis', 'roles' => 'QA Engineer, Automation Specialist'],
        ['name' => 'James Wilson', 'roles' => 'Full Stack Developer, CTO'],
        ['name' => 'Emma Martinez', 'roles' => 'Marketing Manager, Content Strategist'],
        ['name' => 'David Lee', 'roles' => 'Cybersecurity Expert, System Administrator'],
        ['name' => 'Olivia White', 'roles' => 'Project Manager, Scrum Master']
    ];
    
    ?>
    <div class="content">
        <article>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Iusto praesentium sapiente fugiat consectetur non earum cum reprehenderit magnam nulla error, maiores porro blanditiis accusamus quam, recusandae id repellat velit laborum!</p>
        </article>
    </div>
    <div class="content">
    <section>

        <?php

        foreach ($profiles as $profile) {
        echo '
        <div class="profile-card">
            <div class="empty-pfp">?</div>
            <h2>' . $profile['name'] . '</h2>
            <p class="roles">' . $profile['roles'] . '</p>
        </div>';
        }

        ?>
        
    </section>
    </div>
</body>
</html>