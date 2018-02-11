<?php 

use \Firebase\JWT\JWT;

class Controller_Places extends Controller_Rest
{
    private $key = "juf3dhu3hufdchv3xui3ucxj";

   

                                    //Crear usuario
    public function post_create()
    {
        try {

            try
            {
                $this->validateToken();
            }
            catch (Exception $e)
            {
               
            }

            $input = $_POST;

                


    
            $place = new Model_Places();
            $place->coordinates_X = $input['coordinates_X'];
            $place->coordinates_Y = $input['coordinates_Y'];
            $place->id_maps = $input['id_maps'] ;
            $place->name = $input['name'];
            $place->picture = '';
            
            
            
            if ($place->name == "" || $place->coordinates_Y == "" || $place->coordinates_X == "" || $place->id_maps == "")
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'Se necesita introducir todos los parametros',
                    'data' => []
                ));
            }
            else
            {

                $place->save();
                

                $json = $this->response(array(
                    'code' => 200,
                    'message' => 'Lugar creado correctamente',
                    'data' => $place
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
                    'message' => 'Ya esta registrado el lugar',
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
    


    public function get_places()
    {
         try
            {
                $this->validateToken();
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
        $places = Model_Places::find('all');
        if(empty($places))
        {
             $json = $this->response(array(
            'code' => 200,
            'message' => 'No hay lugares que mostrar',
            'data' => ''

        ));

        return $json;


        }
        else{
             $json = $this->response(array(
            'code' => 200,
            'message' => 'Esta es la lista de lugares',
            'data' => $places

        ));

        return $json;

        }

       
        //return $this->response(Arr::reindex($users));

    }
    /*    function decodeToken()
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

    function validateToken()
    {
        $headers = apache_request_headers();
        $token = $headers['Authorization'];
        $dataJwtUser = JWT::decode($token, $this->key, array('HS256'));
        
        //$dataJwtPassword = JWT::encode($dataJwtUser->password, $this->key);

        $users = Model_Users::find('all', array(
            'where' => array(
                array('id', $dataJwtUser->id),
                array('name', $dataJwtUser->name),
                array('password', $dataJwtUser->password)
               
            )
        ));

        if($users != null){
            return true;
        }else{
            return false;
        }
    }

    



       /*public function post_editProfile()
        {


    //nombre email y foto

        }*/

    }    
