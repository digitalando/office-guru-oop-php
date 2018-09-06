<?php
require_once('./php/files.php');
require_once('./php/usersTokens.php');

define('USERS_FILE', __DIR__ . '/../data/users.json');
define('USERS_IMAGES_DIR', __DIR__ . '/../data/users/images/');
define('USERS_IMAGES_PATH', './data/users/images/');
define('USERS_IMAGES_MAX_SIZE', 5242800); // 5Mb
define('USERS_IMAGES_VALID_TYPES', ['image/gif', 'image/jpeg', 'image/png']);
define('PASSWORD_MIN_LENGTH', 8);

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
   Base de datos
   ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

//La llamamos en register.php donde le pasamos el post
function register(array $post)
{
    $fields = $post;

    if (!$errors = validateRegisterForm($fields)) 
    {   
        saveUser($fields);
    }

    return $errors;
}

function validateRegisterForm(array $fields)
{
    $errors = [];

    if(!isset($fields['first_name']) ||
        trim($fields['first_name']) == '')
    {
        $errors['first_name'] = 'Debe ingresar un nombre';
    }

    if(!isset($fields['last_name']) ||
        trim($fields['last_name']) == '')
    {
        $errors['last_name'] = 'Debe ingresar un apellido';
    }

    if(!isset($fields['email']) ||
        !filter_var($fields['email'], FILTER_VALIDATE_EMAIL)
    )
    {
        $errors['email'] = 'Debe ingresar un email válido';
    }

    elseif (findByField('email', $fields['email']))
    {
        $errors ['email']  = 'El mail está duplicado';
    }

    if(strlen($fields['password']) < PASSWORD_MIN_LENGTH)
    {
        $errors['password'] = 'La contraseña debe tener al menos ' . PASSWORD_MIN_LENGTH . ' caracteres';
    }
    elseif($fields['password'] != $fields['pass_confirm'])
    {
        $errors['pass_confirm'] = 'La contraseña y su confirmacióm deben coincidir';
    }

    return $errors;
}

function update(array $post, array $files)
{
    $fields = $post;
    $images = $files;

    if (!$errors = validateProfileForm($fields, $images)) 
    {   
        updateUser($fields, $images);
    }

    return $errors;
}

function validateProfileForm(array $fields, array $files)
{
    $errors = [];
    $user = findByField('email', $fields['email']);

    if(!isset($fields['first_name']) ||
        trim($fields['first_name']) == '')
    {
        $errors['first_name'] = 'Debe ingresar un nombre';
    }

    if(!isset($fields['last_name']) ||
        trim($fields['last_name']) == '')
    {
        $errors['last_name'] = 'Debe ingresar un apellido';
    }

    if(!isset($fields['email']) ||
        !filter_var($fields['email'], FILTER_VALIDATE_EMAIL)
    )
    {
        $errors['email'] = 'Debe ingresar un email válido';
    }

    // TODO Preguntar por qué esto no funciona
    // elseif ($user = findByField('email', $fields['email']) && $user['id'] != $fields['id'])
    
    elseif ($user && $user['id'] != $fields['id'])
    {
        $errors ['email']  = 'El mail está duplicado';
    }

    elseif (isset($files['image']) && $files['image']['size'] !== 0)
    {
        $image = $files['image']['tmp_name'];
        if (file_exists($image))
        {
            $imageSizeData = getimagesize($image);
            if (!$imageSizeData || !in_array($imageSizeData['mime'], USERS_IMAGES_VALID_TYPES))
            {
                $errors ['image']  = 'El archivo no es un tipo de imágen válida. Se aceptan los formato JPG, GIF y PNG';
            }
            elseif ($files['image']['tmp_name'] > USERS_IMAGES_MAX_SIZE) {
                $errors ['image']  = 'El archivo no puede ser mayor a 5Mb.';   
            }
        }
        else
        {
            $errors ['image']  = 'Ha ocurrido un error al subir la imagen.';
        }
    }

    return $errors;
}

function generateRecoverToken($email) {
    if(!($user = findByField('email', $email)))
    {
        return false;
    } 
    else 
    {
        $token = new UsersTokens($user['id']);
        return $token->generate();
    }    
    
}

function validateRecoverToken($link) {
    return UsersTokens::findByField('token', $link);
}

function findByField($field, $value)
{
    // @var array $users
    $users = listUsers();

    foreach ($users as $user) 
    {
        if (strtolower(trim($user [$field])) == strtolower(trim($value))) {
            return $user;
        }
    }

    return false;
}

function deleteById($id)
{
    // @var array $users
    $users = listUsers();

    foreach ($users as $key => $user) {
        if ($user['id'] == $id) {
            unset($users[$key]);
            saveUsersFile($users);
        }
    }
}

function saveUsersFile(array $users = [])
{
    $content = [
        'users' => $users
    ];

    file_put_contents(USERS_FILE, json_encode($content));
}

function listUsers()
{

    if (!file_exists(USERS_FILE))
    {
        saveUsersFile();
    }

    $users = file_get_contents(USERS_FILE);

    $users = json_decode($users, true);

    return $users['users'];
}


function saveUser (array $data)
{
    
    $data['email'] = strtolower (trim($data['email']));

    $data['password'] = password_hash ($data['password'], PASSWORD_DEFAULT);
    unset($data['pass_confirm']);

    $data['newsletter'] = $data['newsletter'] ?? 'off';

    //id - hacer un autonumerico encontrando el id más grande y sumando 1
    $data['id'] = nextId();

    $users = listUsers();
    $users[] = $data;

    saveUsersFile($users);  

    saveSession($data);
}


function updateUser (array $data, array $files = [])
{
    // Busco el usuario en la base
    $user = findByField('id', $data['id']);
    
    // Reemplazo los valores con lo que llega
    $user['first_name'] = $data['first_name'];

    $user['last_name'] = $data['last_name'];

    $user['email'] = strtolower (trim($data['email']));

    if (isset($data['image'])) {
        $user['image'] = $data['image'];
    }

    // TODO ¿Esto está bien?
    if (isset($files['image'])
        && $files['image']['size'] != 0 
        && $image = fileUpload($files['image'], USERS_IMAGES_DIR)) 
    {
        $user['image'] = $image;
    }
    
    $user['newsletter'] = $data['newsletter'] ?? 'off';

    deleteById($user['id']);

    $users = listUsers();

    $users[] = $user;

    saveUsersFile($users);  

    saveSession($user);
}


function nextId ()
{
    $users = listUsers();

    $id=0;

    foreach ($users as $user) 
    {
        if ($id < $users['id']) 
        {
            $id = $users['id'];     
        }   
    }

    return $id+1;
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
   Sesiones y Cookies
   ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

function login(array $post)
{

    $data = $post;

    if (!$errors = validateLogin($data)) 
    {   
        //Chequear existencia del mail
        if(!($user = findByField('email', $data['email'])))
        {
            return ['email' => 'El email ingresado no esta registrado en nuestra base de datos'];
        }

        //chequear el password
        if(!password_verify($data['password'], $user['password']))
        {
            return ['password' => 'El password ingresado es inválido'];
        }

        //guardamos en la session
        saveSession($user);

        //suponiendo que chequeo el recordarme
        if(isset($data['remember_me']))
        {
            //guardamos la cookie de remember
            setcookie('og_user', $user['id'], 5*365*24*60*60+time());
        }

    }

    return $errors;
}


function validateLogin(array $data)
{
    $errors = [];

    if(!isset($data['email']) ||
        !filter_var($data['email'], FILTER_VALIDATE_EMAIL)
    )
    {
        $errors['email'] = 'Debe ingresar un email válido';
    }

    if(trim($data['password']) == '')
    {
        $errors['password'] = 'Debe ingresar un password';
    }

    return $errors;
}


function isLoggedIn()
{
    return isset($_SESSION['user']);
}

function saveSession($user)
{
    unset($user['password']);
    $_SESSION['user'] = $user;
}

function autoLogin()
{
    //chequear si ya esta logueado
    if(!isLoggedIn() && isset($_COOKIE['og_user']))
    {
        //leer cookie
        $userId = $_COOKIE['og_user'];

        //buscamos el usuario
        $user = findByField('id', $userId);

        //lo escribimos en la session
        if($user)
        {
            saveSession($user);
        }
    }

}

function autoLoginByUserId($userId)
{
    //chequear si ya esta logueado
    if($user = findByField('id', $userId))
    {
        saveSession($user);
    }

}


function logout()
{
    //borrar la variable user de la session
    unset($_SESSION['user']);
    //destruir la session
    session_destroy();
    //borrar la cookie de recordarme
    setcookie('og_user', 0, time() * -1);
}


