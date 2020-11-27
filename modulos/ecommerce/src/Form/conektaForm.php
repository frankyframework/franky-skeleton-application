<?php
namespace Ecommerce\Form;

class conektaForm extends \Franky\Form\Form
{
    public function __construct($name)
    {

        parent::__construct();

       $this->setAtributos(array(
            'name' => $name,
            'action' => "/ecommerce/admin/tarjetas/submit.php",
            'method' => 'post'
        ));



        $this->add(array(
                'name' => 'card[name]',
                'label' => 'Nombre del tarjetahabiente:',
                'type'  => 'text',
                'required'  => true,
                'atributos' => array(
                    'data-conekta' => 'card[name]',
                    'maxlength' => 250
                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );

        $this->add(array(
                'name' => 'card[number]',
                'label' => 'Número de tarjeta de credito:',
                'type'  => 'text',
                'required'  => true,
                'atributos' => array(
                    'data-conekta' => 'card[number]',
                    'maxlength' => 16
                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );

        $this->add(array(
                'name' => 'card[cvc]',
                'label' => 'CVC:',
                'type'  => 'password',
                'required'  => true,
                'atributos' => array(
                    'data-conekta' => 'card[cvc]',
                    'maxlength' => 3,
                    'placeholder' => '3 o 4 dígitos del reverso',
                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );

        $this->add(array(
                'name' => 'card[exp_month]',
                'label' => 'Mes de expiración (MM):',
                'type'  => 'select',
                'required'  => true,
                'atributos' => array(
                    'data-conekta' => 'card[exp_month]',
                 ),
                'options' => array(
                    '01' => '01',
                    '02' => '02',
                    '03' => '03',
                    '04' => '04',
                    '05' => '05',
                    '06' => '06',
                    '07' => '07',
                    '08' => '08',
                    '09' => '09',
                    '10' => '10',
                    '11' => '11',
                    '12' => '12',
                     
                  ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );

        $this->add(array(
                'name' => 'card[exp_year]',
                'label' => 'Año de expiración (AAAA):',
                'type'  => 'select',
                'required'  => true,
                'atributos' => array(
                    'data-conekta' => 'card[exp_year]',
                 ),
             'options' => array(
                    date('Y') => date('Y'),
                    date('Y')+1 => date('Y')+1,
                    date('Y')+2 => date('Y')+2,
                    date('Y')+3 => date('Y')+3,
                    date('Y')+4 => date('Y')+4,
                    date('y')+4 => date('Y')+5,
                    date('y')+4 => date('Y')+6,
                    date('y')+4 => date('Y')+7

                  ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );


        $this->add(array(
                'name' => 'pagar',
                'type'  => 'submit',
                'atributos' => array(
                    'class'       => 'btn btn-primary btn-big float_right',
                    'value' => "¡Pagar ahora!"
                 )

            )
        );

    }


    function addCheckGuardar()
    {
         $this->add(array(
                'name' => 'save',
                'label' => 'Guardar tarjeta:',
                'type'  => 'checkbox',
                'required'  => false,
                'options' =>array("1" => "Guardar tarjeta")

            )
        );
    }

    function addAntifraude()
    {
        $this->add(array(
                'name' => 'guardar_tarjeta',

                'type'  => 'checkbox',
                'required'  => false,
                'atributos' => array(

                 ),

            )
        );

        $this->add(array(
                'name' => 'card[address][street2]',
                'label' => 'Colonia:',
                'type'  => 'text',
                'required'  => true,
                'atributos' => array(
                    'data-conekta' => 'card[address][street2]',
                    'maxlength' => 250
                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );

        $this->add(array(
                'name' => 'card[address][city]',
                'label' => 'Ciudad:',
                'type'  => 'text',
                'required'  => true,
                'atributos' => array(
                    'data-conekta' => 'card[address][city]',
                    'maxlength' => 250
                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );

        $this->add(array(
                'name' => 'card[address][state]',
                'label' => 'Estado:',
                'type'  => 'text',
                'required'  => true,
                'atributos' => array(
                    'data-conekta' => 'card[address][state]',
                    'maxlength' => 250
                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );

         $this->add(array(
                'name' => 'card[address][zip]',
                'label' => 'Código postal:',
                'type'  => 'text',
                'required'  => true,
                'atributos' => array(
                    'data-conekta' => 'card[address][zip]',
                    'maxlength' => 250
                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );

        $this->add(array(
                'name' => 'card[address][country]',
                'label' => 'Pais:',
                'type'  => 'text',
                'required'  => true,
                'atributos' => array(
                    'data-conekta' => 'card[address][country]',
                    'maxlength' => 250
                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );


    }
}
?>
