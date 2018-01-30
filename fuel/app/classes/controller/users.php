<?php 

use \Firebase\JWT\JWT;

class Controller_Users extends Controller_Rest
{
    private $key = "juf3dhu3hufdchv3xui3ucxj";

    private $getEmail = "";

                                    //Crear usuario
    public function post_create()
    {
        try {
            if ( ! isset($_POST['name']) && ! isset($_POST['password'])) 
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'Error en las credenciales, prueba otra vez',
                    'data' => []
                ));

                return $json;
            }

            if (strlen($_POST['password']) < 6 || strlen($_POST['password']) >12){
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'Contraseña: entre 6 y 12 caracteres',
                    'data' => []
                ));

                return $json;

            }

            $users = Model_Users::find('all');

            $input = $_POST;
            $user = new Model_Users();
            $user->name = $input['name'];
            $user->password = $input['password'];
            $user->email = $input['email'];
            $user->picture = '';
            $user->coins = 100;
            if ($user->name == "" || $user->email == "" || $user->password == "")
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'Se necesita introducir todos los parametros',
                    'data' => []
                ));
            }
            else
            {
                $user->save();
                $dataToken = array(
                        "id" => $user->id,
                        "name" => $user->name,
                        "password" => $user->password,
                        "email" => $user->email
                    );

                $token = JWT::encode($dataToken, $this->key);

                $json = $this->response(array(
                    'code' => 200,
                    'message' => 'Usuario creado correctamente',
                    'data' => ['token' => $token, 'username' => $input['name']]
                ));

                return $json;
            }
            
        } 
        catch (Exception $e) 
        {
            if($e->getCode() == 23000)
            {
                $json = $this->response(array(
                    'code' => 500,
                    'message' => 'Ya existe un usuario con el correo o nombre igual',
                    'data' => []
                //'message' => $e->getMessage(),
                ));

                return $json;

            }
            else
            {

                $json = $this->response(array(
                    'code' => 500,
               // 'message' => $e->getCode()
                    'message' => $e->getMessage(),
                    'data' => []
                ));

                return $json;

            }  
        }        
    }
                                    //Mostrar usuarios
    public function get_users()
    {
    	$users = Model_Users::find('all');

        $json = $this->response(array(
            'code' => 500,
            'message' => 'Esta es la lista de usuarios',
            'data' => $users

        ));

        return $json;

    	//return $this->response(Arr::reindex($users));

    }
                                    //Eliminar usuario
    public function post_delete()
    {
        $user = Model_Users::find($_POST['id']);
        $userName = $user->name;
        $user->delete();

        $json = $this->response(array(
            'code' => 200,
            'message' => 'Usuario borrado',
            'name' => $userName
        ));

            return $json;
    }
                                    //login del usuario
    public function get_login()
    {
    try {
            if ( empty($_GET['name']) || empty($_GET['password']))
            {
                return $this->response(array(
                    'code' => 400,
                    'message' => 'Hay campos vacios',
                    'data' => []
                ));
            }
            $input = $_GET;
            $users = Model_Users::find('all', array(
                    'where' => array(
                        array('name', $input['name']),
                        array('password', $input['password']))          
                    ));
            if ( ! empty($users) )
            {
                foreach ($users as $key => $value)
                {
                    $id = $users[$key]->id;
                    $name = $users[$key]->name;
                    $password = $users[$key]->password;
                }
            }
            else
            {
                return $this->response(array(
                    'code' => 400,
                    'message' => 'Usuario y password no coinciden o son incorrectos',
                    'data' => []
                    ));
            }
                
            $dataToken = array(
                "id" => $id,
                "name" => $name,
                "password" => $password
                );

            $token = JWT::encode($dataToken, $this->key);

            return $this->response(array(
                'code' => 200,
                'message'=> 'Login correcto',
                'data' => ['token' => $token, 'name' => $name]
                ));
                        
        } 
        catch (Exception $e)
            {
                $json = $this->response(array(
                    'code' => 500,
                    'message' => 'Error de servidor',
                    'data' => []
                    //'message' => $e->getMessage(),
                ));
                return $json;
            }
        }
                                     //Cambiar la contraseña
    public function post_recoveryPassword()
    {
        try {
            if ( empty($_POST['email'])) 
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' =>  'Parametro email no introducido',
                    'data' => []
                ));
                return $json;
            }
            // Validación de e-mail
            $input = $_POST;
            $users = Model_Users::find('all', array(
                'where' => array(
                    array('email', $input['email'])
                )
            ));
            if ( ! empty($users) )
            {
                foreach ($users as $key => $value)
                {
                    $id = $users[$key]->id;
                    $email = $users[$key]->email;

                }
            }
            else
            {
                return $this->response(array(
                    'code' => 400,
                    'message' => 'El email introducido no existe',
                    'data' => []
                    ));
            }
            
                $tokendata = array(
                    'id' => $id,
                    'email' => $email
                );
                $token = JWT::encode($tokendata, $this->key);
                $json = $this->response(array(
                    'code' => 200,
                    'message' => 'Email validado',
                    'data' => ['token' => $token]
                ));
                return $json;
            
        }
        catch (Exception $e)
        {
            $json = $this->response(array(
                'code' => 500,
                'message' => $e->getMessage(),
                'data' => []
            ));
            return $json;
        }
    }

    function post_changePassword()
    {

        try
        {
            $header = apache_request_headers();
            if (isset($header['Authorization'])) 
                {
                    $token = $header['Authorization'];
                    $dataJwtUser = JWT::decode($token, $this->key, array('HS256'));
                }

            if (empty($_POST['password'])) 
                {
                    $json = $this->response(array(
                        'code' => 400,
                        'message' =>  'No puede haber campos vacios',
                        'data' => []
                    ));
                    return $json;
                }

            if (strlen($_POST['password']) < 6 || strlen($_POST['password']) >12){
                    $json = $this->response(array(
                        'code' => 400,
                        'message' => 'Contraseña: entre 6 y 12 caracteres',
                        'data' => []
                    ));

                    return $json;

                }

                $input = $_POST;
                $user = Model_Users::find($dataJwtUser->id);
                $user->password = $input['password'];
               
                $user->save();
                                
                $json = $this->response(array(
                    'code' => 200,
                    'message' =>  'Contraseña cambiada correctamente',
                    'data' => []
                ));
                return $json;
              
           
        }
        catch (Exception $e)
        {
            $json = $this->response(array(
                'code' => 500,
                'message' => $e->getMessage(),
                'data' => []
            ));
            return $json;
        }
    }
    function post_modifyUser()
    {
        try {
            $header = apache_request_headers();

            if (isset($header['Authorization'])) 
                {
                    $token = $header['Authorization'];
                    $dataJwtUser = JWT::decode($token, $this->key, array('HS256'));
                }

            if (empty($_POST['name'] || $_POST['picture'])) 
                {
                    $json = $this->response(array(
                        'code' => 400,
                        'message' =>  'No puede haber campos vacios',
                        'data' => []
                    ));
                    return $json;
                }

                    $input = $_POST;
                    $user = Model_Users::find($dataJwtUser->id);
                    $user->name = $input['name'];
                    $user->picture = $input['picture'];
               
                    $user->save();
                                
                    $json = $this->response(array(
                        'code' => 200,
                        'message' =>  'Cambios realizados correctamente',
                        'data' => []
                ));
                return $json;
              
        } catch (Exception $e) {
            return $this->response(array(
                    'code' => 500,
                    'message' => $e->getMessage(),
                    'data' => []
                    ));
        }
    }
    
/*
        function decodeToken()
    {

        $jwt = apache_request_headers()['Authorization'];
        $token = JWT::decode($jwt, $this->key , array('HS256'));
        return $token;
    }

    function userNotRegistered($email)
    {

        $users = Model_Users::find('first', array(
            'where' => array(
                array('email', $email),
                array('is_registered', 0)
                )
            )); 

        if($users != null){
            return true;
        }else{
            return false;
        }
    }
    

    function validateToken($jwt)
    {
        $token = JWT::decode($jwt, $this->key, array('HS256'));

        $email = $token->data->email;
        $password = $token->data->password;
        $id = $token->data->id;

        $users = Model_Users::find('all', array(
            'where' => array(
                array('email', $email),
                array('password', $password),
                array('id',$id)
                )
            ));
        if($users != null){
            return true;
        }else{
            return false;
        }
    }
*/
    



       /*public function post_editProfile()
        {


    //nombre email y foto

        }*/

    }    
