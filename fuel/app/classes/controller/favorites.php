<?php 

use \Firebase\JWT\JWT;

class Controller_Favorites extends Controller_Rest
{
    private $key = "juf3dhu3hufdchv3xui3ucxj";

   

                                    //Crear usuario
    public function post_create()
    {
        try {

            try
            {
                $headers = apache_request_headers();
                $token = $headers['Authorization'];
                $dataJwtUser = JWT::decode($token, $this->key, array('HS256'));

        
      

                $users = Model_Users::find('all', array(
                    'where' => array(
                        array('id', $dataJwtUser->id),
                        array('name', $dataJwtUser->name),
                        array('password', $dataJwtUser->password)
               
                    )
                 ));

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
            if ( ! isset($_POST['id_maps'])) 
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'Error en las credenciales, prueba otra vez',
                    'data' => []
                ));

                return $json;
            }
             

            $input = $_POST;
            $places = Model_Places::find('all', array(
            'where' => array(
                array('id_maps', $input['id_maps']),
                
               
                )
            )); 

            foreach ($places as $key => $place) 
            {
            $idPlace = $place->id;
            $namePlace = $place->name;
            }

            


                


    
            $favorites = new Model_Favorites();
            
            $favorites->place = $namePlace;
            $favorites->id_place = $idPlace ;
            $favorites->id_user = $dataJwtUser->id;
            
            

          
            
            
            
            if ($favorites->id_user == "" || $favorites->id_place == "" || $favorites->place == "" )
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'Se necesita introducir todos los parametros',
                    'data' => []
                ));
            }
            else
            {

                $favorites->save();
                

                $json = $this->response(array(
                    'code' => 200,
                    'message' => 'Lugar enviado a favoritos correctamente',
                    'data' => $favorites
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
                    'message' => $e->getMessage(),
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
    


    
    public function get_favorites()
    {

        try
            {
                $headers = apache_request_headers();
                $token = $headers['Authorization'];
                $dataJwtUser = JWT::decode($token, $this->key, array('HS256'));

        
      

                $users = Model_Users::find('all', array(
                    'where' => array(
                        array('id', $dataJwtUser->id),
                        array('name', $dataJwtUser->name),
                        array('password', $dataJwtUser->password)
               
                    )
                 ));

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
       

        


        $favorites = Model_Favorites::find('all', array(
            'where' => array(
                array('id_user', $dataJwtUser->id),
                
               
            )
        ));

        if(empty($favorites))
        {
            $json = $this->response(array(
                'code' => 200,
                'message' => 'No hay favoritos que mostrar',
                'data' => ''

            ));

            return $json;

        }
        else
        {
            $favoritesFormated = [];
            foreach ($favorites as $key => $valuation) 
            {
                $favoritesFormated[] = $valuation; 
            }


            
            $json = $this->response(array(
                'code' => 200,
                'message' => 'Esta es la lista de favoritos',
                'data' => $favoritesFormated

            ));

            return $json;

        }

       
        //return $this->response(Arr::reindex($users));

    }


    public function get_favorite()
    {

        try
            {
                $headers = apache_request_headers();
                $token = $headers['Authorization'];
                $dataJwtUser = JWT::decode($token, $this->key, array('HS256'));

        
      

                $users = Model_Users::find('all', array(
                    'where' => array(
                        array('id', $dataJwtUser->id),
                        array('name', $dataJwtUser->name),
                        array('password', $dataJwtUser->password)
               
                    )
                 ));

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
       

        $input = $_GET;

        $favorites = Model_Favorites::find('all', array(
            'where' => array(
                array('id_user', $dataJwtUser->id),
                array('id_place', $input['id']),
                
               
            )
        ));

        if(empty($favorites))
        {
            $json = $this->response(array(
                'code' => 200,
                'message' => 'No hay favoritos que mostrar',
                'data' => ''

            ));

            return $json;

        }
        else
        {
            $favoritesFormated = [];
            foreach ($favorites as $key => $valuation) 
            {
                $favoritesFormated[] = $valuation; 
            }


            
            $json = $this->response(array(
                'code' => 200,
                'message' => 'Esta es el favorito',
                'data' => $favoritesFormated

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




    public function post_delete()
    {
        
        try
        {
            $headers = apache_request_headers();
            $token = $headers['Authorization'];
            $dataJwtUser = JWT::decode($token, $this->key, array('HS256'));

    
  

            $users = Model_Users::find('all', array(
                'where' => array(
                    array('name', $dataJwtUser->name),
                    array('password', $dataJwtUser->password)
                )
             ));

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

        $input = $_POST;

        
        



        

       

        


        $favorites = Model_Favorites::find('all', array(
            'where' => array(
                array('id_user', $dataJwtUser->id),
                array('id_place', $input['id']), 
                
               
            )
        ));







        foreach ($favorites as $key => $valuation) 
        {
            $modelFavorites = $valuation;
        }



        



       


        try
        {
           $modelFavorites->delete(); 
        }
        catch (Exception $e)
        {

        }


        
        

        $json = $this->response(array(
            'code' => 200,
            'message' => 'Favorito borrado',
            'data' => ''
        ));

            return $json;
    }
    /*    

    



       /*public function post_editProfile()
        {


    //nombre email y foto

        }*/

    }    
