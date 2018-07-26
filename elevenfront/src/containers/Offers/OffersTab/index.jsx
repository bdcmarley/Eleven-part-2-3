import React from 'react';
import PropTypes from 'prop-types';
import Offer from '../Offer';

// Ce component sers juste a bien utiliser le systeme de component.
// On a recu les donnees, on les envoie ici pour etablir un tableaux qui contiendra toute les offres,
// puis on les envoie a offers pour etablir chaque offres du tableau.

class OffersTab extends React.Component {

// Sachant que l'on va juste recuperer et renvoyer des props a un autre component,
// on le signal lors du consctructor.
    constructor(props) {

        super(props);
    }

// On renvoie les donnees en props dans un autre components.
    render() {
      // La function map est une boucle, qui va boucler sur toute les offres,
      // On appelle donc un component qui va cree chaque offre envoye.
        const offersList = this.props.offers.map(offer =>
            <Offer offer={offer} key={offer.id}/>
        );

        return (
            <div>
              {offersList}
            </div>
        );
    }
}

// Les props Types servent a precicer quel type de props le component s'aprette a recevoir.
OffersTab.propTypes = {
    offers: PropTypes.array
};

export default OffersTab;
