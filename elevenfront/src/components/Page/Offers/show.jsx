import React from 'react';
import axios from 'axios';
import './style.scss';

import OneOffer from 'containers/Offers/Offer/OneOffer';

// Ici, on ne verra que l'offre sur laquelle on a clique.
class Show extends React.Component {

    constructor() {
        super();

        this.state = {
          offers: []
        };
    }

    componentDidMount() {
        // Pour acceder a cette offre en particulier, on va recuperer son id dans l'url, qui est donc en derniere parametre.
        var url = window.location.href.split('/');
        url = '/offers/' + url[4];
        // On l'envoie en get, on s'attend donc a recevoir les donnees de l'offre.
        axios.get(url)
            .then(result => {
            // On les recupere est les sets dans un tableau dans state.
                this.setState({ offers: result.data
                });
            });
    }

    render() {
        // Sachant que le render va vouloir envoye une premiere fois un state vide, on fait un condition.
        // Si la state id existe, alors on l'envoie au component.
        // On apelle le component qui va s'occuper de l'affiche de notre offre.
        if(this.state.offers.id)
        {
            return (
                <div className="container_offers">
                    <a href="/offers">Home</a>
                    <OneOffer offer={this.state.offers}/>
                  </div>
            );
        } else {
            return (
                <div></div>
            );
        }
    }
}
export default Show;
