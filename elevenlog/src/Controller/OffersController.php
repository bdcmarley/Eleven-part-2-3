<?php

namespace App\Controller;

// On importe les dependances dont nous allons avoir besoins.
use App\Entity\Offers;
use App\Form\OffersType;
use App\Repository\OffersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use JMS\Serializer\SerializationContext;

// On definit la route principale sur laquelle on va pouvoir agir
/**
 * @Route("/offers")
 */
class OffersController extends Controller
{
    // Puis on fait les methodes et leurs chemins que nous allons appeller pour avoir nos resultats, les endpoints.
    // La methode index sert a renvoyer une liste des offres, contenu donc dans notre base de donnees.

    /**
    * @Route("/", name="offers_index")
    * @Method("GET")
    */
    public function index(OffersRepository $offersRepository): Response
    {
        // On recupere les offres et les serialize en JSON.
        $offers = $offersRepository->findAll();
        $offers_json = $this->get('serializer')->serialize($offers, 'json');

        // Puis on informe le header et les envoies au endpoints.
        $response = new Response($offers_json,  201);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    // La methode new sert a creer de nouvelles offres.
    // On va recuperer des donnees en JSON que nous allons pouvoir traiter puis instaurer dans la base de donnees.
    /**
    * @Route("/new", name="offers_new", methods="POST")
    */
    public function new(Request $request): Response
    {
        // On recuperee nos donnees pour la creation de l'offre.
        $donnee_offer = json_decode($request->getContent(), true);
        $offer = new Offers();

        // On creer un fomulaire dans lequelle on va y apporter nos donneer
        $form = $this->createForm(OffersType::class, $offer);
        $form->setData($donnee_offer);
        $form->submit($donnee_offer);

        // Si le fomulaire est envoyer et valider, on met le tout dans la base de donnees
        if($form->isSubmitted() && $form->isValid())
        {
            $database = $this->getDoctrine()->getManager();
            $database->persist($offer);
            $database->flush();
            return new Response('Tout est dans la database !', Response::HTTP_CREATED);
        }

        // Sinon, on previent le client
        $validator = $this->get('validator');
        $errors = $validator->validate($offer);

        return new Response(var_dump($donnee_offer), Response::HTTP_BAD_REQUEST);
    }

    // La methode show, renvoie une offre particuliere par rapport a celle demande par le front.
    // Il faut donc qu'elle recupere l'id de cette offre en question, pour la chercher dans la base de donnees.

    /**
    * @Route("/{id}", name="offers_show", methods="GET")
    */
    public function show(Offers $offer): Response
    {
        // On recupere l'id de l'offre a renvoyer, puis en l'envoie en JSON.
        if (!$offer) {
            throw $this->createNotFoundException(sprintf(
                ' L\' offre n\' a pas ete trouver :('
            ));
        }

        $offer = $this->get('serializer')->serialize($offer, 'json');
    		$response = new Response($offer, 200);
    		$response->headers->set('Content-Type', 'application/json');
    		return $response;
    }

    // La methode edit permet de modifier une offre.
    // Elle recupere donc l'id de l'offre a update et les valeurs a change, puis la modifie.

    /**
    * @Route("/{id}/edit", name="offers_edit", methods="PUT")
    */
    public function edit(Request $request, Offers $offer): Response
    {
        if(isset($offer))
        {
            // Si l'offre n'existe pas, on previent le client.
            return new Response("L'offre n'a pas ete trouve :(", 404);
        }

        // On recupere l'id et l'offre de l'offre a traiter, les informations a changer puis on traites celles-ci.
        $donnees_offer = $request->getContent();
        $donnees_offer = json_decode($donnees_offer);

        // On set le tout dans la base de donnees.
        $manager = $this->getDoctrine()->getManager();
        foreach($donees_offer as $key => $value)
        {
            if($value != NULL)
            {
                $set = 'set' . ucfirst($key);
                $offer->{$set}($value);
            }
        }

        $manager->persist($offer);
        $manager->flush();
        $id = $offer->getId();
        return new Response(var_dump($id), 200);
    }

    // La derniere methode delete sert tout simplement a supprimer une offre.
    // On recupere donc l'id de l'offre envoye par le front et on la supprime.

    /**
    * @Route("/{id}", name="offers_delete", methods="DELETE")
    */
    public function delete(Request $request, Offers $offer): Response
    {
        // Ici, nous avons juste a recuperer l'id de l'offre en question et de la supprimer de la base de donnees.
        if(isset($offer))
        {
            // Si l'offre n'existe pas, on previent le client.
            return new Response("L'offre n'a pas ete trouve :(", 404);
        }
        $database = $this->getDoctrine()->getManager();
        $database->remove($offer);
        $database->flush();
        return new Response('Supprimer', 204);
    }
}
?>
