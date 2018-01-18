<?php 

use \Firebase\JWT\JWT;

class Controller_Usuarios extends Controller_Rest
{
    private $key = "juf3dhu3hufdchv3xui3ucxj";

    private $emailcoger = "";

                                    //Crear usuario
    public function post_create()
    {
        try {
            if ( ! isset($_POST['nombre']) && ! isset($_POST['password'])) 
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'Error en las credenciales, prueba otra vez'
                ));

                return $json;
            }

            $users = Model_Usuarios::find('all');

            $input = $_POST;
            $user = new Model_Usuarios();
            $user->nombre = $input['nombre'];
            $user->password = $input['password'];
            $user->email = $input['email'];
            $user->monedas = 100;
            if ($user->nombre == "" || $user->email == "" || $user->password == ""){
                $json = $this->response(array(
                'code' => 400,
                'message' => 'Se necesita introducir todos los parametros'
            ));
            }
            else{
                $user->save();

                $json = $this->response(array(
                    'code' => 200,
                    'message' => 'Usuario creado correctamente',
                    'data' => ['username' => $input['nombre']]
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
    public function get_usuarios()
    {
    	$users = Model_Usuarios::find('all');

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
        $user = Model_Usuarios::find($_POST['id']);
        $userName = $user->nombre;
        $user->delete();

        $json = $this->response(array(
            'code' => 200,
            'message' => 'Usuario borrado',
            'nombre' => $userName
        ));

        return $json;
    }
                                    //login del usuario
    public function get_login()
    {

        try {

                $input = $_GET;
                $user = Model_Usuarios::find('all', array(
                    'where' => array(
                        array('nombre', $input['nombre']),array('password', $input['password'])
                    )
                ));

                if ( ! empty($user) )
                {
                    foreach ($user as $key => $value)
                    {
                        $id = $user[$key]->id;
                        $username = $user[$key]->nombre;
                        $password = $user[$key]->password;
                    }
                }
                else
                {
                    return $this->response(array('Error de Autentificacion' => 401));
                }

                if ($username == $input['nombre'] and $password == $input['password'])
                {
                    $dataToken = array(
                        "id" => $id,
                        "nombre" => $username,
                        "password" => $password
                    );


                    $token = JWT::encode($dataToken, $this->key);

                    return $this->response(array(
                        'Login Correcto' => 220,
                        ['token' => $token, 'nombre' => $username]
                ));

                }
                else
                {
                return $this->response(array('Error de Autenticacion' => 401));
                }
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

    }                                       //Cambiar la contraseña
    public function post_changePassword()
        {
            $change = $_POST;
            $user = new Model_Usuarios();
            $user = Model_Usuarios::find('first', array(
                    'where' => array(
                        array('email', $change['email'])
                    )
                ));

            $user->password = $change['password'];

            $user->save();

            $json = $this->response(array(
                'code' => 200,
                'message' => 'Contraseña cambiada con exito',
                'data' => ['password' => $change['password']]
            ));

            return $json;
        }
    public function get_email()
        {

            try {

                $input = $_GET;
                $user = Model_Usuarios::find('first', array(
                    'where' => array(
                        array('email', $input['email']))
                ));

                if ( !empty($user))
                {
                    foreach ($user as $key => $value)
                    {
                        $id = $user[$key]->id;
                        $email = $user[$key]->email;
                    }


                    if ($email == $input['email'])
                    {
                        return $this->response(array(
                        '   Email verificado' => 220,
                            ['email' => $email]
                    ));

                    }
                }
                else
                {
                    return $this->response(array('Error de Autentificacion' => 401));
                }
                
                


                    

                
               
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

    }    
}