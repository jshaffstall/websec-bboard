<?php

require 'db_config.php';

function add_user($name, $email, $password)
{
    global $pdo;
    
    if (get_user($email))
        return "A user with that email already exists";

    if (get_user_by_name($name))
        return "A user with that name already exists";
    
    $sql = "INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, 2)";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':password', $password);
    //$stmt->bindValue(':password', password_hash ($password, PASSWORD_BCRYPT));
    
    $stmt->execute();
    
    return null;
}

function login_user ($email, $password)
{
    global $pdo;

    $sql = "SELECT * FROM users where email=:email";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':email', $email);
    
    $stmt->execute();
    
    if ($stmt->rowCount() == 0)
        return False;
    
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($password == $user['password'])
        return $user;
    
    //if (password_verify ($password, $user['password']))
    //    return $user;
    
    return False;
}

function get_user ($email)
{
    global $pdo;

    $sql = "SELECT * FROM users where email=:email";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':email', $email);
    
    $stmt->execute();
    
    if ($stmt->rowCount() == 0)
        return False;
    
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    return $user;
}

function get_user_by_name ($name)
{
    global $pdo;

    $sql = "SELECT * FROM users where name=:name";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':name', $name);
    
    $stmt->execute();
    
    if ($stmt->rowCount() == 0)
        return False;
    
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    return $user;
}

function get_user_by_id ($userid)
{
    global $pdo;

    $sql = "SELECT * FROM users where id=:userid";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':userid', $userid);
    
    $stmt->execute();
    
    if ($stmt->rowCount() == 0)
        return False;
    
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    return $user;
}

function add_post ($user, $content)
{
    global $pdo;

    // Simulate what the SQL would be if we weren't using prepared statements
    // so we can experiment with SQL injection ideas
    $sql_used = "INSERT INTO posts (user, post) VALUES ('".$user['id']."', '".$content."')";

    $sql = "INSERT INTO posts (user, post, sql_used) VALUES (:user, :post, :sql_used)";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':user', $user['id']);
    $stmt->bindValue(':post', $content);
    $stmt->bindValue(':sql_used',  $sql_used);
    
    $stmt->execute();
}

function get_recent_posts($count)
{
    global $pdo;
    
    $sql = "SELECT posts.id,posts.user,posts.post,posts.sql_used,posts.posted_date,users.name,users.email FROM posts,users WHERE posts.user = users.id ORDER BY posted_date DESC LIMIT :count";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':count', $count, PDO::PARAM_INT);
    
    $stmt->execute ();

    return $stmt;
}

function update_user_profile($person, $about, $filefield)
{
    global $pdo;
    global $PROFILES;

    $file_found = false;
    
    // If a profile pic has been sent, we need to move it to the right spot
    if (array_key_exists($filefield, $_FILES))
    {
        if (is_uploaded_file($_FILES[$filefield]['tmp_name']))
        {
            $file_contents = file_get_contents($_FILES[$filefield]['tmp_name']);
            
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $content_type = finfo_file($finfo, $_FILES[$filefield]['tmp_name']);
            finfo_close($finfo);
            
            // Only allow JPG or PNG
            if ($content_type == 'image/jpeg' || $content_type == 'image/png')
            {
                move_uploaded_file($_FILES[$filefield]['tmp_name'], $PROFILES.$person['name']);
                $file_found = true;
            }
        }
    }
    
    if ($file_found)
        $sql = "UPDATE users SET about=:about, profile_pic=:name WHERE id=:userid";
    else
        $sql = "UPDATE users SET about=:about WHERE id=:userid";
    
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':about', $about);
    $stmt->bindValue(':userid', $person['id']);
    
    if ($file_found)
        $stmt->bindValue(':name', $person['name']);
    
    $stmt->execute ();
}

function delete_post($postid)
{
    global $pdo;
    
    $sql = "DELETE FROM posts WHERE id=$postid";
    //$sql = "DELETE FROM posts WHERE id=:postid";
    $stmt = $pdo->prepare($sql);
    
    //$stmt->bindValue(':postid', $postid);
    
    $stmt->execute();
}
