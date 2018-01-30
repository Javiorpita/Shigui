<?
class hola_mundo
{
    public function mostrar_holamundo()
    {
        $data['title']   = "hola mundo";
        $data['content'] = "hola mundo";

        // returned Response object takes precedence and will show content without template
        return new Response(View::forge('index/test', $data));
    }
}