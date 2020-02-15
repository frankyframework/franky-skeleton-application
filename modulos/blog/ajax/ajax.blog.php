<?php
function EliminarCategoriaBlog($id,$status)
{

	$MyCategoriaBlog = new Blog\model\categoriasBlog();
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
				$Tokenizer = new \Franky\Haxor\Tokenizer;
				$MyBlog = new Blog\model\Blog();
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

function descartarBorradorBlog($id,$status)
{

				$BorradorblogModel = new \Blog\model\BorradorblogModel();
				$BorradorblogEntity = new \Blog\entity\BorradorblogEntity();
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
$MyAjax->register("descartarBorradorBlog");
?>
