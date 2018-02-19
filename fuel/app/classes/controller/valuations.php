<?php 

use \Firebase\JWT\JWT;

class Controller_Valuations extends Controller_Rest
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
                

                foreach ($users as $key => $user) 
                {


                    $picture = $user->picture;
                    
                   
                    
                }
                 
                

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


            if ( ! isset($_POST['id_maps']) && ! isset($_POST['value']) && ! isset($_POST['comentary'])) 
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

            


                


    
            $valuations = new Model_Valuations();
            $valuations->value = $input['value'];
            $valuations->comentary = $input['comentary'];
            $valuations->id_place = $idPlace ;
            $valuations->id_users = $dataJwtUser->id;
            $valuations->date = date('d-m-Y/h:i:s');
            $valuations->place = $namePlace ;
            $valuations->user = $dataJwtUser->name;

            $valuations->user_picture = $picture;
            

           
            
            
            
            if ($valuations->value == "" || $valuations->id_place == "" ||  $valuations->id_users == "" || $valuations->date == "" || $valuations->place == "" || $valuations->user == ""   )
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'Se necesita introducir todos los parametros',
                    'data' => []
                ));
                return $json;
            }
            elseif ($valuations->value < 1 || $valuations->value > 5)
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'La valoracion ha de estar entre 1 y 5',
                    'data' => []
                ));

            }
            elseif (strlen($valuations->comentary) > 180)
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'Numero de caracteres excedido',
                    'data' => []
                ));
                return $json;
            }

            else
            {

                $valuations->save();
                

                $json = $this->response(array(
                    'code' => 200,
                    'message' => 'Valoracion creada correctamente',
                    'data' => $valuations
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
    


    public function get_valuations()
    {
        try
        {
            $this->validateToken();
        }
        catch (Exception $e)
        {
            
        }

        $input = $_GET;

        $places = Model_Places::find('all', array(
            'where' => array(
                array('id_maps', $input['id_maps']),
                
               
            )
        )); 


        foreach ($places as $key => $place) 
        {
            $idPlace = $place->id;
        
        }
        
    
       


        $valuations = Model_Valuations::find('all', array(
            'where' => array(
                array('id_place', $idPlace),
                
               
            )
        ));

        if(empty($valuations))
        {
            $json = $this->response(array(
                'code' => 200,
                'message' => 'No hay valoraciones que mostrar',
                'data' => ''

            ));

            return $json;

        }
        else
        {
               
           



            //array_push($valuations, "manzana", "arándano");
            $valuationsFormated = [];
            foreach ($valuations as $key => $valuation) 
            {
                $valuationsFormated[] = $valuation; 

               


                 
            }
            


            
            $json = $this->response(array(
                'code' => 200,
                'message' => 'Esta es la lista de valoraciones',
                'data' => $valuationsFormated

            ));

            return $json;

        }

       
        //return $this->response(Arr::reindex($users));

    }

    public function get_valuationsAverage()
    {


        try
            {
                $this->validateToken();
            }
            catch (Exception $e)
            {
                
            }


        $input = $_GET;


        $places = Model_Places::find('all', array(
            'where' => array(
                array('id_maps', $input['id_maps']),
                
               
            )
        )); 
        

            foreach ($places as $key => $place) 
            {
            $idPlace = $place->id;
            }

       



            $valuations = Model_Valuations::find('all', array(
                'where' => array(
                    array('id_place', $idPlace),
                
               
                )
            ));
        
        

        
        $rising = 0;

        $divide = 0;
        $valuationsFormated = [];
        foreach ($valuations as $key => $valuation)
        {
            $valuationsFormated[] = $valuation; 
            
            
        }

        foreach ($valuationsFormated as $key => $valuation)
        {
            
            $rising += $valuationsFormated[$key]->value;

            $divide += 1;
            
        }
        if ($divide == 0)
        {
            $divide = 1;
        }

        $rising /= $divide;

        if(empty($valuations))
        {
             $json = $this->response(array(
            'code' => 200,
            'message' => 'No hay media disponible',
            'data' => ''

        ));

        return $json;


        }
        else{
             $json = $this->response(array(
            'code' => 200,
            'message' => 'Esta es la  valoracion media',
            'data' => [$rising]

        ));

        return $json;

        }

    }

    public function get_userValuations()
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
       

        


        $valuations = Model_Valuations::find('all', array(
            'where' => array(
                array('id_users', $dataJwtUser->id),
                
               
            )
        ));

        if(empty($valuations))
        {
            $json = $this->response(array(
                'code' => 200,
                'message' => 'No hay valoraciones que mostrar',
                'data' => ''

            ));

            return $json;

        }
        else
        {
            $valuationsFormated = [];
            foreach ($valuations as $key => $valuation) 
            {
                $valuationsFormated[] = $valuation; 
            }


            
            $json = $this->response(array(
                'code' => 200,
                'message' => 'Esta es la lista de valoraciones',
                'data' => $valuationsFormated

            ));

            return $json;

        }

       
        //return $this->response(Arr::reindex($users));

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

        if($input['id_maps'] == '')
        {
            $json = $this->response(array(
                    'code' => 500,
                    'message' => 'id_maps vacio',
                    'data' => []
                ));
                return $json;
        }

        $places = Model_Places::find('all', array(
            'where' => array(
                array('id_maps', $input['id_maps']),
                
               
            )
        ));
        
        if( empty($places)) 
        {
            $json = $this->response(array(
                    'code' => 400,
                    'message' => 'id no encontrado',
                    'data' => []
                ));
                return $json;

        } 



        foreach ($places as $key => $place) 
        {
            $idPlace = $place->id;
        }

       

        


        $valuations = Model_Valuations::find('all', array(
            'where' => array(
                array('id_users', $dataJwtUser->id),
                array('id_place', $idPlace), 
                
               
            )
        ));





        foreach ($valuations as $key => $valuation) 
        {
            $modelValuation = $valuation;
        }

        



       


        Model_Valuations::find($modelValuation);


        try
        {
           $modelValuation->delete(); 
        }
        catch (Exception $e)
        {

        }

        
        

        $json = $this->response(array(
            'code' => 200,
            'message' => 'Valoracion borrada',
            'data' => ''
        ));

            return $json;
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
