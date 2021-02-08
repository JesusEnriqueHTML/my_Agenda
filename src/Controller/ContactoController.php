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
        return $this->render('index.html.twig');
    }

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

    /**
     * @Route("/list/{type}", name="list")
     */
    public function list(Request $request, $type):Response{
        if($type == 'global'){
            $persona = $this->getDoctrine()
            ->getRepository(Persona::class)
            ->findAll();

        }else{
            $persona = $this->getDoctrine()
            ->getRepository(Persona::class)
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
        $persona = $personaRepository
            ->find($id);

            return $this->render('persona/mostrar.html.twig',[
            'persona' => $persona,
        ]);
            
    }
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

   /**
     * @Route("/edit/{id}", name="edit")
     */
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
    

    
    
    
    








}