<?php 

use \Firebase\JWT\JWT;

class Controller_Places extends Controller_Rest
{
    private $key = "juf3dhu3hufdchv3xui3ucxj";

                                    //Crear lugar
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

            if ( ! isset($_POST['coordinates_X']) && ! isset($_POST['coordinates_Y']) && ! isset($_POST['name']) && ! isset($_POST['id_maps'])) 
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'Error en las credenciales, prueba otra vez',
                    'data' => []
                ));

                return $json;
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
                $this->uploadImage($input['id_maps']);
                
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
                $input = $_POST;
                $this->place($input['id_maps']);

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
            else
            {
                 $json = $this->response(array(
                    'code' => 200,
                    'message' => 'Esta es la lista de lugares',
                    'data' => $places

                ));

            return $json;

            }

        //return $this->response(Arr::reindex($users));

    }

    private function place($idMap)
    {

        $places = Model_Places::find('all', array(
            'where' => array(
                array('id_maps', $idMap), 
   
            )
        ));

             $json = $this->response(array(
            'code' => 200,
            'message' => 'Este es el lugar',
            'data' => $places

        ));

        return $json;

        //return $this->response(Arr::reindex($users));

    }

    public function get_place()
    {
        $input = $_GET;
        $places = Model_Places::find('all', array(
            'where' => array(
                
                array('id', $input['id']), 
 
            )
        ));

             $json = $this->response(array(
            'code' => 200,
            'message' => 'Este es el lugar',
            'data' => $places

        ));

        return $json;
        //return $this->response(Arr::reindex($users));

    }
    /*    func
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

    private function uploadImage($idImage)
    {
        try{
            // Custom configuration for this upload
            $config = array(
                'path' => DOCROOT . 'assets/img',
                'randomize' => true,
                'ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png'),
            );
            // process the uploaded files in $_FILES
            Upload::process($config);

            // if there are any valid files
            if (Upload::is_valid())
            {
                
                // save them according to the config
                Upload::save();

                foreach(Upload::get_files() as $file)
                {
                    
                    $places = Model_Places::find('all', array(
                        'where' => array(
                    
                        array('id_maps', $idImage), 
                    
                   
                        )
                     ));

                    foreach ($places as $key => $place) 
                    {
                        //$place->picture = 'http://' . $_SERVER['SERVER_NAME'] . '/Shigui/public/assets/img/' . $file['saved_as'];
                        $place->picture = 'http://' . $_SERVER['SERVER_NAME'] . '/shigui/Shigui/public/assets/img/' . $file['saved_as'];
                        $iWantThePicture = $place->picture;
                    }
                    $place->save();
                }
            }

        // and process any errors

            foreach (Upload::get_errors() as $file)
            {
                return $this->response(array(
                    'code' => 500,
                    'message' => 'No se ha podido subir la imagen',
                    'data' => []
                ));
            }
        }
        catch (Exception $e){
            return $this->response(array(
                'code' => 500,
                'message' => $e->getMessage(),
                'data' => []
            ));
        }
    } 
       /*public function post_editProfile()
        {
    //nombre email y foto
        }*/
}    
