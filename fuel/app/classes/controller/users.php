<?php 

class Controller_Users extends Controller_Rest
{

    public function post_create()
    {
        try {
            if ( ! isset($_POST['name']) && ! isset($_POST['password'])) 
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'parametro incorrecto, se necesita que el parametro se llame name'
                ));

                return $json;
            }

            $input = $_POST;
            $user = new Model_Users();
            $user->name = $input['name'];
            $user->password = $input['password'];
            $user->save();

            $json = $this->response(array(
                'code' => 200,
                'message' => 'usuario creado',
                'data' => ['username' => $input['name']]
            ));

            return $json;

        } 
        catch (Exception $e) 
        {
            $json = $this->response(array(
                'code' => 500,
                'message' => 'Error interno del servidor'
                //'message' => $e->getMessage(),
            ));

            return $json;
        }        
    }

    public function get_users()
    {
    	$users = Model_Users::find('all');

    	return $this->response(Arr::reindex($users));

    }

    public function post_delete()
    {
        $user = Model_Users::find($_POST['id']);
        $userName = $user->name;
        $user->delete();

        $json = $this->response(array(
            'code' => 200,
            'message' => 'usuario borrado',
            'name' => $userName
        ));

        return $json;
    }

    public function get_login()
    {
        $users = Model_Users::find('all', array('where' => array(array('name', $input['name']),array('password', $input['password']) )));

        use \Firebase\JWT\JWT;

        $key = "users";
        $token = array(
            "id" => "id",
            "name" => "name",
            "password" => "password"
        );

        $jwt = JWT::encode($token, $key);
        $decoded = JWT::decode($jwt, $key, array('HS256'));

        print_r($decoded);

        $decoded_array = (array) $decoded;

        JWT::$leeway = 60; // $leeway in seconds
        $decoded = JWT::decode($jwt, $key, array('HS256'));
            }


}