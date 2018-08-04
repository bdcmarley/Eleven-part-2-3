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
        // On recupere nos donnees pour la creation de l'offre.
        $donnee_offer = json_decode($request->getContent(), true);
        $offer = new Offers();

        // On creer un fomulaire dans lequelle on va y apporter nos donnees
        $form = $this->createForm(OffersType::class, $offer, array('csrf_protection' => false));
        // $form->setData($donnee_offer);
        $form->submit($donnee_offer);;

        // Si le fomulaire est envoyer et valider, on met le tout dans la base de donnees
        if($form->isSubmitted() && $form->isValid())
        {
          // die(var_dump($donnee_offer));
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
        // On verifie si l'offre existe.
        if (!$offer)
        {
            throw $this->createNotFoundException(
              new Response("L'offre n'a pas ete trouve :(", 404)
            );
        }

        // Si oui, on envoie les donnees tout simplement.
        $offer = $this->get('serializer')->serialize($offer, 'json');
    		$response = new Response($offer, 200);
    		$response->headers->set('Content-Type', 'application/json');
    		return $response;
    }

    // La methode edit permet de modifier une offre.
    // Elle recupere donc l'id de l'offre a update et les valeurs a change, puis la modifie.
    /**
    * @Route("/{id}/edit", name="offers_edit", methods="PUT|PATCH")
    */
    public function edit(Request $request, Offers $offer): Response
    {
        // On verifie si l'offre existe.
        if (!$offer)
        {
            throw $this->createNotFoundException(
              new Response("L'offre n'a pas ete trouve :(", 404)
            );
        }

        // On recupere nos donnees pour la creation de l'offre.
        $donnees_offer = json_decode($request->getContent(), true);

        // On creer un fomulaire dans lequelle on va y apporter nos donnees
        $form = $this->createForm(OffersType::class, $offer, array('csrf_protection' => false));
        $form->submit($donnees_offer);

        // Si le fomulaire est envoyer et valider, on met le tout dans la base de donnees
        if($form->isSubmitted() && $form->isValid())
        {
            // On set le tout dans la base de donnees.
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($offer);
            $manager->flush();
            $id = $offer->getId();
            return new Response(var_dump($id), 200);
        }

        // Sinon, on previent le client.
        $validator = $this->get('validator');
        $errors = $validator->validate($offer);

        return new Response(var_dump($donnee_offer), Response::HTTP_BAD_REQUEST);
    }

    // La derniere methode delete sert tout simplement a supprimer une offre.
    // On recupere donc l'id de l'offre envoye par le front et on la supprime.
    /**
    * @Route("/{id}", name="offers_delete", methods="DELETE")
    */
    public function delete(Request $request, Offers $offer): Response
    {
        // On verifie si l'offre existe.
        if (!$offer)
        {
            throw $this->createNotFoundException(
              new Response("L'offre n'a pas ete trouve :(", 404)
            );
        }

        // On la supprime, tout simplement.
        $database = $this->getDoctrine()->getManager();
        $database->remove($offer);
        $database->flush();
        return new Response('Supprimer', 204);
    }
}
?>
