<?php
// src/Controller/LuckyController.php
namespace App\Controller;
//imports de los elementos que vamos utilizar
use App\Entity\Persona;
use App\Form\PersonaType;
use App\Repository\PersonaRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Form\Type\YourEntityFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


//Definimos la clase y desde donde extiende
class ContactoController extends AbstractController {
    /**
     * @Route("/", name ="index")
     */
    public function index():Response{
        /* Renderizamos el index que sera la pagina principal que utilizaremos */
        return $this->render('index.html.twig');
    }

    /**
     * @Route("/crear", name="crear")
     */
    public function crear(Request $request):Response{
/* Funcion para crear personas en el formulario */
        $persona = new Persona();
/* Creamos un formulario, con las propiedades de la entidad persona  */
        $form = $this->createForm(PersonaType::class, $persona);
        $form->handleRequest($request);
/* Si los datos del formulario son correctos renderizamos otro html y añadimos el resultado a mysqlite */
        if($form->isSubmitted() && $form->isValid()){
            $persona = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($persona);
            $entityManager->flush();
            return $this->redirectToRoute('mostrar', ['id' =>$persona -> getId(),]);
                }
        /* html donde ponemos el formulario para poder crear una nueva persona */
        return $this->render('persona/new.html.twig',[
            'form' => $form->createView(),
        ]);
            
    }

    /**
     * @Route("/list/{type}", name="list")
     */
    public function list(Request $request, $type):Response{
/* Funcion para listar todos los usuarios */
/* Creamos una comparacion para saber que tipo de contacto sera */
        if($type == 'global'){
            $persona = $this->getDoctrine()
            /* Si el contacto es global, buscaremos todos los contactos*/
            ->getRepository(Persona::class)
            ->findAll();

        }else{
            $persona = $this->getDoctrine()
            ->getRepository(Persona::class)
            /* Si queremos buscar de un tipo en especifico, buscaremos por el tipo, que sera el nombre que le damos en la entidad */
            ->findBy(['tipo' => $type]);
        }
            return $this->render('persona/list.html.twig',[
            'list'=>$persona,
            'type'=>$type,
        ]);
            
    }
     /**
     * @Route("/mostrar/{id}", name="mostrar")
     */
    public function mostrar(int $id, PersonaRepository $personaRepository):Response{
        /* Funcion para mostrar mas detalles de cada uno de los contactos */
        $persona = $personaRepository
        /* Buscamos las personas por su id, para poder enviarla al twig */
            ->find($id);

            return $this->render('persona/mostrar.html.twig',[
            'persona' => $persona,
        ]);
            
    }
    /**
     * @Route("/borrar/{id}", name="borrar")
     */
    public function borrar(int $id, PersonaRepository $personaRepository, Persona $persona):Response{
        /* Funcion para borrar contactos */
            if (!$persona) {
                /* Si no existe, dara un mensaje de error */
                throw $this->createNotFoundException('No guest found');
            }
        
            $entityManager = $this->getDoctrine()->getManager();
            /* Si existe, se borra el contacto y se envia la solicitud a la base de datos */
            $entityManager->remove($persona);
            $entityManager->flush();
        
            return $this->render('persona/contacto_success.html.twig');
        
            
    }

   /**
     * @Route("/edit/{id}", name="edit")
     */
    public function formEditExampleAction(Request $request, int $id,  PersonaRepository $personaRepository)
    {
        /* Funcion para editar, tenemos que buscar las personas por el id */
        $em = $this->getDoctrine()->getManager();
        $persona = $personaRepository
            ->find($id);
        $form = $this->createForm(PersonaType::class, $persona);

        $form->handleRequest($request);
        /* Al igual que en el primero, creamos un formulario, y renderizamos el html que nos indicar que la funcion se a realizado */
        if ($form->isSubmitted() && $form->isValid()) {

            $em->flush();

            return $this->redirectToRoute('mostrar', ['id' =>$persona -> getId(),]);
        
        }

        return $this->render('persona/edit.html.twig',[
            'form' => $form->createView()
        ]);
    }
    

    
    
    
    








}