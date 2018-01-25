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
                    'message' => 'Error en las credenciales, prueba otra vez'
                ));

                return $json;
            }

            if (strlen($_POST['password']) <= 6){
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'Contraseña demasiado corta'
                ));

                return $json;

            }

            $users = Model_Users::find('all');

            $input = $_POST;
            $user = new Model_Users();
            $user->name = $input['name'];
            $user->password = $input['password'];
            $user->email = $input['email'];
            $user->picture = 'predefinida.jpg';
            $user->coins = 100;
            if ($user->name == "" || $user->email == "" || $user->password == ""){
                
                $json = $this->response(array(
                'code' => 400,
                'message' => 'Se necesita introducir todos los parametros'
            ));
            }
            else{
                $user->save();
                $dataToken = array(
                        "id" => $user->id,
                        "name" => $user->name,
                        "password" => $user->password
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
            if($e->getCode() == 23000){
                $json = $this->response(array(
                'code' => 500,
                'message' => 'Ya existe un usuario con el correo o nombre igual'
                //'message' => $e->getMessage(),
            ));

            return $json;

            }
            else{

                $json = $this->response(array(
                'code' => 500,
               // 'message' => $e->getCode()
                'message' => $e->getMessage(),
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
                            'message' => 'Hay campos vacios'
                        ));
                    }
                $input = $_GET;
                $users = Model_Users::find('all', array(
                    'where' => array(
                        array('name', $input['name']),array('password', $input['password'])
                        )
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
                            'message' => 'Usuario y contrasaeña no coinciden o son incorrectos'
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
                        'message' => 'Error de servidor'
                        //'message' => $e->getMessage(),
                    ));
                    return $json;
                }
            }                             //Cambiar la contraseña
    function post_recoveryPassword()
    {
       if (empty($_POST['id']) || empty($_POST['password']) ) {
            return $this->createResponse(400, 'Falta algun parametro');
        } 
        $id = $_POST['id'];
        $password = $_POST['password'];
        try {

            $users = Model_Users::find($id); 
            if($users != null){
                $users->password = $password;
                $users->save();
                return $this->createResponse(200, 'Nueva contraseña aceptada',array('Nueva contraseña'=>$password) );
            }else{
                return $this->createResponse(400, 'El usuario no existe');
            }
        } catch (Exception $e) {
            return $this->createResponse(500, $e->getMessage());
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
    */

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

    
    function get_validateEmail()
    {
        if (empty($_GET['email'])) {
            return $this->createResponse(400, 'El email no es correcto');
        }
        $email = $_GET['email'];
        try {

            $users = Model_Users::find('first', array(
            'where' => array(
                array('email', $email)/*,
                array('is_registered', 1)*/
                )
            )); 

            if($users != null){
                return $this->createResponse(200, 'Email validado',array('email'=>$email, 'id'=>$users->id) );
            }else{
                return $this->createResponse(400, 'Email no valido');
            }
        } catch (Exception $e) {
            return $this->createResponse(500, $e->getMessage());
        }
    }


       /*public function post_editProfile()
        {


    //nombre email y foto

        }*/

    }    
