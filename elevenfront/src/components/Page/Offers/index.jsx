// On importe les fichiers/librairies.
import React from 'react';
import axios from 'axios';
import './style.scss';

// Et ici le components que l'on va pouvoir utiliser par la suite.
import OffersTab from 'containers/Offers/OffersTab';

// L'index est la page ou toute mes offers seront affichees.
class Offers extends React.Component {

// Un component est toujours etablis avec un constructor et ca function super.
    constructor() {
        super();
        // Ici, on va preparer une state offers, vide en premier lieu.
        this.state = {
          offers: []
        };
    }

// Cette function est une function predefinit par React.
// A chaque fois au'une state est initialise, le render est a nouveau fait.
// Donc la page charge une premiere fois et appelle une premiere fois le render avec des states vides.
// Puis, grace a cette function qui se lance une fois que le premier render se fait, on y instaure de nouvelles states.
// Les states initialisees, le render se relance avec les bonnes valeurs.
    componentDidMount() {
      // axios va donc nous permettre de faire nos requetes a L'API.
      // Ici, on veut juste recuperer une liste de toute les offres qu'on a.
      // On va donc utiliser la methode GET, ainsi que la route correspondante a celle-ci.
        axios.get('/offers/')
            .then(result => {
              // Une fois la requete faite, l'api nous renvoie donc des donnees.
              // On les recuperes et les instaurons dans le tableau offers, precedemment cree pendant le consctructor, dans le state.
                this.setState({ offers: result.data });
            });
    }

// Le render est indispensable dans les components.
// On ne peut envoyer plusieurs elements, tout doit etre mis dans un seul element.
    render() {
        return (
          // On cree donc la div qui encadrera le tout.
          // On envoie en props les donnes recuperees depuis l'API pour les traiter ailleurs plus en details.
            <div className="container_offers">
              <a href="/create_offers">Creer une offre</a>
              <OffersTab offers={this.state.offers}/>
            </div>
        );
    }
}

export default Offers;
