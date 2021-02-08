# **JoJoGenda** #

![Con titulo](/public/resources/Markdown/header.png "titulo")
Aplicaccion que funciona como una _Agenda_, es decir teniendo diferentes secciones con diferentes categorias de contactos.

Inspirada en el anime **JoJo Bizarre adventure**

## Autores ##
| Nombre | Apellidos |
|--------|-----------|
| Jesus Enrique | Rozas Pena |
|||

## Tecnologias Usadas en el Proyecto ##
- Usado en base symfony
    - usando plantillas de html.twig
    - bootstrap

## Usabilidad del proyecto ##
- **Explicacion Codigo**
  
La agenda, tendra diferentes tipos, dependiendo de la imagen, ira a un tipo de agenda diferente.
![Con titulo](/public/resources/Markdown/tipo.png "titulo")
- Todas las agendas tienen los mismos estilos, heredando de la misma base.html.twig
~~~
       <div class=" mt-5 contenido" id="page_container">
        {% block contain %}
            {% endblock %}
        </div>
~~~

- En **base.html.twig**, dejamos el contain vacio para que al usarlo en las demas plantillas, no tengamos que realizar nada de lo hecho anteriormente, es decir tendremos el __header, el navbar y el footer__.

~~~
    {% extends 'base.html.twig' %} 
~~~
    
- **En todos los demas archivos tendremos que añadir este codigo, y añadir codigo en el block contain**


+ ## Funcionalidad ##

En el navbar, habra diferentes enlaces, para ir a cada parte de la pagina, en el lado derecho se encontrara el link para redireccionarnos a un enlace para que podamos agregar diferentes contactos. Los campos que no se podran repetir seran telefono y correo. 
    -El codigo se encontrara en el controlador principal de nuestra aplicaccion.
~~~
 /**
     * @Route("/crear", name="crear")
     */
    public function crear(Request $request):Response{
        $persona = new Persona();
        
        $form = $this->createForm(PersonaType::class, $persona);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $persona = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($persona);
            $entityManager->flush();
            return $this->render('persona/contacto_success.html.twig');
        }
        return $this->render('persona/new.html.twig',[
            'form' => $form->createView(),
        ]);
            
    }
~~~

Al pulsar cada una de las imagenes nos saldra una lista que nos permitira ver todos los contactos que insertamos en nuestra BBDD,  en todas sera de la misma forma, lo unico que tendran diferentes son las imagenes que apareceran al lado izquierdo de cada registro

 + **Personal**
    + ![Con titulo](/public/resources/Markdown/lista.png "titulo")



 + **Global**
    + ![Con titulo](/public/resources/Markdown/lista1.png "titulo")


 + **Profesional**
    + ![Con titulo](/public/resources/Markdown/lista2.png "titulo")
  
Al pusar en los botones que **que estan en el lado derecho** no redireccionaran a diferentes paginas, el primero que es **Mostrar mas**, nos llevara una pagina para poder ver su informacion mas a detalle. Este codigo se realiza en el controller principal.
~~~
/**
     * @Route("/mostrar/{id}", name="mostrar")
     */
    public function mostrar(int $id, PersonaRepository $personaRepository):Response{
        $persona = $personaRepository
            ->find($id);

            return $this->render('persona/mostrar.html.twig',[
            'persona' => $persona,
        ]);
            
    }
~~~

Y una vez dentro, unicamente podremos ver la informacion y tambien puede **modificar el contacto, generando un formulario con los datos del registro**
~~~
   public function formEditExampleAction(Request $request, int $id,  PersonaRepository $personaRepository)
    {
        $em = $this->getDoctrine()->getManager();
        $persona = $personaRepository
            ->find($id);
        $form = $this->createForm(PersonaType::class, $persona);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->flush();

            return $this->render('persona/contacto_success.html.twig');
                }

        return $this->render('persona/edit.html.twig',[
            'form' => $form->createView()
        ]);
    }
~~~

Aparte de poder modificar el contacto al lado del boton de visualizar mas datos, podremos borrar el registro, como en el caso anterior **lo definiremos en el controller**
~~~
   /**
     * @Route("/borrar/{id}", name="borrar")
     */
    public function borrar(int $id, PersonaRepository $personaRepository, Persona $persona):Response{
        
            if (!$persona) {
                throw $this->createNotFoundException('No guest found');
            }
        
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($persona);
            $entityManager->flush();
        
            return $this->render('persona/contacto_success.html.twig');
        
            
    }
~~~ 

## Como contribuir al proyecto ##
+ Podreis contribuir con estre proyecto podreis utilizar el github para editarlo, https://github.com/JesusEnriqueHTML
    - o enviar a mi correo personal jerozpen@gmail.com

## Licencia ##
La licencia utilizada en este proyecto es CC BY-NC-SA
  ![Con titulo](/public/resources/licencia.png "titulo")







