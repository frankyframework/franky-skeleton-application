<?php
function EliminarCategoriaBlog($id,$status)
{

	$MyCategoriaBlog = new modulos\blog\vendor\model\categoriasBlog();
        global $MyAccessList;
        global $MyMessageAlert;
         if($MyAccessList->MeDasChancePasar(ADMINISTRAR_CATEGORIAS_BLOG))
        {
            if($MyCategoriaBlog->delete(addslashes($id),addslashes($status)) == REGISTRO_SUCCESS)
            {


            }
            else
            {
		  $respuesta[] = array("message" => $MyMessageAlert->Message(($status == 1 ? "activar" : "eliminar")."_generico_error"));
            }
        }
        else
        {
             $respuesta[] = array("message" => $MyMessageAlert->Message("sin_privilegios"));
        }

	return $respuesta;
}

function EliminarArticuloBlog($id,$status)
{
				$Tokenizer = new \vendor\haxor\Tokenizer;
				$MyBlog = new modulos\blog\vendor\model\Blog();
        global $MyAccessList;
        global $MyMessageAlert;
         if($MyAccessList->MeDasChancePasar(ADMINISTRAR_ARTICULOS_BLOG))
        {
            if($MyBlog->delete(addslashes($Tokenizer->decode($id)),addslashes($status)) == REGISTRO_SUCCESS)
            {


            }
            else
            {
		  				$respuesta[] = array("message" => $MyMessageAlert->Message(($status == 1 ? "activar" : "eliminar")."_generico_error"));
            }
        }
        else
        {
             $respuesta[] = array("message" => $MyMessageAlert->Message("sin_privilegios"));
        }

	return $respuesta;
}

function EliminarComentarioBlog($id,$status)
{

	$MyComentarioBlog = new modulos\blog\vendor\model\comentariosBlog();
        global $MyAccessList;
        global $MyMessageAlert;
        $respuesta =null;
        if($MyAccessList->MeDasChancePasar(ADMINISTRAR_COMENTARIOS_ARTICULOS_BLOG))
        {
            if($MyComentarioBlog->delete(addslashes($id),addslashes($status)) == REGISTRO_SUCCESS)
            {


            }
            else
            {
		  $respuesta[] = array("message" => $MyMessageAlert->Message(($status == 1 ? "activar" : "eliminar")."_generico_error"));
            }
        }
        else
        {
             $respuesta[] = array("message" => $MyMessageAlert->Message("sin_privilegios"));
        }

	return $respuesta;
}


function AgregarCalificacionBlog($id,$calificacion)
{
	$MyCalificacionBlog = new modulos\blog\vendor\model\calificacionBlog();
        global $MySession;
        global $MyMessageAlert;
        global $MyAccessList;
        if($calificacion > 5){ $calificacion = 5; }
        if($calificacion <= 0){ $calificacion = 1; }
	if(!isset($_SESSION['count_calificacion']))
	{
		$_SESSION['count_calificacion'] = array();
	}
        if($MyAccessList->MeDasChancePasar(CALIFICAR_ARTICULOS_BLOG))
        {
            if($MyCalificacionBlog->getCalificacionUser($id,$MySession->GetVar('id')) != REGISTRO_SUCCESS)
            {

                    if($MyCalificacionBlog->save(addslashes($id),addslashes($calificacion),addslashes($MySession->GetVar('id')))== REGISTRO_SUCCESS)
                    {
                         $respuesta[] = array("messageSas" => $MyMessageAlert->Message("blog_calificacion_success"));
                         $_SESSION['count_calificacion'][]=$id;
                    }
                    else
                    {
                         $respuesta[] = array("messageErr" => $MyMessageAlert->Message("blog_calificacion_error"));
                    }
            }
            else
            {
                 $respuesta[] = array("messageErr" => $MyMessageAlert->Message("blog_ya_calificado"));
            }
        }
        else
        {
             $respuesta[] = array("message" => $MyMessageAlert->Message("sin_privilegios"));
        }




	return $respuesta;
}

function descartarBorradorBlog($id,$status)
{

				$BorradorblogModel = new \modulos\blog\vendor\model\BorradorblogModel();
				$BorradorblogEntity = new \modulos\blog\vendor\entity\BorradorblogEntity();
        global $MyAccessList;
        global $MyMessageAlert;
         if($MyAccessList->MeDasChancePasar(ADMINISTRAR_ARTICULOS_BLOG))
        {
						$BorradorblogEntity->id_blog($id);

            if($BorradorblogModel->eliminar($BorradorblogEntity->getArrayCopy()) == REGISTRO_SUCCESS)
            {


            }
            else
            {
		  				$respuesta[] = array("message" => $MyMessageAlert->Message(($status == 1 ? "activar" : "eliminar")."_generico_error"));
            }
        }
        else
        {
             $respuesta[] = array("message" => $MyMessageAlert->Message("sin_privilegios"));
        }

	return $respuesta;
}

/******************************** EJECUTA *************************/

$MyAjax->register("EliminarCategoriaBlog");
$MyAjax->register("EliminarArticuloBlog");
$MyAjax->register("EliminarComentarioBlog");
$MyAjax->register("AgregarCalificacionBlog");
$MyAjax->register("descartarBorradorBlog");
?>
