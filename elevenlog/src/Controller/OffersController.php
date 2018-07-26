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
  // Puis on fait les methodes ainsi que les chemins que nous allons appeller pour avoir nos resultats, les endpoints.
  // La methode index sera donc appelle sur la route /offers.

    /**
     * @Route("/", name="offers_index")
     * @Method("GET")
     */
    public function index(OffersRepository $offersRepository): Response
    {
      // Symfony 4 nous permet d'avoir ce que l'on appelle des Repository.
      // Grace a eux, on a directement acces au donnees de notre Entitie Offers.

      // La methode index sert a renvoyer une liste des offres, contenu donc dans notre base de donnees.

      // D'abord on recupere toute les offres.
        $offers = $offersRepository->findAll();

      // Puis on les serialize en JSON pour pouvoir les transmettres.
        $data = $this->get('serializer')->serialize($offers, 'json');

      // On fait une nouvelle reponse, dans lequelle on va pouvoir y donne quelque information pour le header.
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

      // Et pour finir on retourne nos donnees en JSON sur le endpoints.
        return $response;
    }

    // La methode new sert a creer de nouvelles offres.
    // On va donc pas envoyer mais recuperer des donnees en JSON que nous allons pouvoir traiter puis instaurer dans la base de donnees.
    // Ici la route sera /offers/new

    /**
     * @Route("/new", name="offers_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
      // On cree une nouvelle Entite Offers pour utiliser ses methodes.
        $offer = new Offers();

      // On recupere les donnees envoyer par le front.
    		$data = $request->getContent();
        // die($data);

      // Etant en JSON, on le decode tout simplement.
    		$data = json_decode($data);

      // On appelle manager pour pouvoir faire le lien entre le repository et l'entite.
    		$manager = $this->getDoctrine()->getManager();

      // On prepare les valeurs.
    		foreach($data as $key => $value) {
    			$set = 'set' . ucfirst($key);
    			$offer->{$set}($value);
    		}

      // On les instaure a l'offre.
    		$manager->persist($offer);
      // Et on envoie le tout a la base de donnees.
    		$manager->flush();
      // Le front voulant un retour, on recupere l'id de l'article cree.
    		$id = $offer->getId();
      // Puis on envoie le tout, avec le status 201 pour dire qu'il y  a bien une offre de cree.
    		return new Response($id, Response::HTTP_CREATED);
    }

    // La methode show, renvoie une offre particuliere par rapport a celle demande par le front.
    // Il faut donc qu'elle recupere l'id de cette offre en quesiton, pour la chercher dans la base de donnees.

    /**
     * @Route("/{id}", name="offers_show", methods="GET")
     */
    public function show(Offers $offer): Response
    {
      // On la serialize en JSON.
        $data = $this->get('serializer')->serialize($offer, 'json');
    		$response = new Response($data);
      // On precise le header.
    		$response->headers->set('Content-Type', 'application/json');
      // Puis on l'envoie au front.
    		return $response;
    }

    // La methode edit permet de modifier une offre.
    // Elle recupere donc l'id de l'offre a update et les valeurs a change, puis la modifie.

    /**
     * @Route("/{id}/edit", name="offers_edit", methods="GET|POST|PUT")
     */
    public function edit(Request $request, Offers $offer): Response
    {
    // On recupere les nouvelles valeurs.
      $data = $request->getContent();
    // Etant en JSON, on le decode tout simplement.
      $data = json_decode($data);
    // On appelle manager pour pouvoir faire le lien entre le repository et l'entite.
      $manager = $this->getDoctrine()->getManager();
    // On prepare les valeurs.
      foreach($data as $key => $value) {
        if($value != NULL)
        {
          $set = 'set' . ucfirst($key);
          $offer->{$set}($value);
        }
      }

    // On modifie l'offre.
      $manager->persist($offer);
    // Et on envoie le tout a la base de donnees.
      $manager->flush();
    // Le front voulant un retour, on recupere l'id de l'article cree.
      $id = $offer->getId();
    // Puis on envoie le tout, avec le status 202 pour dire que tout c'est bien passe.
      return new Response(var_dump($offer), Response::HTTP_ACCEPTED);
    }

    // La derniere methode delete sert tout simplement a supprimer une offre.
    // On recupere donc l'id de l'offre envoye par le front et on la supprime.

    /**
     * @Route("/{id}", name="offers_delete", methods="DELETE")
     */
    public function delete(Request $request, Offers $offer): Response
    {
   // On appelle manager pour pouvoir faire le lien entre le repository et l'entite.
      $em = $this->getDoctrine()->getManager();
   // On supprime l'offre demande.
      $em->remove($offer);
   // On l'applique a la base de donnee.
      $em->flush();
   // On retourune une reponse avec le status 204 pour signaler le fait qu'il n'y a plus rien.
      return new Response('Supprimer',Response::HTTP_NO_CONTENT);
    }
}
