<?php
function makeHTMLCategoriasBlog( $type="interface")
{
    $MyCategoriaBlog = new Blog\model\categoriasBlog();
    $MyCategoriaBlog->setTampag(1000);
    $MyCategoriaBlog->setOrdensql("nombre ASC");
    $MyCategoriaBlog->getData();
    $total			= $MyCategoriaBlog->getTotal();
    $categorias = array();

    if($total > 0)
    {

        while($registro = $MyCategoriaBlog->getRows())
        {
            $categorias[($type == "interface" ? $registro["friendly"] : $registro['id'])] = $registro["nombre"];
	}
    }
    return $categorias;
}


function _blog($txt)
{
    return dgettext("blog",$txt);
}


function previewBlog($txt)
{
    $data = array();
    $doc = new \DOMDocument();
    $doc->loadHTML($txt);
    $_p = "";
    $img = "";
    $p = $doc->getElementsByTagName('p');
    foreach ($p as $_p) {
            $data["p"] = limitePalabras(getCoreConfig('blog/articulo/descripcion-length'),strip_tags($doc->saveHTML()));
            break;
    }

    $images = $doc->getElementsByTagName('img');
    foreach ($images as $image) {
            $data["img"] = $image->getAttribute('src');
            break;
    }

    return $data;

}


function getMenuCategoriasBlog()
{
    global $MySession;
    global $MyRequest;
    $MyCategoriaBlog = new Blog\model\categoriasBlog();
    $MyCategoriaBlog->setOrdensql("nombre ASC");
    $MyCategoriaBlog->setTampag(1000);
    $MyCategoriaBlog->getData('',1);
    $total = $MyCategoriaBlog->getTotal();

    $html = "";
    $html = "<ul>";
    if($total > 0)
    {


            while($registro = $MyCategoriaBlog->getRows())
            {
                $permisos = json_decode($registro['permisos'],true);
                if(empty($permisos)):
                $html .= "<li><a href=\"".$MyRequest->url(BLOG_CATEGORIA,array("categoria" => $registro["amigable_categoria"]))."\">".$registro["nombre"]."</a></li>";
                else:
                    if(in_array($MySession->GetVar('nivel'),$permisos))
                    {
                        $html .= "<li><a href=\"".$MyRequest->url(BLOG_CATEGORIA,array("categoria" => $registro["amigable_categoria"]))."\">".$registro["nombre"]."</a></li>";

                    }
                endif;

            }
    }
    $html .= "</ul>";

    return $html;

}

function getMenuArticulosBlog($cat = "")
{
    global $MyRequest;

    $MyBlog = new Blog\model\Blog();
    $MyBlog->setOrdensql("titulo ASC");
    $MyBlog->setTampag(10);
    $MyBlog->getData('',"","","",1);
    $total = $MyBlog->getTotal();

    $html = "";
    $html = "<ul>";
    if($total > 0)
    {


            while($registro = $MyBlog->getRows())
            {

                $html .= '<li>


                                <a href="'.$MyRequest->url(BLOG_DETALLE,array("categoria" => $registro["amigable_categoria"],"articulo" => $registro["friendly"])).'">
                                    '.$registro["titulo"].'
                                </a>

                        </li>';

            }
    }
    $html .= "</ul>";

    return $html;

}



function calificacionStars($cal)
{
	if ($cal >= 5.0)
	{
		$cal= 5.0;
	}
	if ($cal <= 0)
	{
		$cal= 0;
	}

        $alt = $cal;
        $html = "";
	for($x=1; $x <= 5; $x++)
	{
		if($cal <= 0)
		{
			$html .= "<div class='estrella_vacia'></div>";
		}
		elseif($cal > 0 && $cal < .4)
		{
			$html .= "<div class='estrella_vacia'></div>";
			$cal = 0;
		}
                elseif($cal == .5)
		{
			$html .= "<div class='estrella_media'></div>";
			$cal = 0;
		}
                elseif($cal >.5 && $cal < 1)
		{
			$html .= "<div class='estrella_completa'></div>";
			$cal = 0;
		}
                elseif($cal >= 1)
		{
			$html .= "<div class='estrella_completa'></div>";
			$cal--;
		}
	}

	return $html;
}


function prevArticuloBlog($id){
    global $MyRequest;
    global $MyConfigure;
  $MyBlog = new \Blog\model\Blog();
  $blog_detalle = array();
  if($MyBlog->getData($id, "","","",1,"","",1)== REGISTRO_SUCCESS)
  {
      $registro = $MyBlog->getRows();

      $blog_detalle = array(
      "id"                => $registro["id"],
      "titulo"            => $registro["titulo"],
      "link"              => $MyRequest->url(BLOG_DETALLE,array("categoria" => $registro["amigable_categoria"],"articulo" =>$registro["friendly"]))
      );
  }

  return $blog_detalle;
}

function nextArticuloBlog($id){
    global $MyRequest;
  $MyBlog = new \Blog\model\Blog();
  $blog_detalle = array();
  if($MyBlog->getData($id, "","","",1,"",1)== REGISTRO_SUCCESS)
  {
      $registro = $MyBlog->getRows();
      $blog_detalle = array(
      "id"                => $registro["id"],
      "titulo"            => $registro["titulo"],
      "link"              => $MyRequest->url(BLOG_DETALLE,array("categoria" => $registro["amigable_categoria"],"articulo" =>$registro["friendly"]))
      );
  }

  return $blog_detalle;

}
?>
